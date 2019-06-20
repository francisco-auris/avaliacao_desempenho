<!DOCTYPE html>
<html>
<head>
	<title>NDA</title>
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
<?php
include_once "../Controller/CConexao.php";
class ResumoAtividade extends CConexao {

	public $matricula;
	protected $nivel;
	protected $imediato;
	protected $superior;
	protected $nome;
	private $dados;

	function __construct(){

		$this->matricula = $_GET['matricula'];
		$this->pushdados(); # agrupar todos os dados do funcionario 'X' em $this->dados

		$this->perfil( $this->nivel );
		//$this->geraReport();
	}

	public function perfil( $tipo ){
		if( $tipo == "Estrategico" ){
			$this->estrategico();
		}
		if( $tipo == "Tatico" ){
			$this->tatico();
		}
		else if( $tipo == "Operacional" ){
			$this->operacional();
		}
	}

	protected function pushdados(){

		$cconexao = $this->conectar();
		$query = $cconexao->prepare("SELECT * FROM funcionario WHERE matricula=:matricula");
		  $query->bindParam(":matricula", $this->matricula, PDO::PARAM_INT);

		if( $query->execute() AND $query->rowCount() > 0 ){
			while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
				$this->nome = $ftch['nome'];
				$this->nivel = utf8_encode($ftch['nivelavaliador']);
				$this->imediato = $ftch['imediato'];
				$this->superior = $ftch['superior'];
				//echo '<h1>SUCESSO</h1>';
			}
		}
		else {
			echo 'ERROR';
		}

	}


	/****************************** VEF **********************************/
	protected function estrategico(){
		echo '<div class="container">';
		$this->listSubordinados( $this->matricula );
		$this->listMyGestor( $this->imediato, $this->superior);
		$this->autoAvaliacao();
		echo '</div>';
	}
	protected function tatico(){
		echo '<div class="container">';
		$this->listMyGestor( $this->imediato, $this->superior);
		$this->autoAvaliacao();
		echo '</div>';
	}
	protected function operacional(){
		echo '<div class="container">';
		$this->listMyGestor( $this->imediato, $this->superior);
		echo '</div>';
	}
	
	/**********************************************************************************************************************/
	protected function listSubordinados( $matricula ){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT matricula,nome,nivelavaliador,funcao FROM funcionario WHERE imediato LIKE '%$matricula%'");
		if( $query AND $query->rowCount() > 0){
			?>
			<div class="col-md-4 col-sm-4">
			<ul class="list-group">
			  <li class="list-group-item active"><center><b>Avalie sua equipe</b></center></li>
			  <?php
			  while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
			  $tipo = $ftch['nivelavaliador'];
			  $funcao = utf8_encode($ftch['funcao']);
			  $func = $ftch['matricula'];
			  $eu = $this->matricula;
			  	if( $tipo == "Tatico" OR $tipo == "Estrategico"){

			  		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
			  		$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");
			  			$vefTecnica = $cconexao->query("SELECT * FROM pacote WHERE msearch='$funcao'");

			  		//if( $vefTecnica AND $vefTecnica->rowCount() > 0 ){
			  			if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
			  				echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
				  		}
				  		else {
				  			echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
				  		}
			  			
			  	}
			  	if( $tipo == "Operacional" ){
			  		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
			  		$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");
			  		 if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
			  			echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
			  		 }
			  		 else {
			  			echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
			  		 }
			  	}
			  	
			  }
			  ?>
			</ul>
		</div>
		<?php
		}
	}

	protected function listMyGestor( $imediato, $superior ){
		$cconexao = $this->conectar();
		$imediato = $this->escapeImediato( $imediato, $superior );
		//echo '<h1>'.$imediato.'</h1>';
		$query = $cconexao->query("SELECT * FROM funcionario WHERE matricula IN(".$imediato.")");
		if( $query AND $query->rowCount() > 0){
			?>
			<div class="col-md-4 col-sm-4">
			<ul class="list-group">
			  <li class="list-group-item active"><center><b>Avalie Seu Gestor</b></center></li>
			  <?php
			  while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
			  $tipo = $ftch['nivelavaliador'];
			  $func = $ftch['matricula'];
			  $funcao = $ftch['funcao'];
			  $eu = $this->matricula;

			  	$_funcao = $cconexao->query("SELECT * FROM pacote WHERE msearch='$funcao'");
			  	$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
			  	$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");

			  		if( $_SESSION['NIVEL_RH']=="Operacional" ){
			  			if( $_comp->rowCount() > 0 ){
			  				echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
			  			}
			  			else {
			  				echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
			  			}
			  		}
			  		else {
			  			/*if( $_funcao->rowCount() > 0 ){
			  				if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
				  				echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
					  		}
					  		else {
					  			echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
					  		}
			  			}
			  			else {
				  			if( $_comp->rowCount() > 0 ){
				  				echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
					  		}
					  		else {
					  			echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
					  		}
					  	}*/

					  	if( $_comp->rowCount() > 0 ){
				  				echo '<li class="list-group-item list-group-item-success"><i class="glyphicon glyphicon-ok"></i> '.$ftch['nome'].'</li>';
					  		}
					  		else {
					  			echo '<li class="list-group-item list-group-item-danger"><i class="glyphicon glyphicon-remove"></i> '.$ftch['nome'].'</li>';
					  		}
			  		}

			  }
			  ?>
			</ul>
		</div>
		<?php
		}
		else {
			//echo '<h2>NAO ENCONTRADO</h2>';
		}
	}

	protected function autoAvaliacao(){
		$cconexao = $this->conectar();
		$eu = $this->matricula;
		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$eu' AND comp.tipo='C'");
		?>
		<div class="col-md-4 col-sm-4">
			<ul class="list-group">
			  <li class="list-group-item active"><center><b>Auto Avaliação</b></center></li>
			  <?php
			  if( $_comp->rowCount() > 0 ){
			  		echo '<li class="list-group-item list-group-item-success"><center>AUTO AVALIAÇÃO CONCLUÍDA</center></li>';
			  }
			  else {
			  		echo '<li class="list-group-item list-group-item-danger"><center>AUTO AVALIAÇÃO NÃO FEITA</center></li>';
			  	}
			  ?>
			</ul>
		</div>
	<?php
	}

	protected function escapeImediato( $dados, $dado ){
		if( $dado == "" ){
			$str = str_replace("/", ",", $dados);
		}
		else {
			$str = str_replace("/", ",", $dados).','.$dado;
		}
		return $str;
	}

}

if( isset($_GET['matricula']) ){
	$var = new ResumoAtividade;
}
?>
</body>
</html>