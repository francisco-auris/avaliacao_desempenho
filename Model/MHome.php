<?php
class MHome extends CConexao {

	protected function listSubordinados( $matricula ){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT matricula,nome,nivelavaliador,funcao FROM funcionario WHERE imediato LIKE '%$matricula%'");
		if( $query AND $query->rowCount() > 0){
			include_once "View/modal/avl_subordinados.php";
		}
	}

	protected function listMyGestor( $imediato, $superior ){
		$cconexao = $this->conectar();
		$imediato = $this->escapeImediato( $imediato, $superior );
		//echo '<h1>'.$imediato.'</h1>'; -- linha de teste de retorno de string de imediato
		$query = $cconexao->query("SELECT * FROM funcionario WHERE matricula IN(".$imediato.")");
		if( $query AND $query->rowCount() > 0){
			include_once "View/modal/avl_mygestor.php";
		}
		else {
			//echo '<div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-info-sign"></i> Gestor(es) não encontrado.</div>';
			CMessage::fixed("Gestor não encontrado ou não existe.","warning");
		}
	}

	protected function autoAvaliacao(){
		$cconexao = $this->conectar();
		$eu = $_SESSION['LOGIN_RH'];
		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$eu' AND comp.tipo='C'");
		include_once "View/modal/avl_auto.php";
	}

	protected function escapeImediato( $dados, $dado ){
		if( $dado == "" OR $dado==0){
			$str = str_replace("/", ",", $dados);
		}
		else {
			$sts = str_replace("/", ",", $dado);
			$str = str_replace("/", ",", $dados).','.$sts;
		}
		return $str;
	}

}
?>