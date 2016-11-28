<?php
/**
 * Created by PhpStorm.
 * User: ravut
 * Date: 2016-11-19
 * Time: 3:03 PM
 */

class Upload {

    private $file;
    private $maxSize = 0;
    private $uploaded = 0;
    private $errors = array();
    private $allowFiles = array();
    private $allowImages = array();

    public function __construct() {
        $this->maxSize = 20000000; // 20M = 20 * 1000 * 1000
        $this->allowFiles = array('jpg', 'jpeg', 'png', 'gif');
        $this->allowImages = array('jpg', 'jpeg', 'png', 'gif');
    }

    public function fileOnly($filename, $path = '/files/') {
        $this->uploaded = 1;

        $uploadName = $_FILES[$filename]['name'];
        $uploadTemp = $_FILES[$filename]['tmp_name'];
        $uploadSize = $_FILES[$filename]['size'];

        $this->file = $_FILES[$filename];

        $file = $path . basename($uploadName);
        $imageFileType = pathinfo($file, PATHINFO_EXTENSION);

        // Check if file already exists
        if (file_exists($file)) {
            $this->uploaded = 0;
            $this->errors[] = "File already exists";
        }

        // Check file size
        if ($uploadSize > $this->maxSize) {
            $this->uploaded = 0;
            $this->errors[] = "File is too large";
        }

        // Allow certain file formats
        if (!in_array($imageFileType, $this->allowFiles)) {
            $this->uploaded = 0;
            $this->errors[] = "File is allow only " . implode(', ', $this->allowFiles);
        }

        // Check if $uploadOk is set to 0 by an error
        if ($this->uploaded == 0) {
            $this->errors[] = "File failed to upload";
        } else {
            if (!move_uploaded_file($uploadTemp, $file)) {
                $this->errors[] = 'There was an error uploading your file';
            }
        }
        return $this;
    }

    public function imageOnly($filename, $path = '/images/') {
        $this->uploaded = 1;

        $uploadName = $_FILES[$filename]['name'];
        $uploadTemp = $_FILES[$filename]['tmp_name'];
        $uploadSize = $_FILES[$filename]['size'];

        $this->file = $_FILES[$filename];
        
        $file = $path . basename($uploadName);
        $imageFileType = pathinfo($file, PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($uploadTemp);
        if($check === false) {
            $this->uploaded = 0;
            $this->errors[] = "File is not an image";
        }

        // Check if file already exists
        if (file_exists($file)) {
            $this->uploaded = 0;
            $this->errors[] = "File already exists";
        }

        // Check file size
        if ($uploadSize > $this->maxSize) {
            $this->uploaded = 0;
            $this->errors[] = "File is too large";
        }

        // Allow certain file formats
        if (!in_array($imageFileType, $this->allowImages)) {
            $this->uploaded = 0;
            $this->errors[] = "File is allow only " . implode(', ', $this->allowImages);
        }

        // Check if $uploadOk is set to 0 by an error
        if ($this->uploaded == 0) {
            $this->errors[] = "File failed to upload";
        } else {
            if (!move_uploaded_file($uploadTemp, $file)) {
                $this->errors[] = 'There was an error uploading your file';
            }
        }
        return $this;
    }

    public function errors() {
        return $this->errors;
    }

    public function file($name = null, $default = '') {
        if ($name != null) {
            if (!empty($this->file) && isset($this->file[$name])) {
                return $this->file[$name];
            }
            return $default;
        }
        return $this->file;
    }

    public function maxSize($size = null) {
        if ($size != null) {
            $this->maxSize = $size;
            return $this;
        }
        return $this->maxSize;
    }

    public function allowFiles($types = null) {
        if ($types != null) {
            $this->allowFiles = $types;
            return $this;
        }
        return $this->allowFiles;
    }

    public function allowImages($types = null) {
        if ($types != null) {
            $this->allowImages = $types;
            return $this;
        }
        return $this->allowImages;
    }

}