<?php

    include '../config.php';
    include PAGE_HEADER;

    $uid = $auth->user()->id;

    $sqlProduct = 'SELECT p.*, u.username, u.name AS `fullname`,
            c.name AS category_name FROM products p
            LEFT JOIN users u ON u.id = p.user_id
            LEFT JOIN categories c ON c.id = p.category_id WHERE ';

    if ($pid = input_get('pid')) {
        $sql = $sqlProduct . 'p.id = :pid';
        $product = $db->query($sql, ['pid' => $pid])->one();
    }

    if ($cid = input_get('cid')) {
        $sql = $sqlProduct . 'c.id = :cid';
        $products = $db->query($sql, ['cid' => $cid])->all();
    }

    if ($auth->isLoggedIn()) {
        if (input_has('mine')) {
            $sql = $sqlProduct . 'u.id = :uid';
            $products = $db->query($sql, ['uid' => $uid])->all();
        } else {
            $sql = $sqlProduct . 'p.user_id <> :uid';
            $products = $db->query($sql, ['uid' => $uid])->all();
        }
    } else {
        $products = $db->query($sqlProduct . 'p.id > 0')->all();
    }
?>

<?php if (!empty($product)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <?php image($product->photo);?>
                </div>
                <div class="col-sm-8">
                    <h3><?php echo $product->name; ?></h3>
                    <p><strong>Cost: </strong><?php echo $product->unit_price; ?> USD</p>
                    <p><strong>Seller: </strong><?php echo ucwords($product->fullname); ?></p>
                    <p><strong>Category: </strong><?php echo $product->category_name; ?></p>
                    <div class="">
                        <?php link_to('products/order.php?id=' . $product->id, 'Order this product now', 'class ="btn btn-sm btn-success"');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>


<?php if (!empty($products)): ?>
    <div id="product-list">
        <?php foreach (array_chunk($products, 3) as $col3): ?>
            <div class="row">
                <?php foreach ($col3 as $each): ?>
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php image($each->photo);?>
                                <h3><?php echo $each->name; ?></h3>
                                <p><strong>Cost: </strong><?php echo $each->unit_price; ?> $</p>
                                <p><strong>Seller: </strong><?php echo ucwords($each->fullname); ?></p>
                                <p><strong>Category: </strong><?php echo $each->category_name; ?></p>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="btn-group btn-group-sm btn-group-justified">
                                            <?php
                                                link_button('products/cart.php?pid=' . $each->id, 'Add to Cart', 'btn-success');
                                                link_button('products/?pid=' . $each->id, 'View Product', 'btn-info');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endforeach;?>
    </div>
<?php else: ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                There are no any products in stock
            </div>
        </div>
    </div>

<?php endif;?>

<script>
    $(function(){

    });
</script>

<?php include PAGE_FOOTER;?>
