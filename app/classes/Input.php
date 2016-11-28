<?php

class Input {

    public static function all() {
        return $_REQUEST;
    }

    public static function get($name, $value = '') {
        return isset($_GET[$name]) ? $_GET[$name] : $value;
    }

    public static function post($name, $value = '') {
        return isset($_POST[$name]) ? $_POST[$name] : $value;
    }

    public static function request($name, $value = '') {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $value;
    }

    public static function has($name) {
        return (boolean) isset($_REQUEST[$name]);
    }

    public static function not() {
        return !(boolean) isset($_REQUEST[$name]);
    }

}
