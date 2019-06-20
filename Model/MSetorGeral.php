<?php
class MSetorGeral extends CConexao {

	private $conexao;
	public function setConexao($conexao){
		$this->conexao = $conexao;
	}
	public function getConexao(){
		return $this->conexao;
	}

	protected function geraReport(){

		# var_dump($this->getConexao());
		$query = $this->getConexao()->query("select avg(resp.nota)as media,func.nivelavaliador, comp.tipo, func.setor from resposta resp inner join funcionario func on resp.avaliado = func.matricula inner join competencia comp on resp.competencia = comp.idcompetencia where resp.avaliado <> resp.avaliador and func.nivelavaliador <> 'Estrategico' group by func.setor, comp.tipo, func.nivelavaliador");
		echo '<div class="container"><br><br><br>';
		echo '<table class="table table-bordered">';
		echo '<thead>';
			echo '<tr class="gray">';
				echo '<td><b>SETOR</b></td>';
				echo '<td><b>NIVEL</b></td>';
				echo '<td><b>TIPO</b></td>';
				echo '<td><b>MEDIA</b></td>';
			echo '</tr>';
		echo '</thead>';

		while( $dados = $query->fetch(PDO::FETCH_ASSOC) ){
			echo '<tr>';
				echo '<td>'.$dados['setor'].'</td>';
				echo '<td>'.$dados['nivelavaliador'].'</td>';
				echo '<td>'.$this->escapeTipo( $dados['tipo'] ).'</td>';
				echo '<td>'.number_format($dados['media'], 2, '.', '').'</td>';
			echo '</tr>';
		}

		echo '</table>';
		echo '</div>';
	}

	private function escapeTipo( $tipo ){
		switch ( $tipo ) {
			case 'C':
				return "Comportamental";
				break;
			case 'T':
				return "Técnica";
				break;
			default:
				return "Auto";
				break;
		}
	}
}
?>