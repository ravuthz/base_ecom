<?php

/* Includes */

function include_file($file) {
    return include BASE_PATH . $file;
}

function include_page($name) {
    return include BASE_PATH . "$name.php";
}

/* Request */

function input_get($inputName, $defaultValue = '') {
    if (isset($_GET[$inputName]) && !empty($_GET[$inputName])) {
        return $_GET[$inputName];
    }
    return $defaultValue;
}

function input_post($inputName, $defaultValue = '') {
    if (isset($_POST[$inputName]) && !empty($_POST[$inputName])) {
        return $_POST[$inputName];
    }
    return $defaultValue;
}

function input_request($inputName, $defaultValue = '') {
    if (isset($_REQUEST[$inputName]) && !empty($_REQUEST[$inputName])) {
        return $_REQUEST[$inputName];
    }
    return $defaultValue;
}

function input_has($name) {
    if (isset($_FILES[$name])) {
        return $_FILES[$name]['size'] > 0;
    }
    return isset($_REQUEST[$name]);
}

function input_all() {
    return $_REQUEST;
}

function input_get_has($name) {
    return isset($_GET[$name]);
}

function input_post_has($name) {
    return isset($_POST[$name]);
}

function input_request_has($name) {
    return isset($_REQUEST[$name]);
}

/* Session */

function session($key, $val = '') {
    if (empty($val)) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : '';
    }
    $_SESSION[$key] = $val;
}

function session_set($key, $val) {
    $_SESSION[$key] = $val;
    return $_SESSION[$key];
}

function session_get($key, $val = '') {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $val;
}

function session_has($key) {
    return  isset($_SESSION[$key]);
}

function session_clear($name = '') {
    if (!empty($name)) {
        unset($_SESSION[$name]);
    } else {
        session_destroy();
    }
}

function session_append($key, $val) {
    $temp = [];
    if (isset($_SESSION[$key])) {
        $temp = $_SESSION[$key];
    }
    $temp[] = $val;
    $_SESSION[$key] = $temp;
    return $_SESSION[$key];
}

function session_flash($key) {
    $message = '';
    if (isset($_SESSION[$key])) {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
    }
    return $message;
}

function session_flash_alert($key, $type = 'success') {
    if ($message = session_flash($key)) {
        echo "<div class='alert alert-$type'>$message</div>";
    }
}

function session_flash_alerts($key = '', $type = 'success') {
    if (!empty($key)) {
        session_flash_alert($key, $type);
    }
    if ($message = session_flash('success')) {
        echo "<div class='alert alert-success'>$message</div>";
    }
    if ($message = session_flash('failure')) {
        echo "<div class='alert alert-danger'>$message</div>";
    }
    if ($message = session_flash('warning')) {
        echo "<div class='alert alert-warning'>$message</div>";
    }
}

/* Redirect */

function redirect($file = '') {
    $file = BASE_LINK . $file;
    header("Location: $file");
    exit();
}

function script_redirect($file = '') {
    $file = BASE_LINK . $file;
    echo "<script>window.location = '$file';</script>";
    exit();
}

/* Debug */

function pp($object) {
    echo "<pre>";
    print_r($object);
    echo "</pre>";
}

function dd($object) {
    echo "<pre>";
    var_dump($object);
    echo "</pre>";
    die();
}

function exception_alert($ex) {
    $message = '';
    foreach ($ex->getTrace() as $item) {
        $class = isset($item['class']) ? $item['class'] : '';
        $line = isset($item['line']) ? $item['line'] : '';
        $file = isset($item['file']) ? $item['file'] : '';
        $function = isset($item['function']) ? $item['function'] : '';
        $message .= "<hr/>
        <p><strong>Class: </strong> $class </p>
        <p><strong>Line: </strong> $line </p>
        <p><strong>File: </strong> $file </p>
        <p><strong>Function: </strong> $function </p>";
    }

    echo "<div class='container'><div class='row'><div class='col-md-12'><div class='alert alert-danger'>
        <p><strong>Code: </strong> {$ex->getCode()} </p>
        <p><strong>Line: </strong> {$ex->getLine()} </p>
        <p><strong>File: </strong> {$ex->getFile()} </p>
        <p><strong>Message: </strong> {$ex->getMessage()} </p>
        <div class='alert alert-default'>
            $message
        </div>
    </div></div></div></div>";
}

/*  */

function format_usd($text) {
    return '$ ' . number_format($text, 2);
}

function print_usd($text) {
    echo format_usd($text);
}

/* Include BASE_LINK AND BASE_PATH */

function link_to($link, $text, $other = '') {
    $link = BASE_LINK . trim($link, '/');
    echo "<a href='$link' $other>$text</a>" . PHP_EOL;
}

function link_button($link, $text, $type = 'btn-default') {
    link_to($link, $text, "class = 'btn $type'");
}

function base_link($file = '') {
    echo BASE_LINK . $file;
}

function base_path($file = '') {
    echo BASE_PATH . $file;
}

function image($file, $text = '', $class = 'img-thumbnail') {
    echo "<img src='" . ASSET_IMG . ($file ? $file : NO_IMAGE) . "' alt='$text' class='$class' />", PHP_EOL;
}

function style($file, $media = 'all') {
    echo "<link href='" . BASE_LINK . $file . "' rel='stylesheet' type='text/css' media='$media'>", PHP_EOL;
}

function script($file, $return = false) {
    if ($return) {
        return "<script src='" . BASE_LINK . $file . "'></script>" . PHP_EOL;
    }
    echo "<script src='" . BASE_LINK . $file . "'></script>", PHP_EOL;
}

function echo_if($expression, $true, $false = '') {
    echo $expression ? $true : $false;
}

function form_open($action = '', $method = 'get', $attr = '') {
    echo "<form action='" . BASE_LINK . "$action' method='$method' $attr >";
}

function form_close($hidden = []) {
    if (count($hidden) > 0) {
        foreach ($hidden as $key => $val) {
            echo "<input type='hidden' name='$key' value='$value' />";
        }
    }
    echo "</form>";
}

function form_items($group, $name, $value = '', $type = 'hidden', $attr = '') {
    echo "<input type='$type' name='items[$group][$name]' value='$value' $attr />";
};

function form_button($name, $class = 'btn-block btn-primary') {
    echo "<input type='button' class='btn $class' name='button' value='$name' />";
}

function form_submit($name, $class = 'btn-block btn-primary') {
    echo "<input type='submit' class='btn $class' name='submit' value='$name' />";
}

function form_cancel($name, $back = '', $class = 'btn btn-block btn-default') {
    link_to($back, $name, "class='$class'");
}
