<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>
        Bootstrap E-Commerce Template - DIGI Shop mini
        <?php echo isset($pageTitle) ? $pageTitle : ''; ?>
    </title>
    <?php
        style('assets/css/bootstrap.css');
        style('assets/css/print-grid.css');
        style('assets/css/style.css');
        style('assets/css/font-awesome.min.css');
    ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <style media="all">
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
    <?php
        script('assets/js/jquery-1.10.2.js');
        script('assets/js/bootstrap.min.js');
    ?>
</head>
<body>

    <div class="hidden-print">
        <?php require_once PAGE_NAVBAR;?>
    </div>

    <!-- open container in content_headaer.php -->
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-print">
                <?php include PAGE_SIDEBAR;?>
            </div>

            <div class="col-md-9">
                <?php
                    session_flash_alerts();

                    $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
                    $links = [];
                    $val = '';

                    for ($i = 1; $i < count($parts); ++$i) {
                        $key = str_replace('.php', '', $parts[$i]);
                        $key = preg_replace('/\?.*/', '', $key);
                        $key = trim($key, '/');
                        $val .= '/' . $parts[$i];
                        if (!empty($key)) {
                            $links[$key] = $val;
                        }
                    }
                ?>

                <?php if (count($parts) >= 2): ?>
                    <div class="row hidden-print">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li>
                                    <?php link_to('', 'Site');?>
                                </li>
                                <?php
                                    $count = 0;
                                    foreach ($links as $key => $val) {
                                        ++$count;
                                        if ($count == count($links)) {
                                            echo "<li class='active'>", ucfirst($key), "<li>";
                                        } else {
                                            echo "<li data-test='$val - $key'>";
                                            link_to($val, ucfirst($key));
                                            echo "</li>";
                                        }
                                    }
                                ?>
                            </ol>
                        </div>
                    </div>
                <?php endif;?>
