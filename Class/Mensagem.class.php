<?php
class Mensagem {

	protected $id;

	function __construct(){
		$this->id = base64_decode($_GET['id']);
	}

	public function sucesso(){
		CMessage::centralSucesso('Avaliação feita com sucesso.');
	}
}
?>