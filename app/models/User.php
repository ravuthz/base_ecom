<?php

class User {
    public $id;
    public $name;
    public $role;
    public $photo;
    public $phone;
    public $email;
    public $gender;
    public $address;
    public $id_card;
    public $username;
    public $password;
    public $city;
    public $district;
    public $post_station;

    public function __construct() {
        $this->gender = 'male';
    }

    public static function fetchFromInput() {
        return array(
            "name" => input_post("name"),
            "gender" => input_post("gender"),
            "address" => input_post("address"),
            "email" => input_post("email"),
            "phone" => input_post("phone"),
            "city" => input_post("city"),
            "district" => input_post("district"),
            "post_station" => input_post("post_station"),
            "username" => input_post("username"),
            "password" => md5(input_post("password")),
            "role" => input_post("role"),
            "id_card" => input_post("id_card")
        );
    }

    public static function isConfirmedPassword() {
        $password = input_post('password');
        $wordpass = input_post('wordpass');
        return (!empty($password) && $password == $wordpass);
    }

    public static function uploadPhoto() {
        $uploader = new Upload();
        $upload = $uploader->imageOnly('photo', PATH_IMG);
        if ($errors = $upload->errors()) {
            session_set('failure', implode('<br/>', $errors));
            script_redirect('users/create.php');
        }
        return $upload->file('name');
    }
}
