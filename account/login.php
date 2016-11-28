<?php

    include "../config.php";

    if (input_post('submit')) {
        $username = input_post('username');
        $password = md5(input_post('password'));

        $sql = "SELECT id, name, email, username, role FROM users WHERE username = :username AND password = :password";
        $login = $db->query($sql, array('username' => $username, 'password' => $password))->one();

        if (empty($login)) {
            session_set('failure', 'Your username and password is invalid');
            redirect('account/login.php');
        } else {
            session_set('auth_user', $login);
            session_set('auth_time', time());
            redirect();
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

    <div class="container">

        <div class="row">

            <div class="col-md-offset-4 col-md-4" style="margin-top: 90px;">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <h3 class="text-center">Login to Web Application</h3>

                        <hr/>

                        <?php session_flash_alerts(); ?>

                        <form method="post">

                            <div class="form-group">
                                <label for="username">Username: </label>
                                <input type="text" class="form-control" name="username">
                            </div>

                            <div class="form-group">
                                <label for="pasword">Password: </label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <hr/>

                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="submit" class="btn btn-block btn-primary" name="submit" value="Login Now"/>
                                </div>
                                <div class="col-sm-6">
                                    <?php link_to('', 'Back to Home', 'class="btn btn-block btn-default"'); ?>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>
