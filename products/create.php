<?php

    include '../config.php';

    $product = new Product();

    if (input_post('submit')) {

        $uploader = new Upload();
        $upload = $uploader->imageOnly('photo', PATH_IMG);

        if ($errors = $upload->errors()) {
            session_set('failure', implode('<br/>', $errors));
        } else {
            $ok = $db->insert('products', array(
                'name' => input_post('name'),
                'note' => input_post('note'),
                'photo' => input_post('photo'),
                'unit_price' => $upload->file('name'),
                'user_id' => $auth->user()->id,
                'category_id' => input_post('category_id')
            ));

            if ($ok) {
                session_set('success', 'Product create success');
            } else {
                session_set('failure', 'Product create failure');
            }
        }

    }

$form_header_text = 'Create New Product';
$form_submit_name = 'Create Now';
$form_footer_text = '';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;


