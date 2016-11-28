<?php

    include '../config.php';
    include PAGE_HEADER;

    $sqlProduct = 'SELECT p.*, u.name AS `user_name`, c.name AS `category_name` FROM products p
        RIGHT JOIN categories c ON c.id = p.category_id
        RIGHT JOIN users u ON u.id = p.user_id';

    $sqlOrderProducts = 'SELECT o.id, o.date, p.name, p.unit_price, p.photo, i.quantity,
        u.name AS user_name, c.name AS category_name FROM orders o
        LEFT JOIN order_item i ON i.order_id = o.id
        LEFT JOIN products p ON p.id = i.product_id
        LEFT JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE o.user_id = :uid';

    $today = date("Y-m-d H:i:s");
    $temp_products = null;
    $order_product = null;
    $order_products = null;
    $uid = $auth->user()->id;
    $init_quality = 1;

    // add products to cart in session
    if ($pid = input_get('pid')) {
        $product = $db->selectOneObject('products', $pid);
        if (!empty($product)) {

            if (session_has('seller_id')) {
                $seller_id = session_get('seller_id');
            } else {
                $seller_id = $product->user_id;
                session_set('seller_id', $seller_id);
            }

            if ($seller_id != $product->user_id) {
                session_set('failure', 'You can not buy from different shop at the same time');
                script_redirect('products');
            }

            if ($seller_id == $uid) {
                session_set('warning', 'You can not buy your own products');
                script_redirect('products');
            }

            $cart = session_get('cart', []);
            $cart[$pid] = $pid;
            session_set('cart', $cart);
        }
    }

    // list products in cart from session
    if ($cart = session_get('cart', [])) {
        if (!empty($cart)) {
          $ids = implode(', ', array_values($cart));
          $temp_products = $db->query("$sqlProduct WHERE p.id IN ( $ids )")->all();
        }
    }

    if (input_has('clear')) {
        session_set('cart', null);
        $temp_products = null;
        session_set('success', 'Cart was clear successfully');
        script_redirect('products/cart.php');
    }

    // complete added products to cart
    if (input_post('submit')) {
        $order_id = $db->insert('orders', [
            'date'    => $today,
            'user_id' => $uid,
            'status'  => 0
        ]);

        if ($order_id && $items = input_post('items')) {
            $totalPrice = 0;

            foreach ($items as $item) {
                $totalPrice += ($item['quantity'] * $item['price']);
                $db->insert('order_item', [
                    'order_id'   => $order_id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity']
                ]);
            }

            session_set('cart', null);
            $temp_products = null;

            session_set('order_id', $order_id);
            session_set('success', 'Products added to shopping cart');
            script_redirect('products/order.php');
        }
    }
    $order_products = $db->query($sqlOrderProducts, ['uid' => $uid])->all();

?>

<?php if (!empty($temp_products)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">

                <h3>All Products in temporary order</h3>

                <hr/>

                <?php form_open('products/cart.php', 'post');?>
                    <table class="table table-bordered" id="temp-products">
                        <thead>
                            <tr>
                                <th width="10%">Photo</th>
                                <th width="65%">Product</th>
                                <th width="10%">Quantity</th>
                                <th width="15%">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($temp_products as $each): ?>
                                <tr
                                    data-id="<?php echo $each->id; ?>"
                                    data-quantity="<?php echo $init_quality; ?>"
                                    data-price="<?php echo $each->unit_price; ?>"
                                    data-total="<?php echo $each->unit_price; ?>">
                                    <?php
                                        form_items($each->id, 'id', $each->id);
                                        form_items($each->id, 'price', $each->unit_price);
                                    ?>
                                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">

                                    <td class="text-center">
                                        <?php image($each->photo);?>
                                    </td>
                                    <td>
                                        <?php echo $each->name; ?>
                                    </td>
                                    <td>
                                        <?php form_items($each->id, 'quantity', $init_quality, 'number', 'class="qty" min="1"');?>
                                    </td>
                                    <td class="text-right">
                                        <?php print_usd($each->unit_price);?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Total</td>
                                <td class="text-right" id="total">
                                    <?php print_usd('1000');?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row">
                        <div class="col-sm-4">
                            <?php link_button('products', 'Continue Shopping', 'btn-block btn-success');?>
                        </div>
                        <div class="col-sm-4">
                            <?php form_submit('Add to chart');?>

                        </div>
                        <div class="col-sm-4">
                            <?php link_button('products/cart.php?clear', 'Clear the cart', 'btn-block btn-danger');?>
                        </div>
                    </div>
                <?php form_close();?>

            </div>
        </div>
    </div>
<?php endif;?>

<?php if (!empty($order_products)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">

                <h3>All Products in order</h3><hr/>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Seller</th>
                        </tr>
                    </thead>
                    <?php foreach ($order_products as $each): ?>
                        <tr>
                            <td><?php echo $each->id; ?></td>
                            <td><?php echo $each->name; ?></td>
                            <td><?php echo $each->user_name; ?></td>
                            <td><?php echo $each->category_name; ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>

<script>
    $(function(){

        var totals = 0;

        $('#temp-products tbody tr').each(function(k,v) {
            var data = $(v).data();
            data.total = data.quantity * data.price;
            totals += data.total;
            $(v).data(data);
        });

        $('#temp-products #total').text('$ ' + totals + '.00');

        $('#temp-products tbody .qty').on('change', function() {
            var totals = 0;
            var table = $(this).parents('table');
            $(this).parents('tr').data('quantity', $(this).val());

            $(table).find('tbody tr').each(function(k,v) {
                var data = $(v).data();
                data.total = data.quantity * data.price;
                totals += data.total;
                $(v).data(data);
            });

            $(table).find('tfoot #total').text('$ ' + totals + '.00');
        });

    });
</script>

<?php include PAGE_FOOTER; ?>
