<?php
class MReportGestor extends CConexao {

	var $dados;
	var $_comp;
	var $_tecn;
	var $_auto;
	var $_equipe;
	var $_comentarios;
	var $avl;
	protected $id;
	protected $gestor;

	protected function listColaboradores(){
		$cconexao = $this->conectar();

		$s2 = "Estrategico";

		//$query = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' ORDER BY setor ASC");
		$setor = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s2' GROUP BY setor ORDER BY setor ASC");
		$setores = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s2' GROUP BY setor ORDER BY setor ASC");

		if( $setor ){
			include_once "View/list/list_gestor.php";
		}
		else {
			CMessage::danger("Error ao carregar colaboradores !");
		}
	}

	protected function searchData(){

		$cconexao = $this->conectar();

		$this->id = base64_decode($_GET['id']);
		$this->gestor = base64_decode($_GET['gestor']);

		$this->comentarios();

		#1 - Dados do funcionario
		$queryCMP = $cconexao->prepare("SELECT fc.*,fa.nome AS gestor,fa.matricula AS matgestor FROM funcionario AS fc LEFT JOIN funcionario AS fa ON fa.matricula = :gestor WHERE fc.matricula=:matricula");
		 $queryCMP->bindParam(":gestor", $this->gestor, PDO::PARAM_INT);
		 $queryCMP->bindParam(":matricula", $this->id, PDO::PARAM_INT);
		 if( $queryCMP->execute() ){
		 	while( $fetch = $queryCMP->fetch(PDO::FETCH_ASSOC) ){
		 		$this->dados['nome'] = $fetch['nome'];
		 		$this->dados['matricula'] = $fetch['matricula'];
		 		$this->dados['setor'] = $fetch['setor'];
		 		$this->dados['funcao'] = $fetch['funcao'];
		 		$this->dados['gestor'] = $fetch['gestor'];
		 		$this->dados['mat_gestor'] = $fetch['matgestor'];
		 	}
		 }

		#2 - Dados de comportamental
		 # 2.1 - PROCURAR TECNICA
		 $_avl_tecnica = $cconexao->prepare("SELECT cpergunta
			FROM funcionario as fc 
			INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador 
			INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia 
			WHERE fc.matricula = :mat AND rsp.avaliado = :avaliado AND cmp.tipo='T'
			GROUP BY rsp.avaliador, rsp.competencia");
		$_avl_tecnica->bindParam(":mat", $this->gestor, PDO::PARAM_INT);
		$_avl_tecnica->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		$adct = 0;
		if( $_avl_tecnica->execute() ){
			$this->avl = $_avl_tecnica->fetch(PDO::FETCH_ASSOC)['cpergunta'];
		}
		#3 - Dados de tecnica
		 $_comenta = $cconexao->prepare("SELECT * FROM coments WHERE avaliador=:avaliador AND avaliado=:avl AND tipo='C'");
		  $_comenta->bindParam(":avl", $this->id, PDO::PARAM_INT);
		  $_comenta->bindParam(":avaliador", $this->gestor, PDO::PARAM_INT);
		  if( $_comenta->execute() ){
		  	while( $fetch = $_comenta->fetch(PDO::FETCH_ASSOC) ){
		  		$this->dados['comentario'] = $fetch['comentario'];
		  	}
		  }
		  $_comentario = $cconexao->prepare("SELECT * FROM coments WHERE avaliador=:avl AND avaliado=:avl AND tipo='A'");
		  $_comentario->bindParam(":avl", $this->id, PDO::PARAM_INT);
		  //$_comenta->bindParam(":avaliador", $this->gestor, PDO::PARAM_INT);
		  if( $_comentario->execute() ){
		  	while( $fetch = $_comentario->fetch(PDO::FETCH_ASSOC) ){
		  		$this->dados['comentario_auto'] = $fetch['comentario'];
		  	}
		  }

		 $equipe_qtd = $cconexao->prepare("SELECT * FROM resposta WHERE avaliado=:matricula AND avaliador<>:matricula AND avaliador<>:gst group by avaliador");
		 $equipe_qtd->bindParam(":matricula", $this->id, PDO::PARAM_INT);
		 $equipe_qtd->bindParam(":gst", $this->gestor, PDO::PARAM_INT);
		 if( $equipe_qtd->execute() ){
		 	$contador = $equipe_qtd->rowCount();
		 	$this->dados['qtd_equipe'] = $contador;
		 }

	}

	protected function geraRelatorio(){
		include_once "Report/gestor.php";
	}

	private function viewNotas(){

		$gestor = $this->gestor;
		$avaliado = $this->id;
		$cconexao = $this->conectar();
		$queryAVLC = $cconexao->query("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media',cmp.tipo 
		FROM funcionario as fc 
		INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador 
		INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia 
		WHERE fc.matricula = '$gestor' AND rsp.avaliado = '$avaliado' AND cmp.tipo='C'
		GROUP BY rsp.avaliador, rsp.competencia");
		$queryAVLT = $cconexao->query("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media',cmp.tipo 
		FROM funcionario as fc 
		INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador 
		INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia 
		WHERE fc.matricula = '$gestor' AND rsp.avaliado = '$avaliado' AND cmp.tipo='T'
		GROUP BY rsp.avaliador, rsp.competencia");
		$ac = 0;
		while( $fetch = $queryAVLC->fetch(PDO::FETCH_ASSOC) ){
			$this->_comp[$ac]['titulo'] = $fetch['titulo'];
			$this->_comp[$ac]['nota'] = $fetch['media'];
			$ac++;
		}
		while( $fetch = $queryAVLT->fetch(PDO::FETCH_ASSOC) ){
			$this->_tecn[$ac]['titulo'] = $fetch['titulo'];
			$this->_tecn[$ac]['nota'] = $fetch['media'];
			$ac++;
		}
		$T1=0;
		for( $j=0; $j < count($this->_comp); $j++ ){
			$_title = explode(":", $this->_comp[$j]['titulo']);
			echo '<tr>';
			echo '<td colspan="2">'.$_title[0].'</td>';
			echo '<td>'.number_format($this->_comp[$j]['nota'], 2, '.', '').'</td>';
			echo '</tr>';
			$T1 += $this->_comp[$j]['nota'];
		}
		echo '<tr>';
		echo '	<td colspan="3" align="right"><b>NOTA GERAL: </b>'.number_format($T1/count($this->_comp), 2, '.', '').'</td>';
		echo '</tr>';
		$T2=0;
		/*for( $j=0; $j < count($this->_tecn); $j++ ){
			//$_title = explode(":", $this->_comp[$j]['titulo']);
			echo '<tr>';
			echo '<td colspan="2"><b>'.$this->_tecn[$j]['titulo'].'</b></td>';
			echo '<td>'.number_format($this->_tecn[$j]['nota'], 2, '.', '').'</td>';
			echo '</tr>';
			$T2 += $this->_comp[$j]['nota'];
		}*/

		/**********************************************************************************************************************/
		 $_avl = $cconexao->prepare("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE fc.matricula = :mat AND rsp.avaliado = :mat GROUP BY rsp.avaliador, rsp.competencia");
		 $_avl->bindParam(":mat", $this->id, PDO::PARAM_INT);
		 //$_avl->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		 $aac=0;
		 if( $_avl->execute() ){
		 	while( $avl = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['titulo']);
		 		$this->_auto[$aac]['titulo'] = $titulo[0];
		 		$this->_auto[$aac]['media'] = $avl['media'];
		 		$aac++;
		 	}
		 }
		/*********************************************************************************************************************/
		$queryEquipe = $cconexao->prepare("select
											func.setor,
											sum(resp.nota) as 'soma notas', 
											count(resp.idresposta) as 'qtd perguntas',
											(sum(resp.nota)/count(resp.idresposta)) as 'media', 
											comp.titulo as 'competencia'
										from
											resposta as resp inner join competencia as comp on resp.competencia = comp.idcompetencia
										    inner join funcionario as func on resp.avaliador = func.matricula
										    inner join funcionario as funcavaliado on resp.avaliado = funcavaliado.matricula
										where
											resp.avaliador <> resp.avaliado and comp.tipo = 'C' and resp.avaliado = :matricula and resp.avaliador <> funcavaliado.imediato and resp.avaliador <> funcavaliado.superior 
										group by
											resp.competencia;");
		$queryEquipe->bindParam(":matricula", $this->id, PDO::PARAM_INT);
		$accd=0;
		if( $queryEquipe->execute() ){
			while( $avle = $queryEquipe->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avle['competencia']);
		 		$this->_equipe[$accd]['titulo'] = $titulo[0];
		 		$this->_equipe[$accd]['media'] = $avle['media'];
		 		$accd++;
		 	}
		}

	}

	protected function comentarios(){
		$cconexao = $this->conectar();
		$return = "";
		$query = $cconexao->prepare("SELECT * FROM coments WHERE avaliado=:id AND avaliador<>:id AND avaliador<>:gestor");
		$query->bindParam(":gestor", $this->gestor, PDO::PARAM_INT);
		$query->bindParam(":id", $this->id, PDO::PARAM_INT);
		if( $query->execute() AND $query->rowCount() > 0 ){
			while( $cc = $query->fetch(PDO::FETCH_ASSOC) ){
				$return .= '-'.ucfirst($cc['comentario']).'<br>';
			}
		}
		else {
			$return = "";
		}

		$this->_comentarios = $return;

	}

}

?>