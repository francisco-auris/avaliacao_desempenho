<?php
class Home extends MHome {

	protected $nivel;
	protected $matricula;
	protected $imediato;
	protected $superior;

	function __construct(){
		$this->nivel = $_SESSION['NIVEL_RH'];
		$this->matricula = $_SESSION['LOGIN_RH'];
		$this->imediato = $_SESSION['IMEDIATO_RH'];
		$this->superior = $_SESSION['SUPERIOR_RH'];
		$this->perfil( $this->nivel );
	}

	private function perfil( $tipo ){
		if( $tipo == "Estrategico" ){
			$this->estrategico();
		}
		if( $tipo == "Tatico" ){
			$this->tatico();
		}
		else if( $tipo == "Operacional" ){
			$this->operacional();
		}
	}

	protected function estrategico(){
		echo '<div class="container">';
		$this->listSubordinados( $this->matricula );
		$this->listMyGestor( $this->imediato, $this->superior);
		if( $_SESSION['LOGIN_RH'] != '90000' ){
			$this->autoAvaliacao();
		}
		
		echo '</div>';
	}
	protected function tatico(){
		echo '<div class="container">';
		$this->listMyGestor( $this->imediato, $this->superior);
		$this->autoAvaliacao();
		echo '</div>';
	}
	protected function operacional(){
		echo '<div class="container">';
		$this->listMyGestor( $this->imediato, $this->superior);
		echo '</div>';
	}

}
?>