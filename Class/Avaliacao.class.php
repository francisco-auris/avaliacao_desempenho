<?php
class Avaliacao extends MAvaliacao {

	var $id;
	var $error;
	var $dados; # comporta todos os dados do funcionario requerido

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

		}
		# verificação de ação
		if( $this->error == count($perguntas) ){
			$this->insertcomentario();
			if( $_SESSION['NIVEL_RH']=="Operacional" OR $_SESSION['NIVEL_RH']=="Tatico" ){
				CCentral::redireciona("?window=mensagem&id=".$_GET."&action=sucesso");
			}
			else {
				if( $this->vefGestores() == "CERTO" ){
					//echo '<h1>IF 1</h1>';
					CCentral::redireciona("?window=mensagem&id=".$_GET."&action=sucesso");
				}else {
					//echo '<h1>IF 2</h1>';
					CCentral::redireciona("?window=avaliacaoc&id=".$_GET['id']."");
				}
			}
		}
		else {
			if( $this->vefGestores() == "CERTO" ){
				CMessage::centralNext('Avaliacao feita com sucesso.');
			}
			else {
				if( $this->dados['nivel']=="E" ){
					CCentral::redireciona("?window=avaliacaoc&id=".$_GET['id']."");
				}
				else {
					CMessage::centralNext('Avaliacao feita com sucesso.');
				}
			}
			
		}	
	}

	public function vefGestores(){
		$exlore = explode("/", $_SESSION['IMEDIATO_RH']);
		$adc=0;
		$indice=0;
		for( $j=0; $j < count($exlore); $j++ ){
			if( $exlore[$j] == $this->dados['matricula'] ){
				$adc=1;
			}
		}
		if( $adc==1 ){
			return "CERTO";
		}else {
			return "ERRADO";
		}
	}

}
?>