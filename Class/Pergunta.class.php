<?php
class Pergunta extends MPergunta {

	var $contexto;
	var $id;

	function __construct(){
		if( empty($_GET['id']) ){
			$this->listAll();
		}
		else {
			$this->telaUpdate();
		}
	}

	public function insert(){
		$this->contexto = $_POST['pergunta'];
		$this->execInsert( $this->contexto );
	}

	public function update(){
		$id = base64_decode($_GET['id']);
		$texto = $_POST['contexto'];
		$this->execUpdate( $id, $texto );
	}

	public function delete(){
		$this->id = base64_decode($_GET['id']);
		$this->execDelete();
	}

}
?>