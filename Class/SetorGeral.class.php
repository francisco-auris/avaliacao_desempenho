<?php
class SetorGeral extends MSetorGeral {
	
	function __construct(){ 

		$this->setConexao( $this->conectar() ); //instancia conexao
		$this->geraReport();
		
	}



}
?>