<?php
class MEstrategico extends CConexao {
	
	protected $dados;

	protected function searchDados(){

		$cconexao = $this->conectar();
		$nivel = 'Estrategico';
		$indice = 0;

		$query = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$nivel' ORDER BY nome ASC");
		while( $dado = $query->fetch(PDO::FETCH_ASSOC) ){

			$matricula = $dado['matricula'];

			$_cmp = $cconexao->query("select avg(nota) as media from resposta resp inner join competencia comp on resp.competencia = comp.idcompetencia where avaliado = '$matricula' and avaliado <> avaliador and comp.tipo = 'C'");
			$_tcn = $cconexao->query("select avg(nota) as media from resposta resp inner join competencia comp on resp.competencia = comp.idcompetencia where avaliado = '$matricula' and avaliado <> avaliador and comp.tipo = 'T'");

			$this->dados[$indice]['nome'] = $dado['nome'];
			$this->dados[$indice]['comp'] = number_format($_cmp->fetch(PDO::FETCH_ASSOC)['media'], 2, '.', '');
			$this->dados[$indice]['tecn'] = number_format($_tcn->fetch(PDO::FETCH_ASSOC)['media'], 2, '.', '');

			$indice++;

		}

		include_once "Report/estrategico.php";

	}
} 
?>