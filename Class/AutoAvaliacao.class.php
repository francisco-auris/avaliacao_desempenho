<?php
class AutoAvaliacao extends MAutoAvaliacao {

	function __construct(){
		if( empty( $_GET['id'] ) ){
			$this->listColaboradores();
		}
		else {
			$this->searchData();
			$this->geraRelatorio();
		}
	}
}
?>