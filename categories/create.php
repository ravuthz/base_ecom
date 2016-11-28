<?php

    include '../config.php';

    $category = new Category();

    if (!$auth->isAdmin()) {
        session_set('failure', "You don't have permission to create new category");
        redirect('categories');
    }

    if (input_post('submit')) {

        $uploader = new Upload();
        $upload = $uploader->imageOnly('photo', PATH_IMG);

        if ($errors = $upload->errors()) {
            session_set('failure', implode('<br/>', $errors));
        } else {
            $ok = $db->insert('categories', array(
                'name' => input_post('name'),
                'note' => input_post('note'),
                'photo' => $upload->file('name')
            ));

            if ($ok) {
                session_set('success', 'Category create success');
            } else {
                session_set('failure', 'Category create failure');
            }
        }
    }

$form_header_text = 'Create New Category';
$form_submit_name = 'Create Now';
$form_footer_text = '';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;


