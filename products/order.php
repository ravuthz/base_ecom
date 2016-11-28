<?php

    include '../config.php';
    include PAGE_HEADER;

    $sqlOrders = 'SELECT o.*, COUNT(i.order_id) AS `count_products` FROM orders o
        LEFT JOIN order_item i ON i.order_id = o.id
        WHERE o.user_id = :uid AND o.status = 0 GROUP BY i.order_id';

    $sqlOrderProducts = 'SELECT o.id, o.date, p.name, p.unit_price, p.photo, i.quantity,
        u.name AS user_name, c.name AS category_name FROM orders o
        LEFT JOIN order_item i ON i.order_id = o.id
        LEFT JOIN products p ON p.id = i.product_id
        LEFT JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE o.user_id = :uid';

    $today = date("Y-m-d H:i:s");
    $order = null;
    $orders = null;

    $uid = $auth->user()->id;

    // show an order and its products with order id from session
    if ($oid = session_get('order_id')) {
        $order = $db->query($sqlOrderProducts . ' AND o.id = :oid', ['oid' => $oid, 'uid' => $uid])->all();
    }

    // show an order and its products with order id from query string
    if ($oid = input_get('oid')) {
        $order = $db->query($sqlOrderProducts . ' AND o.id = :oid', ['oid' => $oid, 'uid' => $uid])->all();
    }

    // list all orders
    $orders = $db->query($sqlOrders, ['uid' => $uid])->all();

?>

<?php if (!empty($order)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <h3>
                    Products in Order No.
                    <?php echo $oid; ?>
                </h3>
                <hr/>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">Photo</th>
                            <th width="70%" class="text-center">Product</th>
                            <th width="20%" class="text-center">Seller</th>
                            <th width="5%" class="text-center">Quantity</th>
                        </tr>
                    </thead>
                    <?php foreach ($order as $each): ?>
                        <tr>
                            <td class="text-center"><?php image($each->photo); ?></td>
                            <td class="text-center class="text-center""><?php echo $each->name; ?></td>
                            <td class="text-center"><?php echo ucwords($each->user_name); ?></td>
                            <td class="text-center"><?php echo $each->quantity; ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
            <?php link_button("products/checkout.php?oid=$oid", 'Checkout this now', 'btn-block btn-success');?>
        </div>
        <div class="col-sm-4">
            <?php link_button('products', 'Go back to products', 'btn-block btn-default');?>
        </div>
    </div>
<?php endif;?>

<?php if (!empty($orders)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <h3>
                    All my orders
                </h3>
                <hr/>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">ID</th>
                            <th width="25%" class="text-center">Date</th>
                            <th width="45%" class="text-center">Products</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($orders as $each): ?>
                        <tr>
                            <td class="text-center"><?php echo $each->id; ?></td>
                            <td class="text-center"><?php echo $each->date; ?></td>
                            <td class="text-center"><?php echo $each->count_products; ?></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm btn-group-justified">
                                    <?php link_button('products/order.php?oid=' . $each->id, 'show', 'btn-primary'); ?>
                                    <?php link_button('products/checkout.php?oid=' . $each->id, 'checkout', 'btn-success'); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
<?php endif;?>

<?php include PAGE_FOOTER; ?>
