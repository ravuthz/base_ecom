<?php

    include "../config.php";

    if (!$auth->isAdmin()) {
        session_set('failure', "You don't have permission to update user. Please contact admin.");
        redirect('products');
    }

    if ($id = input_get('id')) {
        $user = $db->selectOneObject('users', $id);
    }

    if (input_post('submit')) {

        $user_data = User::fetchFromInput();
        session_set('old_user', (object) $user_data);

        pp($_FILES['photo']['size']);

        if (input_has('photo')) {
            $user_data['photo'] = User::uploadPhoto();
        } else {
            unset($user_data['photo']);
        }

        if (User::isConfirmedPassword()) {
            if ($db->updateById("users", $id, $user_data)) {
                session_set("success", "Your user update success");
                session_clear("old_user");
                redirect("users?id=$id");
            } else {
                session_set("failure", "Your user update failure");
                // script_redirect("users/update.php?id=$id");
            }

        } else {
            session_set('failure', "Your password not match");
            // script_redirect("users/update.php?id=$id");
        }

    }

    $form_header_text = 'Update Exists User';
    $form_submit_name = 'Update Now';
    $form_footer_text = '';

    include PAGE_HEADER;

    include "form.php";

    include PAGE_FOOTER;
