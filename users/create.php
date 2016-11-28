<?php

    include "../config.php";

    if (!$auth->isAdmin()) {
        session_set('failure', "You don't have permission to create user. Please contact admin.");
        redirect('products');
    }

    $user = session_get('old_user', new User());

    if (input_post('submit')) {

        $user_data = User::fetchFromInput();
        session_set('old_user', (object) $user_data);

        if (input_has('photo')) {
            $user_data['photo'] = User::uploadPhoto();
        } else {
            unset($user_data['photo']);
        }

        if (User::isConfirmedPassword()) {
            if ($id = $db->insert("users", $user_data)) {
                session_set("success", "Your user create success");
                session_clear("old_user");
                script_redirect("users?id=$id");
            } else {
                session_set("failure", "Your user create failure");
                script_redirect('users/create.php');
            }
        } else {
            session_set('failure', "Your password not match");
            script_redirect('users/create.php');
        }

    }

    $form_header_text = 'Create New User';
    $form_submit_name = 'Create Now';
    $form_footer_text = '';

    include PAGE_HEADER;

    include "form.php";

    include PAGE_FOOTER;
