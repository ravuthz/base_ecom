<?php
    if ($oid = input_get('oid')) {
        $query = 'SELECT o.id, o.date, p.name, p.unit_price, p.photo, i.quantity,
        u.name AS user_name, c.name AS category_name FROM orders o
        LEFT JOIN order_item i ON i.order_id = o.id
        LEFT JOIN products p ON p.id = i.product_id
        LEFT JOIN users u ON u.id = p.user_id
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE o.user_id = :uid  AND o.id = :oid';
        $params = ['uid' => $auth->user()->id, 'oid' => $oid];
        $order = $db->query($query, $params)->all();
    }
    $grandTotal = 0;
?>
<div class="row">
    <div class="col-sm-12">
        <?php if (!empty($order)): ?>
            <p>

            </p>
            <h3>
                Products in Order No.
                <?php echo $oid; ?>
            </h3>
            <!-- <hr/> -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">Photo</th>
                        <th class="text-center">Product</th>
                        <th width="5%" class="text-center">Quantity</th>
                        <th width="20%" class="text-center">Price</th>
                        <th width="20%" class="text-center">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order as $each): ?>
<?php $subTotal = ($each->unit_price * $each->quantity);?>
<?php $grandTotal += $subTotal;?>
                        <tr>
                            <td class="text-center"><?php image($each->photo);?></td>
                            <td><?php echo $each->name; ?></td>
                            <td class="text-center"><?php echo $each->quantity; ?></td>
                            <td class="text-right"><?php print_usd($each->unit_price);?></td>
                            <td class="text-right"><?php print_usd($subTotal);?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-right" colspan="4">Total</th>
                        <th class="text-right"><?php print_usd($grandTotal);?></th>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            No Order
        <?php endif;?>
    </div>
</div>