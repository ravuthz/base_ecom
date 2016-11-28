<?php

    include "../config.php";

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
                session_set("success", "Your account register success");
                session_clear("old_user");
                script_redirect("users?id=$id");
            } else {
                session_set("failure", "Your account register failure");
                script_redirect('account/register.php');
            }
        } else {
            session_set('failure', "Your password not match");
            script_redirect('account/register.php');
        }
    }

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        Bootstrap E-Commerce Template - DIGI Shop mini
    </title>
    <?php style('assets/css/bootstrap.css'); ?>
    <?php style('assets/css/style.css'); ?>
    <?php style('assets/css/font-awesome.min.css'); ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <style media="screen">
        .col-md-4 .img-thumbnail {
            height: 230px;
        }
        .table .img-thumbnail {
            width: 30px;
            height: 30px;
        }
        textarea.form-control {
            resize: vertical;
        }
    </style>

    <?php script('assets/js/jquery-1.10.2.js'); ?>
    <?php script('assets/js/bootstrap.min.js'); ?>
</head>
<body>
    <br/>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">

            <div class="panel panel-default">

                <div class="panel-body">

                    <h2 class="text-center">Client Registeration Form</h2>
                    <hr/>

                    <?php session_flash_alerts(); ?>

                    <form id="form1" action="" class="form" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name:</label>
                                    <input name="name" class="form-control" type="text" id="name" size="150" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_card">ID Number:</label>
                                    <input name="id_card" class="form-control" type="text" id="id_card" size="150" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input name="phone" class="form-control" type="text" id="phone" size="16" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address:</label>
                                    <input name="email" class="form-control" type="text" id="email" size="50" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" name="address" class="form-control" id="address"/>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City / Province:</label>
                                    <input name="city" class="form-control" type="text" id="city" size="16" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district">District / Tambun:</label>
                                    <input name="district" class="form-control" type="text" id="district" size="50" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input name="username" class="form-control" type="text" id="username" size="50" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="post_station">Post Station:</label>
                                    <input name="post_station" class="form-control" type="text" id="post_station" size="50" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input name="password" class="form-control" type="password" id="password" size="50" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wordpass">Password Again:</label>
                                    <input name="wordpass" class="form-control" type="password" id="wordpass" size="50" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo: </label>
                            <input name="photo" type="file" class="form-control"/>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Gender: <br/>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male" checked/> Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="female"/> Female
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Register As: <br/>
                                        <label class="radio-inline">
                                            <input type="radio" name="role" value="seller" checked/> Seller
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="role" value="customer"/> Customer
                                        </label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-offset-8 col-md-2">
                                <input type="submit"  class="btn btn-block btn-primary" name="submit" id="submit" value="Register Now">
                            </div>
                            <div class="col-md-2">
                                <?php link_to('', 'Back to Home', 'class="btn btn-block btn-default"'); ?>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</body>
</html>
