<?php
class MColOperacional extends CConexao {

	private $id;
	private $gst;
	protected $dados;
	protected $avaliacao;
	protected $tecnica;
	protected $avl;

	protected function listColaboradores(){
		$cconexao = $this->conectar();
		//$query = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' ORDER BY setor ASC");
		$setor = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' GROUP BY setor ORDER BY setor ASC");
		$setores = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' GROUP BY setor ORDER BY setor ASC");

		if( $setor ){
			include_once "View/list/col_operacional.php";
		}
		else {
			CMessage::danger("Error ao carregar colaboradores !");
		}
	}

	protected function searchData(){

		$ac=0;

		$this->id = base64_decode($_GET['id']);
		$this->gst = base64_decode($_GET['gestor']);
		//echo '<br><br><br>'.$this->id.'>>'.$this->gst;
		$cconexao = $this->conectar();
		$explode = explode(",", $this->gst);

		if( count($explode) > 1 ){

			$_dados = $cconexao->query("SELECT * FROM funcionario WHERE matricula='".$this->id."'");
			while( $fetch = $_dados->fetch(PDO::FETCH_ASSOC) ){
				$this->dados['nome'] = $fetch['nome'];
			 	$this->dados['matricula'] = $fetch['matricula'];
			 	$this->dados['setor'] = $fetch['setor'];
			 	$this->dados['funcao'] = $fetch['funcao'];
			 	$this->dados['gestor'] = '';
			}
			$nome_gestor = $cconexao->query("SELECT nome FROM funcionario WHERE matricula IN(".$this->gst.")");
			$conta = $nome_gestor->rowCount();
			$ad = 1;
			while ($dts = $nome_gestor->fetch(PDO::FETCH_ASSOC)) {
				if( $ad == $conta ){
					$this->dados['gestor'] .= $dts['nome'];
				}else {
					$this->dados['gestor'] .= $dts['nome'].', ';
				}
				$ad++;
			}

		}else {

			# 1 - PROCURAR DADOS DO FUNCIONARIO
			$_dados = $cconexao->prepare("SELECT fc.*,fa.nome AS gestor,fa.matricula AS matgestor FROM funcionario AS fc INNER JOIN funcionario AS fa ON fa.matricula=:gestor WHERE fc.matricula=:matricula");
			 $_dados->bindParam(":matricula", $this->id, PDO::PARAM_INT);
			 $_dados->bindParam(":gestor", $this->gst, PDO::PARAM_INT);

			 if( $_dados->execute() ){
			 	while( $fetch = $_dados->fetch(PDO::FETCH_ASSOC) ){
			 		$this->dados['nome'] = $fetch['nome'];
			 		$this->dados['matricula'] = $fetch['matricula'];
			 		$this->dados['setor'] = $fetch['setor'];
			 		$this->dados['funcao'] = $fetch['funcao'];
			 		$this->dados['imediato'] = $fetch['imediato'];
			 		$this->dados['gestor'] = $fetch['gestor'];
			 	}
			 }

		}
		# 2 - PROCURAR AVALIACOES
		 //$_avl = $cconexao->prepare("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE rsp.avaliador=:imediato AND rsp.avaliado = :mat AND cmp.tipo='C' GROUP BY rsp.avaliador, rsp.competencia");
		 $_avl = $cconexao->prepare("SELECT rsp.competencia,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE rsp.avaliado = :mat AND cmp.tipo='C' GROUP BY rsp.competencia");
		 $_avl->bindParam(":mat", $this->id, PDO::PARAM_INT);
		// $_avl->bindParam(":imediato", $this->gst, PDO::PARAM_INT);
		 if( $_avl->execute() ){
		 	while( $avl = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['titulo']);
		 		$this->avaliacao[$ac]['titulo'] = $titulo[0];
		 		$this->avaliacao[$ac]['media'] = $avl['media'];
		 		$ac++;
		 	}
		 }
		 /********************************************************************************************************************/
		  $_avlt = $cconexao->prepare("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE rsp.avaliador=:imediato AND rsp.avaliado = :mat AND cmp.tipo='T' GROUP BY rsp.avaliador, rsp.competencia");
		 $_avlt->bindParam(":mat", $this->id, PDO::PARAM_INT);
		 $_avlt->bindParam(":imediato", $this->gst, PDO::PARAM_INT);
		 $adc=0;
		 if( $_avlt->execute() ){
		 	while( $avlt = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['titulo']);
		 		$this->tecnica[$adc]['titulo'] = $titulo[0];
		 		$this->tecnica[$adc]['media'] = $avlt['media'];
		 		$adc++;
		 	}
		 }

		 # 2.1 - PROCURAR TECNICA
		 $_avl_tecnica = $cconexao->prepare("SELECT cpergunta
			FROM funcionario as fc 
			INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador 
			INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia 
			WHERE fc.matricula = :mat AND rsp.avaliado = :avaliado AND cmp.tipo='T'
			GROUP BY rsp.avaliador, rsp.competencia");
		$_avl_tecnica->bindParam(":mat", $explode[0], PDO::PARAM_INT);
		$_avl_tecnica->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		$adct = 0;
		if( $_avl_tecnica->execute() ){
			$this->avl = $_avl_tecnica->fetch(PDO::FETCH_ASSOC)['cpergunta'];
		}

		# 3 - PEGA COMENTARIO DE AVALIACAO
		//$meu_avaliador = $this->gst;
		 $_comenta = $cconexao->query("SELECT * FROM coments WHERE avaliado='".$this->id."' AND avaliador IN(".$this->gst.") AND tipo='C'");
		 $_comentat = $cconexao->query("SELECT * FROM coments WHERE avaliado='".$this->id."' AND avaliador IN(".$this->gst.") AND tipo='T'");
		  //$_comenta->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		  //$_comenta->bindParam(":avl", $this->gst, PDO::PARAM_INT);
		  if( $_comenta ){
		  	while( $fetch = $_comenta->fetch(PDO::FETCH_ASSOC) ){
		  		$this->dados['comentario'] .= '<br>-'.$fetch['comentario'];
		  	}
		  }

		  while( $t = $_comentat->fetch(PDO::FETCH_ASSOC) ){
		  	$this->dados['comentario_t'] .= '<br>-'.$t['comentario'];
		  }

		  //$this->dados['comentario_t'] = $_comentat->fetch(PDO::FETCH_ASSOC)['comentario'];

		  //print_r($this->dados);

	}

	protected function geraRelatorio(){
		include_once "Report/col_operacional.php";
	}
}
?>