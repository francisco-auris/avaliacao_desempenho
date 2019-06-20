<?php
class Competencia extends MCompetencia {
	
	var $tipo;
	var $perguntas;
	var $titulo;
	var $id;

	function __construct(){

		if( empty($_GET['comp']) ){
			$this->listAll();
		}
		else {
			$this->searchDados( base64_decode($_GET['id']) );
			$this->prepareUpdate();
		}
		
	}

	public function prepareUpdate(){
		include "View/modal/competencia_update.php";
	}

	public function insert(){
		$this->tipo = $_POST['tipo'];
		$this->titulo = $_POST['titulo'];
		$this->perguntas = $_POST['perguntas'];
		$this->execInsert();
	}

	public function delete(){
		$this->id = base64_decode($_GET['id']);
		$this->execDelete();
	}

	public function update(){
		$this->execUpdate();
	}
}
?>