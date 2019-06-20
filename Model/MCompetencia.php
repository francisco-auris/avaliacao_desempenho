<?php
class MCompetencia extends CConexao {

	var $id;
	public $_dados;

	protected function listAll(){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM competencia order by idcompetencia desc");
		if( $query AND $query->rowCount() > 0 ){
			include_once "View/list/competencia.php";
		}
		else {
			CMessage::alerta("Nenhuma competencia cadastrada.");
		}
	}

	public function searchDados( $id ){

		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM competencia WHERE idcompetencia='".$id."'");
		if( $query AND $query->rowCount() > 0 ){
			while( $dados = $query->fetch(PDO::FETCH_ASSOC) ){
				$this->_dados['titulo'] = $dados['titulo'];
				$this->_dados['perguntas'] = $dados['cpergunta'];
			}
		}
		else {

		}

	}

	protected function execInsert(){
		$cconexao = $this->conectar();
		$query = $cconexao->prepare("INSERT INTO competencia (titulo,tipo,cpergunta) VALUE (:titulo, :tipo, :perguntas)");
		 $query->bindParam(":tipo", $this->tipo, PDO::PARAM_STR);
		 $query->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
		 $query->bindParam(":perguntas", $this->perguntas, PDO::PARAM_STR);
		if( $query->execute() ){
			CMessage::sucesso("Competencia cadastrada.");
			CCentral::redireciona("?window=competencia");
		}
		else {
			CMessage::danger("Error ao executar query.");
		}
	}

	protected function execDelete(){
		$cconexao = $this->conectar();
		$query = $cconexao->prepare("DELETE FROM competencia WHERE idcompetencia=:id");
		$query->bindParam(":id", $this->id, PDO::PARAM_INT);
		if( $query->execute() ){
			CCentral::redireciona("?window=competencia");
			//CMessage::sucesso("Competencia deletada.");
			//unset($_GET['id']);
		}
		else {
			CMessage::danger("Error ao tentar excluir competencia.");
		}
	}

	protected function execUpdate(){
		$cconexao = $this->conectar();
		$id = base64_decode($_GET['id']);
		$query = $cconexao->prepare("UPDATE competencia SET titulo=:titulo, cpergunta=:perguntas WHERE idcompetencia=:id");
		 $query->bindParam(":titulo", $_POST['titulo'], PDO::PARAM_STR);
		 $query->bindParam(":perguntas", $_POST['perguntas'], PDO::PARAM_STR);
		 $query->bindParam(":id", $id, PDO::PARAM_INT);
		 if( $query->execute() ){
		 	CMessage::fixed("Competencia atualizada.", 'success');
		 }
		 else {
		 	CMessage::fixed("Error ao atualizar dados de competencia.", 'danger');
		 }	
	}

}
?>