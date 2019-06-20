<?php
function __autoload( $class ){
    $file = "Controller/$class.php";
    if(file_exists($file)){
        require_once $file;
    }
    $file = "Class/$class.class.php";
    if(file_exists($file)){
        require_once $file;
    }
    $file = "Model/$class.php";
    if(file_exists($file)){
        require_once $file;
    }
}
?>