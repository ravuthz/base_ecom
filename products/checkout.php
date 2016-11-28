<?php
    include '../config.php';
    include PAGE_HEADER;

    $uid = $auth->user()->id;
    $grandTotal = 0;

    $sqlOrderProducts = 'SELECT o.id, o.date, p.name, p.unit_price, p.photo, i.quantity,
        u.id as seller_id, u.name AS seller_name, u.shop_name, u.shop_address,
		    c.name AS category_name FROM orders o
        LEFT JOIN order_item i ON i.order_id = o.id
        LEFT JOIN products p ON p.id = i.product_id
        LEFT JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE o.user_id = :uid  AND o.id = :oid';

    if ($oid = input_get('oid')) {
        $order = $db->query($sqlOrderProducts, ['uid' => $uid, 'oid' => $oid])->all();
        if (!empty($order)) {
            $firstOrder = $order[0];
        }
        $seller_bank = $db->query('SELECT * FROM banks WHERE user_id = :uid', ['uid' => $firstOrder->seller_id])->one();
        if (empty($seller_bank)) {
            $seller_bank = new Bank();
        }
    }

    if (input_post('submit')) {
        $order1 = $db->selectOneObject('orders', $oid);
        pp($order1);
        $db->updateById('orders', $oid, ['status' => 1]);
        session_set('success', 'This order has beed chekout, wait the seller approve.');

        /*
            update order status to 1
            insert pays
              - date [ current date + time ]
              - note [ the order has been checkout, so the seller need to check that approve ]
              - order_id [ $oid ]
              - bank_id [ $auth_bank->id ]
              - user_id [ $auth_user->id ]

            insert invoices
              - all in invoice so,
              - except [ product ] use [ $oid ]
              - date
              - photo [ can save image or pdf ] (optional)
        */
    }

?>

<?php if (!empty($order)): ?>
    <div class="row">
        <div class="col-sm-12">
            <!-- <div class="panel panel-default"> -->
                <!-- <div class="panel-body"> -->
                    <div class="hidden-print">
                        <h3>
                            Products in Order No.
                            <?php echo $oid; ?>
                        </h3>
                        <hr/>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <br/><b><?php echo $firstOrder->shop_name; ?></b>,
                                <br/><?php echo $firstOrder->shop_address; ?>
                            </p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h1>Invoice</h1>
                            <p class="text-success">
                                <strong>Invoice #: <?php echo date('ymd') . '-' . $oid; ?></strong>

                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            Bill To:
                            <p>
                                <strong><?php echo $seller_bank->name; ?></strong>
                                <br/><?php echo ucwords($seller_bank->account_name); ?>
                                <br><?php echo $seller_bank->book_no; ?>
                            </p>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="text-right">Invoice Date:</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-right"><?php echo date('d M Y'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Phto</th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Seller</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order as $each): ?>
                                    <?php
                                      $subTotal = ($each->quantity * $each->unit_price);
                                      $grandTotal += $subTotal;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php image($each->photo); ?></td>
                                        <td class="text-center"><?php echo $each->name; ?></td>
                                        <td class="text-center"><?php echo ucwords($each->seller_name); ?></td>
                                        <td class="text-center"><?php echo $each->quantity; ?></td>
                                        <td class="text-right"><?php print_usd($each->unit_price); ?></td>
                                        <td class="text-right"><?php print_usd($subTotal); ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                  <th colspan="5" class="text-right">Total</th>
                                  <th class="text-right"><?php print_usd($grandTotal); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="hidden-print">
                        <hr/>
                        <a href="javascript:window.print();" class="btn btn-sm btn-default">
                            Generate and Print Invoice Now
                        </a>
                    </div>


                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
<?php endif;?>

<div class="hidden-print">
    <div class="alert alert-info">
        <p>
            <strong>Note: </strong>
            <ul>
                <li>First you need to <b>print invoice</b> above and paid to bank.</li>
                <li>Then you need to fill the <b>Billing Information</b> below to complete purchasing products.</li>
                <li>Then upload the <b><i>invoice</i></b> after you paid at any bank to validate payment processing.</li>
            </ul>
        </p>
    </div>
    <?php include 'form_bank.php'; ?>
</div>

<?php include PAGE_FOOTER; ?>
