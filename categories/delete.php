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
    session_set('failure', "You don't have permission to delete this category (id: $id)");
    redirect('categories');
}

if (input_post('submit')) {
    $ok = $db->deleteById('categories', $id);

    if ($ok) {
        $category = new Category();
        session_set('success', 'Category delete success');
    } else {
        session_set('failure', 'Category delete failure');

    }
}

$form_header_text = 'Delete Exists Category';
$form_submit_name = 'Delete Now';
$form_footer_text = '<div class="label label-danger">Are sure want to delete this category?</div>';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;
