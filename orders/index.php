<?php

    include '../config.php';

    include PAGE_HEADER;

    $sql = 'SELECT p.*, u.username AS `user_name`, c.name AS `category_name` FROM products p
            RIGHT JOIN categories c ON c.id = p.category_id
            RIGHT JOIN users u ON u.id = p.user_id';

    // $uid = $auth->user()->id;

    // if ($oid = input_get('oid')) {
    //     $order_products = $db->query($sql . ' AND o.id = :oid', ['oid' => $oid, 'uid' => $uid])->all();
    // } else {
    //     $order_products = $db->query($sql, ['uid' => $uid])->all();
    // }

    // $orders = $db->selectAllObject('orders');

    if ($pid = input_get('pid')) {
        $product = $db->selectOneObject('products', $pid);

        if (!empty($product)) {
            $items = session_get('items', []);

            $items[$pid] = $pid;

            session_set('items', $items);

            // $ids = implode(', ', array_values($items));
            // if ($ids) {
            //     $temp_products = $db->query("SELECT * FROM pic WHERE id IN ( $ids )")->all();
            // }
        }
    }

?>



<?php

    pp($_SESSION);

    include PAGE_FOOTER;

?>
