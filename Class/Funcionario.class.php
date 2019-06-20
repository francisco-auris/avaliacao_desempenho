<?php
class Funcionario extends MFuncionario {
	
	function __construct(){
		if( empty($_GET['comp']) ){
			$this->listFunc();
		}
		else {
			$this->search();
		}
		
	}

	public function insert(){
		$this->execInsert();
	}

	public function update(){
		//print_r($_POST);
		$this->execUpdate();
	}

	public function delete(){
		$this->execDelete();
	}
}
?>