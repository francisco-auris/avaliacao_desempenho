<?php
class MUsuario extends CConexao {

    var $vlogin;
    var $vsenha;

    protected function execLogin(){
       $cconexao = $this->conectar();
       $query = $cconexao->prepare("SELECT * FROM funcionario WHERE matricula=:matricula AND nascimento=:nsc");
       $query->bindParam(":matricula", $this->vlogin, PDO::PARAM_INT);
       $query->bindParam(":nsc", $this->vsenha, PDO::PARAM_STR);
       if( $query->execute() ){
       	# verifica se executa query
       		if( $conta = $query->rowCount() == 1 ){
       		# verifica se existe usuario
       			while( $ftch=$query->fetch(PDO::FETCH_ASSOC) ){
       				# inserindo valores em session
       				$_SESSION['LOGIN_RH'] = $ftch['matricula'];
       				$_SESSION['NOME_RH'] = $ftch['nome'];
              if( $ftch['imediato']=="" ){
              $_SESSION['IMEDIATO_RH'] = '0';
              }else {
              $_SESSION['IMEDIATO_RH'] = $ftch['imediato'];
              }
       				if( $ftch['superior']=="" ){
              $_SESSION['SUPERIOR_RH'] = '0';
              }else {
              $_SESSION['SUPERIOR_RH'] = $ftch['superior'];
              }
       				$_SESSION['NIVEL_RH'] = $ftch['nivelavaliador'];
       				CCentral::redireciona('?window=home');
       			}
       		}
       		else {
       			CMessage::danger("Funcionário não encontrado !");
       		}
       }
       else {
       		CMessage::danger("Error de query.");
       }
       # $_SESSION['LOGIN_RH'] = $this->vlogin;
       
    }

    
}
?>