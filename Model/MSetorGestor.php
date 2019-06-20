<?php
class MSetorGestor extends CConexao {
	private $id;
	private $setores;
	protected $dados;
	protected $avaliacao;
	protected $comentarios;

	protected function listColaboradores(){
		$cconexao = $this->conectar();

		$s2 = "Estrategico";

		//$query = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' ORDER BY setor ASC");
		if( isset($_GET['emp']) ){
			$emp = strtoupper($_GET['emp']);
			$setor = $cconexao->query("SELECT * FROM funcionario WHERE  nivelavaliador='$s2' AND empresa LIKE '".$emp."%' GROUP BY setor ORDER BY setor ASC");
			$setores = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s2' AND empresa LIKE '".$emp."%' GROUP BY setor ORDER BY setor ASC");
		}else {
			$setor = $cconexao->query("SELECT * FROM funcionario WHERE  nivelavaliador='$s2' GROUP BY setor ORDER BY setor ASC");
			$setores = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='$s2' GROUP BY setor ORDER BY setor ASC");
		}
		

		if( $setor ){
			include_once "View/list/col_setor_gestor.php";
		}
		else {
			CMessage::danger("Error ao carregar colaboradores !");
		}
	}

	protected function searchData(){

		$ac=0;

		$this->id = base64_decode($_GET['id']);
		//$this->gst = base64_decode($_GET['gestor']);
		//echo '<br><br><br>'.$this->id.'>>'.$this->gst;
		$cconexao = $this->conectar();
		# 1 - PROCURAR DADOS DO FUNCIONARIO
		$_dados = $cconexao->prepare("SELECT * FROM funcionario WHERE matricula=:matricula");
		 $_dados->bindParam(":matricula", $this->id, PDO::PARAM_INT);
		 
		 if( $_dados->execute() ){
		 	while( $fetch = $_dados->fetch(PDO::FETCH_ASSOC) ){
		 		$this->dados['nome'] = $fetch['nome'];
		 		$this->dados['matricula'] = $fetch['matricula'];
		 		$this->dados['setor'] = $fetch['setor'];
		 		$this->dados['funcao'] = $fetch['funcao'];
		 		
		 	}
		 }
		# 2 - PROCURAR AVALIACOES
		 $_avl = $cconexao->prepare("select
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
	resp.avaliador <> resp.avaliado and comp.tipo = 'C' and resp.avaliado = :mat and resp.avaliador <> funcavaliado.imediato and resp.avaliador <> funcavaliado.superior 
group by 
	func.setor, resp.competencia");
		 $_avl->bindParam(":mat", $this->id, PDO::PARAM_INT);
		 //$_avl->bindParam(":avaliado", $this->gst, PDO::PARAM_INT);
		 if( $_avl->execute() ){
		 	while( $avl = $_avl->fetch(PDO::FETCH_ASSOC) ){
		 		$titulo = explode(":", $avl['competencia']);
		 		$this->avaliacao[$ac]['titulo'] = $titulo[0];
		 		$this->avaliacao[$ac]['media'] = $avl['media'];
		 		$this->avaliacao[$ac]['setor'] = $avl['setor'];
		 		$ac++;
		 	}
		 }
		# 3 - PEGA COMENTARIO DE AVALIACAO
		 $_comenta = $cconexao->prepare("SELECT 
	* 
FROM 
	coments com inner join funcionario func on com.avaliador = func.matricula
    inner join funcionario funcavaliado on com.avaliado = funcavaliado.matricula
where
	avaliador <> avaliado and com.avaliador <> funcavaliado.imediato 
    and com.avaliador <> funcavaliado.superior and com.avaliado = :avl 
    and com.tipo = 'C'");
		  $_comenta->bindParam(":avl", $this->id, PDO::PARAM_INT);
		 //$_comenta->bindParam(":avl", $this->gst, PDO::PARAM_INT);
		  $adc = 0;
		  if( $_comenta->execute() ){
		  	while( $fetch = $_comenta->fetch(PDO::FETCH_ASSOC) ){
		  		$this->dados['comentario'] = $fetch['comentario'];
		  		$this->comentarios[$adc]['comentario'] = $fetch['comentario'];
		  	}
		  }

	}

	protected function geraRelatorio(){
		include_once "Report/col_setor_gestor.php";
	}
}
?>