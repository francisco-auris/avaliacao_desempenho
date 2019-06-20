<?php
class Usuario extends MUsuario {

    public function login(){

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        if(empty($login) OR empty($senha)){
            CMessage::alerta('Login ou senha vazios !');
        }else {
            $this->vlogin = $login;
            $this->vsenha = $senha;
            $this->execLogin();
        }
    }

    public function logout(){
        unset($_SESSION['LOGIN_RH']);
        CCentral::redireciona('*');
    }
}
?>