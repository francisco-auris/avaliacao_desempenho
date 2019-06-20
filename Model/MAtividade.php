<?php
class MAtividade extends CConexao {
	
	protected function listAll(){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM funcionario ORDER BY setor,nome ASC");
		if( $query ){
			include_once "View/list/list_atividade.php";
		}
		else {
			CMessage::danger("Error ao buscar funcionarios.");
		}
	}

}
?>