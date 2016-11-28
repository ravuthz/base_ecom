<?php

include '../config.php';

if ($id = input_get('id')) {
    $category = $db->selectOneObject('categories', $id);
} else {
    session_set('failure', "Category id = $id does not exists");
    redirect('categories');
}

if (empty($category)) {
    session_set('failure', 'Category does not exists');
    redirect('categories');
}

if (!$auth->isAdmin()) {
    session_set('failure', "You don't have permission to update this category (id: $id)");
    redirect('categories');
}

if (input_post('submit')) {

    $uploader = new Upload();
    $upload = $uploader->imageOnly('photo', PATH_IMG);

    if ($errors = $upload->errors()) {
        session_set('failure', implode('<br/>', $errors));
    } else {
        $ok = $db->updateById('categories', $id, array(
            'name' => input_post('name'),
            'note' => input_post('note'),
            'photo' => $upload->file('name')
        ));

        if ($ok) {
            $category = $db->selectOneObject('categories', $id);
            session_set('success', 'Category update success');
        } else {
            session_set('failure', 'Category update failure');

        }
    }
}

$form_header_text = 'Update Exists Category';
$form_submit_name = 'Update Now';
$form_footer_text = '';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;


