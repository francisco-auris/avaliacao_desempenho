<?php
class MExtra extends CConexao {

	public function montaRelatorio(){

		$cconexao = $this->conectar();

		echo '<div class="container"><br><br><br><br>';
		echo '<table class="table table-bordered">';
		echo '<thead>';
			echo '<tr>';
				echo '<td><b>SETOR</b></td>';
				echo '<td><b>NOME</b></td>';
				echo '<td><b>MATRICULA</b></td>';
				echo '<td><b>MÉDIA (COMPORTAMENTAL)</b></td>';
				echo '<td><b>MÉDIA (TÉCNICA)</b></td>';
			echo '</tr>';
		echo '</thead>';

		$query = $cconexao->query("SELECT * FROM funcionario ORDER BY setor ASC");
		while( $geral = $query->fetch(PDO::FETCH_ASSOC) ){

			$matricula = $geral['matricula'];

			$temp = $cconexao->query("SELECT fc.nome,fc.setor,avg(nota)AS media
			from resposta as resp 
			inner join competencia as comp on resp.competencia = comp.idcompetencia 
			inner join funcionario as fc on avaliado = fc.matricula
			where avaliado = '$matricula' and avaliado <> avaliador and comp.tipo = 'C';");
			$temp2 = $cconexao->query("SELECT fc.nome,fc.setor,avg(nota)AS media
			from resposta as resp 
			inner join competencia as comp on resp.competencia = comp.idcompetencia 
			inner join funcionario as fc on avaliado = fc.matricula
			where avaliado = '$matricula' and avaliado <> avaliador and comp.tipo = 'T';");

			$dados = $temp->fetch(PDO::FETCH_ASSOC);
			$dados2 = $temp2->fetch(PDO::FETCH_ASSOC);

			echo '<tr>';
				echo '<td>'.$geral['setor'].'</td>';
				echo '<td>'.$geral['nome'].'</td>';
				echo '<td>'.$geral['matricula'].'</td>';
				echo '<td>'.number_format($dados['media'], 2, '.', '').'</td>';
				echo '<td>'.number_format($dados2['media'], 2, '.', '').'</td>';
			echo '</tr>';

		}

		echo '</table>';
		echo '</div>';

	}

}
?>