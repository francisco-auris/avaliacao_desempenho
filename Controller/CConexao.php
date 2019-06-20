<?php
class CConexao {

	function __construct(){
		$this->conectar();
	}

	protected function conectar(){
		$conn = new PDO('mysql:host=localhost;dbname=avaliacao_desempenho_2017', 'root', 'N3wG3r3nc1A');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	return $conn;
	}

}
?>