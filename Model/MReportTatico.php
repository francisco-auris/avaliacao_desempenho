<?php
class MreportTatico extends CConexao {
	private $id;
	private $gst;
	protected $dados;
	protected $avaliacao;
	protected $auto;

	protected function listColaboradores(){
		$cconexao = $this->conectar();
		$s1 = "Tatico";
		$s2 = "Estrategico";

		//$query = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' ORDER BY setor ASC");
		$setor = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s1' GROUP BY setor ORDER BY setor ASC");
		$setores = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s1' GROUP BY setor ORDER BY setor ASC");

		if( $setor ){
			include_once "View/list/col_tatico.php";
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
		 		$this->dados['gestor'] = $fetch['gestor'];
		 		$this->dados['matgestor'] = $fetch['matgestor'];
		 	}
		 }
		# 2 - PROCURAR AVALIACOES
		 $_avl = $cconexao->prepare("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE fc.matricula = :mat AND rsp.avaliado = :avaliado GROUP BY rsp.avaliador, rsp.competencia");
		 $_avl->bindParam(":mat", $this->gst, PDO::PARAM_INT);
		 $_avl->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		 if( $_avl->execute() ){
		 	while( $avl = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['titulo']);
		 		$this->avaliacao[$ac]['titulo'] = $titulo[0];
		 		$this->avaliacao[$ac]['media'] = $avl['media'];
		 		$ac++;
		 	}
		 }

		# 2.1 - PROCURAR TECNICA
		 $_avl_tecnica = $cconexao->prepare("SELECT cpergunta
			FROM funcionario as fc 
			INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador 
			INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia 
			WHERE fc.matricula = :mat AND rsp.avaliado = :avaliado AND cmp.tipo='T'
			GROUP BY rsp.avaliador, rsp.competencia");
		$_avl_tecnica->bindParam(":mat", $this->gst, PDO::PARAM_INT);
		$_avl_tecnica->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		$adct = 0;
		if( $_avl_tecnica->execute() ){
			$this->avl = $_avl_tecnica->fetch(PDO::FETCH_ASSOC)['cpergunta'];
		}
		
		# 3 - PROCURAR AUTO AVAIACAO
		 $acc=0;
		 $_avl = $cconexao->prepare("SELECT fc.matricula,fc.nome,rsp.*,cmp.titulo,(sum(rsp.nota)/count(rsp.idresposta)) as 'media' FROM funcionario as fc INNER JOIN resposta as rsp on fc.matricula = rsp.avaliador INNER JOIN competencia as cmp on rsp.competencia = cmp.idcompetencia WHERE fc.matricula = :mat AND rsp.avaliado = :avaliado GROUP BY rsp.avaliador, rsp.competencia");
		 $_avl->bindParam(":mat", $this->id, PDO::PARAM_INT);
		 $_avl->bindParam(":avaliado", $this->id, PDO::PARAM_INT);
		 if( $_avl->execute() ){
		 	while( $avl = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['titulo']);
		 		$this->auto[$acc]['titulo'] = $titulo[0];
		 		$this->auto[$acc]['media'] = $avl['media'];
		 		$acc++;
		 	}
		 }
		# 4 - PEGA COMENTARIO DE AVALIACAO
		 $_comenta = $cconexao->prepare("SELECT * FROM coments WHERE avaliador=:avaliador AND avaliado=:avl");
		  $_comenta->bindParam(":avaliador", $this->gst, PDO::PARAM_INT);
		  $_comenta->bindParam(":avl", $this->id, PDO::PARAM_INT);
		  $this->dados['comentario']='';
		  if( $_comenta->execute() ){
		  	while( $fetch = $_comenta->fetch(PDO::FETCH_ASSOC) ){
		  		$this->dados['comentario'] .= '- '.$fetch['comentario'].'<br>';
		  	}
		  }

	}

	protected function geraRelatorio(){
		include_once "Report/col_tatico.php";
	}
}
?>