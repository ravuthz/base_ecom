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
    session_set('failure', "You don't have permission to update this product (id: $id)");
    redirect('products');
}

if (input_post('submit')) {

    $uploader = new Upload();
    $upload = $uploader->imageOnly('photo', PATH_IMG);

    if ($errors = $upload->errors()) {
        session_set('failure', implode('<br/>', $errors));
    } else {
        $ok = $db->updateById('products', $id, array(
            'name' => input_post('name'),
            'note' => input_post('note'),
            'photo' => $upload->file('name'),
            'unit_price' => input_post('unit_price'),
            'user_id' => $auth->user()->id,
            'category_id' => input_post('category_id')
        ));

        if ($ok) {
            $product = $db->selectOneObject('products', $id);
            session_set('success', 'Product update success');
        } else {
            session_set('failure', 'Product update failure');

        }
    }

}

$form_header_text = 'Update Exists Product';
$form_submit_name = 'Update Now';
$form_footer_text = '';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;


