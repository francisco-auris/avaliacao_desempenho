<?php
class Avaliacaoc extends MAvaliacaoc {

	var $id;
	var $error;

	function __construct(){
		$this->id = $_GET['id'];
		$this->searchFunc();
		if( $this->verify() == "F" ){
			CCentral::redireciona("?window=home");
		}
		else {
			$this->geraAvaliacao();
		}
	}

	public function salva(){
		$perguntas = $this->pegaPerguntas( $_GET['tag'] );
		for( $i=0; $i < count($perguntas); $i++ ){ #pega valores das repostas de acordo com id de pergunta
			# echo $perguntas[$i]." -> ".$_POST[$perguntas[$i]]."<br>";
			$this->execInsert( $_SESSION['LOGIN_RH'], base64_decode($_GET['id']), $perguntas[$i]['p'], $_POST[base64_encode($perguntas[$i]['p'])], $perguntas[$i]['c'] );
		}
		# verificação de ação
		if( $this->error == count($perguntas) ){
			$this->insertcomentario();
			CCentral::redireciona("?window=mensagem&id=".$_GET."&action=sucesso");
			//print_r($_POST);
		}
		else {
			CMessage::centralNext('Avaliacao feita com sucesso.');
			//print_r($_POST);
		}	
	}
}
?>