<?php

include "../config.php";

if (!$auth->isAdmin()) {
    session_set('failure', "You don't have permission to delete user. Please contact admin.");
    redirect('products');
}

if ($id = input_get('id')) {
    $user = $db->selectOneObject('users', $id);
}

if (input_post('submit')) {

    if ($db->deleteById("users", $id)) {
        session_set("success", "Your user delete success");
        redirect("users?id=$id");
    } else {
        session_set("failure", "Your user delete failure");
    }

}

$form_header_text = 'Delete Exists User';
$form_submit_name = 'Delete Now';
$form_footer_text = '<div class="label label-danger">Are sure want to delete this user?</div>';

include PAGE_HEADER;

include "form.php";

include PAGE_FOOTER;