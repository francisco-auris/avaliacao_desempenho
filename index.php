<?php
# data's init in system
date_default_timezone_set('America/Sao_Paulo');
ini_set( 'display_errors', 0 );
error_reporting(E_ALL);
session_start();
# index system
include_once "Controller/CConfg.php";
include_once "Class/Autoload.class.php";
# verification of login user
if(empty($_SESSION['LOGIN_RH'])){
    CCentral::requirePage('login');
    $var = new Usuario;
    if(isset($_GET['action'])){
        $var->$_GET['action']();
    }
}
else {
    CCentral::header();
    if(isset($_GET['window'])){
        CCentral::requirePage($_GET['window']);
    }else {
        CCentral::requirePage('home');
    }
    #init class to get[]
    if(isset($_GET['window'])){
        $cls = ucfirst($_GET['window']);
        if( class_exists($cls) ){
            $var = new $cls;
            if(isset($_GET['action'])){
                $var->$_GET['action']();
            }
        }   
    }
    else {
        $var = new Usuario;
        if(isset($_GET['action'])){
            $var->$_GET['action']();
        }
    }
    CCentral::footer();
}

?>