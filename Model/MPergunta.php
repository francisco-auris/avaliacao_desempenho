<?php
class MPergunta extends CConexao {

    protected $dadosP;

    protected function listAll(){
        $cconexao = $this->conectar();
        $query = $cconexao->query("SELECT * FROM pergunta ORDER BY idpergunta DESC");
        if( $query AND $query->rowCount() > 0 ){
        	include_once "View/list/pergunta.php";
        }
        else {
            CMessage::alerta("Nenhuma pergunta encontrada.");
        }
    }

    protected function execInsert( $texto ){
    	$cconexao = $this->conectar();
        $text = utf8_decode($texto);
        $vef = $cconexao->query("SELECT * FROM pergunta WHERE contexto='$text'");
        if( $vef AND $vef->rowCount() > 0 ){
            CMessage::alerta('Ja existe uma pergunta cadastrada.');
        }else {
            $query = $cconexao->prepare("INSERT INTO pergunta (contexto) VALUES (:texto)");
             $query->bindParam(":texto", $texto, PDO::PARAM_STR);
            if( $query->execute() ){
                CMessage::sucesso("Pergunta cadastrada.");
                CCentral::redireciona("?window=pergunta");
            }
            else {
                CMessage::danger("Error ao executar query.");
            }
        }
    }

    protected function execDelete(){
    	$cconexao = $this->conectar();
    	$query = $cconexao->prepare("DELETE FROM pergunta WHERE idpergunta=:id");
    	$query->bindParam(":id", $this->id, PDO::PARAM_INT);
    	if( $query->execute() ){
    		CCentral::redireciona("?window=pergunta");
            //CMessage::fixed("Pergunta deletada","success");
    	}
    	else {
    		
    	}
    }

    protected function execUpdate( $id, $texto ){
        $cconexao = $this->conectar();
        $query = $cconexao->prepare("UPDATE pergunta SET contexto=:texto WHERE idpergunta=:id");
          $query->bindParam(":texto", $texto, PDO::PARAM_STR);
          $query->bindParam(":id", $id, PDO::PARAM_INT);
        if( $query->execute() ){
            CMessage::sucesso("Pergunta atualizada.");
        }
        else {
            CMessage::danger("Error ao tentar atualizar pergunta.");
        }
    }

    protected function telaUpdate(){

        $id = base64_decode($_GET['id']);
        $cconexao = $this->conectar();
        $query = $cconexao->query("SELECT * FROM pergunta WHERE idpergunta='$id'");
        if( $query AND $query->rowCount() > 0 ){
            while( $fetch = $query->fetch(PDO::FETCH_ASSOC) ){
                $this->dadosP['contexto'] = $fetch['contexto'];
            }
        }

        include_once "View/modal/pergunta_update.php";
    }

}
?>