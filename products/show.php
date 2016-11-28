<?php

    include '../config.php';

    if ($pid = input_get('pid')) {
        $product = $db->query('SELECT * FROM pic WHERE id = :id', ['id' => $pid])->one();
    }

    include PAGE_HEADER;

?>

<?php if (!empty($product)): ?>

    <div class="row">
        <div class="col-md-4">
            <img class='img-thumbnail' src='<?php base_link('images/' . $product['name']);?>' />
        </div>
        <div class="col-md-8">
            <div class="">
                <?php echo $product['text']; ?>
            </div>
            <div class="">
                <?php echo $product['b_name']; ?>
            </div>
            <div class="">
                <?php echo $product['b_price']; ?>
            </div>
            <div class="">
                <?php echo $product['seller_tel']; ?>
            </div>
            <div class="">
                <a class="btn btn-sm btn-success" href="rigester.php?action=addToCart&id=<?php echo $product["id"]; ?>">
                    Add to cart
                </a>
                <?php link_to('products', 'Back to Product List', 'class = "btn btn-sm btn-default"');?>
            </div>
        </div>
    </div>

<?php endif;?>

<?php include PAGE_FOOTER;?>
