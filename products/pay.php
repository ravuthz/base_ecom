<?php

    require_once "../Configuration.php";
    require_once "../includes/views/header.php";

    $pid = 0;
    $oid = input_get('oid', 0);
    $today = date("Y-m-d H:i:s");

    $sql = 'SELECT * FROM pays ORDER BY id DESC';

    $pay_items = $db->query($sql, array('id' => $auth->user()->id))->all();

    if ($pid = input_get('pid')) {
        $product = $db->query('SELECT * FROM pic WHERE id = :id', array('id' => $pid))->one();
    }



    if (input_has('confirm') && $oid > 0) {
        $pay = (object) array(
            'date' => $today,
            'order_id' => $oid,
            'buyer_id' => $auth->user()->id,
            'buyer_status' => '',
            'seller_id' => '',
            'seller_status' => 0,
            'note' => ''
        );
    }



?>

<div class="container">

    <div class="row">

    <div class="col-md-3">

        <?php require_once "../includes/views/sidebar.php"; ?>

    </div>

        <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><?php link_to('', 'Site'); ?></li>
                        <li class="active">Products</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php session_flash_alerts(); ?>
                </div>
            </div>

            <?php if (!empty($product)): ?>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Current Product: <small></small></h3>
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
                            </div>
                            <div class="col-md-4">
                                <img class='img-thumbnail' src='<?php base_link('images/' . $product['name']); ?>' />
                            </div>
                        </div>

                        <form class="form" method="post">
                            <input type="hidden" name="seller_id" value="<?php echo $product['m_id']; ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="note">Note: </label>
                                      <textarea name="note" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="radio-inline">
                                      <label>
                                          <input type="radio" name="buyer_status" value="0">
                                          Not Now
                                      </label>
                                    </div>
                                    <div class="radio-inline">
                                      <label>
                                          <input type="radio" name="buyer_status" value="1">
                                          Paid Now
                                      </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="submit" value="Submit Pay" class="btn btn-sm btn-success"/>
                                    <?php link_to('products', 'Back to Product List', 'class = "btn btn-sm btn-default"'); ?>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

            <?php if (!empty($pay_items)): ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>Unconfirmed Items</h3>
                                    <hr/>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Picture</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pay_items as $pro): ?>
                                                <tr>
                                                    <td><img class='img-thumbnail' src='<?php base_link('images/' . $pro['name']); ?>' /></td>
                                                    <td><?php echo $pro['b_name']; ?></td>
                                                    <td><?php echo $pro['b_price']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <?php if (!$saved): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php link_to('products/cart.php?clear=all', 'Clear all items form cart', 'class = "label label-danger"'); ?>
                                                <span> or </span>
                                                <?php link_to("products/cart.php?pid=$pid&confirm=true", 'Save these ordered items to your cart.', 'class = "label label-success"'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>





        </div>

    </div>

</div>

<?php require_once "../includes/views/footer.php"; ?>
