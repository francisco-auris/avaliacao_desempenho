<?php
class CCentral {

    public static function requirePage( $file ){
        $file = "View/$file.php";
        if( file_exists($file) ){
            include_once $file;
        }
        else {
            self::notFound($file);
        }
    }

    public static function header(){
        include_once "Partial/header.php";
    }
    public static function footer(){
        include_once "Partial/footer.php";
    }

    public static function redireciona( $url ){
        if( $url=='*' ){
           //header("location:.");
            echo '<script type="text/javascript">window.location.href=".";</script>';
        }else {
            //header("location:$url");
            echo '<script type="text/javascript">window.location.href="'.$url.'";</script>';
        }
    }

    public static function notFound( $atb ){
        echo "<i><b>$atb</b> não encontrado.</i><br>";
    }
}
?>