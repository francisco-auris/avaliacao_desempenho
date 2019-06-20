<?php
class Pacote extends MPacote {
	/**************************************
	*		1|O	-	OPERACIONAL			  *
	*		2|T	-	TATICO				  *
	*		3|E	-	ESTRATEGICO			  *
	***************************************/

	var $titulo;
	var $tipo;
	var $comp;
	var $voltado;

	function  __construct(){
		if( isset($_GET['comp']) ){
			$this->searchDados();
			$this->page();
		}
		else {
			$this->listAll();
		}
	}

	public function page(){
		include "View/modal/pacote_update.php";
	}

	public function insert(){
		$this->titulo = $_POST['titulo'];
		$this->tipo = $_POST['tipo'];
		$this->comp = $_POST['competencias'];
		$this->voltado = $_POST['msearch'];
		$this->execInsert();
	}

	public function update(){
		if( empty($_POST['competencias']) OR empty($_POST['msearch']) OR empty($_GET['id']) ){
			CMessage::fixed("Dados de entrada vazios.","warning");
		}else {
			$this->execUpdate();
		}
	}

	public function delete(){
		CMessage::fixedSucesso('Teste de fixa');
	}	
}
?>