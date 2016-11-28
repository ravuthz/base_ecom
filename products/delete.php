<?php

include '../config.php';

if ($id = input_get('id')) {
    $product = $db->selectOneObject('products', $id);
} else {
    session_set('failure', "Product id = $id does not exists");
    redirect('products');
}

if (empty($product)) {
    session_set('failure', "Product (id: $id) does not exists");
    redirect('products');
}

if ($product->user_id != $auth->user()->id) {
    session_set('failure', "You don't have permission to delete this product (id: $id)");
    redirect('products');
}

if (input_post('submit')) {
    $ok = $db->deleteById('products', $id);

    if ($ok) {
        $product = new Product();
        session_set('success', 'Product delete success');
    } else {
        session_set('failure', 'Product delete failure');

    }
}

$form_header_text = 'Delete Exists Product';
$form_submit_name = 'Delete Now';
$form_footer_text = '<div class="label label-danger">Are sure want to delete this product?</div>';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;
