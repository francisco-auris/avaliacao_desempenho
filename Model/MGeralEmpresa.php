<?php
class MGeralEmpresa extends CConexao {
	
	protected function searchDados(){
		$CConexao = $this->conectar();
		$query = $CConexao->query("SELECT SUM(nota)/COUNT(idresposta) AS media, cmp.titulo
									FROM resposta AS rsp
									INNER JOIN competencia AS cmp ON rsp.competencia = cmp.idcompetencia
									WHERE cmp.tipo='C' AND rsp.avaliador<>rsp.avaliado
									GROUP BY competencia");
		if( $query AND $query->rowCount() > 0 ){
			include_once "Report/empresa.php";
		}
		else {
			CMessage::danger('Error ao buscar dados.');
		}
	}
}
?>