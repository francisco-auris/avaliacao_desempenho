<?php
class Auto extends MAuto {

	var $id;
	var $error;
	var $dados;

	function __construct(){
		$this->id = $_GET['id'];
		$this->searchFunc();
		if( $this->verify() == "F" ){
			CCentral::redireciona("?window=avaliacaoc&id=".$this->id."");
		}
		else {
			$this->geraAvaliacao();
		}
		
		$this->error = 0;
	}

	public function salva(){
		$perguntas = $this->pegaPerguntas( $_GET['tag'] );
		for( $i=0; $i < count($perguntas); $i++ ){ #pega valores das repostas de acordo com id de pergunta
			# echo $perguntas[$i]." -> ".$_POST[$perguntas[$i]]."<br>";
			$this->execInsert( $_SESSION['LOGIN_RH'], base64_decode($_GET['id']), $perguntas[$i]['p'], $_POST[$perguntas[$i]['p']], $perguntas[$i]['c'] );
			//echo '<h1>'.$this->error."</h1><br>";
		}
		//CMessage::centralNext('Avaliacao feita com sucesso.');
		if( $this->error == count($perguntas) ){
			$this->insertcomentario();
			//echo '<script type="text/javascript">sucesso();</script>';
			CCentral::redireciona("?window=mensagem&id=".$_GET['id']."&action=sucesso");
		}
		else {
			CMessage::centralNext('Avaliacao feita com sucesso.');
		}	
	}

}
?>