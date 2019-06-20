<?php
class MPacote extends CConexao {

	var $_dados;

	protected function listAll(){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM pacote order by idpacote desc");
		if( $query AND $query->rowCount() > 0 ){
			include_once "View/list/pacote.php";
		}
		else {
			CMessage::alerta("Nenhum resultado encontrado.");
		}
	}

	protected function searchDados(){
		$cconexao = $this->conectar();
		$id = base64_decode($_GET['id']);
		$query = $cconexao->query("SELECT * FROM pacote WHERE idpacote='$id'");
		if( $query AND $query->rowCount() > 0 ){
			while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
				$this->_dados['titulo'] = $ftch['titulo'];
				if( $ftch['tipo']=="O" ){
					$this->_dados['ntipo'] = "Operacional";
				}
				if( $ftch=="E" ){
					$this->_dados['ntipo'] = "Estrategico";
				}
				if( $ftch=="T" ){
					$this->_dados['ntipo'] = "Tatico";
				}else {
					$this->_dados['ntipo'] = "Nenhum";
				}
				$this->_dados['tipo'] = $ftch['tipo'];
				$this->_dados['msearch'] = $ftch['msearch'];
				$this->_dados['competencias'] = $ftch['pcompetencia'];
			}
			$this->buscarCargos();
		}
		else {
			CMessage::alerta('Error ao buscar pacote.');
		}
	}

	private function buscarCargos(){
		$cconexao = $this->conectar();
		$queryBusca = $cconexao->query("SELECT funcao FROM funcionario GROUP BY funcao");
		$conta = $queryBusca->rowCount();
		if( $queryBusca AND $conta > 0 ){
			$ad = 0;
			while( $dados = $queryBusca->fetch(PDO::FETCH_ASSOC) ){
				$this->_dados['funcoes'][$ad] = $dados['funcao'];
				$ad++;
			}
		}
		else {
			CMessage::alerta("ERROR");
		}
	}

	protected function execInsert(){
		$cconexao = $this->conectar();
		$query = $cconexao->prepare("INSERT INTO pacote (titulo,tipo,msearch,pcompetencia) VALUES (:titulo, :tipo, :msearch, :comp)");
		  $query->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
		  $query->bindParam(":tipo", $this->tipo, PDO::PARAM_STR);
		  $query->bindParam(":msearch", $this->voltado, PDO::PARAM_STR);
		  $query->bindParam(":comp", $this->comp, PDO::PARAM_STR);

		if( $query->execute() ){
			CCentral::redireciona("?window=pacote");
		}else {
			CMessage::danger("Error a inserir pacote.");
		}
	}

	protected function execUpdate(){
		$cconexao = $this->conectar();
		$id = base64_decode($_GET['id']);
		$query = $cconexao->prepare("UPDATE pacote SET tipo=:tipo, msearch=:msearch, pcompetencia=:competencias WHERE idpacote=:id");
		 $query->bindParam(":tipo", $_POST['tipo'], PDO::PARAM_STR);
		 $query->bindParam(":msearch", $_POST['msearch'], PDO::PARAM_STR);
		 $query->bindParam(":competencias", $_POST['competencias'], PDO::PARAM_STR);
		 $query->bindParam(":id", $id, PDO::PARAM_INT);
		if( $query->execute() ){
			CMessage::fixed("Pacote atualizado",'success');
		}
		else {
			CMessage::fixed("Error ao atualizar pacote","danger");
		}
	}
}
?>