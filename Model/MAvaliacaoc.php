<?php
class MAvaliacaoc extends CConexao {

	private $dados;
	private $pacote;

	protected function verify(){
		$cconexao = $this->conectar();
		$func = base64_decode($this->id);
		$avaliador = $_SESSION['LOGIN_RH'];
		$query = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$avaliador' AND resp.avaliado='$func' AND comp.tipo='T'");
		$conta = $query->rowCount();
		if( $conta > 0 OR $func==$_SESSION['IMEDIATO_RH'] ){
			$rect = "F";
		}else {
			$rect = "N";
		}

		return $rect;

	}

	protected function searchFunc(){
		$cconexao = $this->conectar();
		$func = base64_decode($this->id);
		$query = $cconexao->query("SELECT * FROM funcionario WHERE matricula='$func'");
		if( $query ){
			while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
				$this->dados['empresa'] = $ftch['empresa'];
				$this->dados['setor'] = $ftch['setor'];
				$this->dados['funcao'] = $ftch['funcao'];
				$this->dados['nome'] = $ftch['nome'];
				$this->dados['level'] = utf8_encode($ftch['nivelavaliador']);
				$nivel = $ftch['nivelavaliador'];
				if($nivel=="Operacional"){
					$this->dados['nivel'] = "O";
				}
				if($nivel=="Estrategico"){
					$this->dados['nivel'] = "E";
				}
				elseif($nivel=="Tatico"){
					$this->dados['nivel'] = "T";
				}
				
			}
			include_once "View/modal/hd_avaliacao_tecnica.php";
			//echo $this->dados['nivel'];
		}
		else {
			CMessage::danger("Nenhum funcionario encontrado.");
		}
	}

	protected function geraAvaliacao(){
		$cconexao = $this->conectar();
		$serchPCT = $cconexao->query("SELECT * FROM pacote WHERE msearch='".$this->dados['funcao']."'");
		if( $serchPCT AND $serchPCT->rowCount() > 0 ){
			# joga dados do pacote no $pacote[private]
			while( $ftch = $serchPCT->fetch(PDO::FETCH_ASSOC) ){
				$this->pacote['titulo'] = $ftch['titulo'];
				$this->pacote['competencias'] = $ftch['pcompetencia'];
			}
			echo '<div class="container">';
			echo '<form method="post" action="?window=avaliacaoc&id='.$_GET['id'].'&action=salva&tag='.$this->pacote['titulo'].'">';
			# instancia render comp e pergunta
			$this->geraCabecalho();
			$this->viewCompetencia( $this->pacote['competencias'] );
			$this->comentario();
			echo '</form>';
			echo '</div>';
		}
		else {
			CMessage::danger("Nenhuma avaliacao encontrada.");
			CCentral::redireciona("?window=mensagem&id=".$_GET['id']."&action=sucesso");
		}
	}

	private function viewCompetencia( $vetor ){
		$new = explode("/", $vetor);
		$conta = count( $new );
		for( $j=0; $j < $conta; $j++ ){
			$this->geraCompetencia( $new[$j] );
		}
	}
	private function viewPergunta( $vetor, $tcomp ){
		$new = explode("/", $vetor);
		$conta = count( $new );
		for( $j=0; $j < $conta; $j++ ){
			$token = md5($j.$tcomp);
			$this->geraPergunta( $new[$j], $tcomp, $j+1 );
		}
	}

	protected function geraCompetencia( $idComp ){
		$token = md5($idComp);
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM competencia WHERE idcompetencia='$idComp'");
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		echo '<table class="table" border="1">';
		echo'';
	    /*echo   '<tr class="gray">';
	    echo     '<th colspan="5">'.$fetch['titulo'].'</th>';
	    echo  '</tr>';*/
		echo '';
		
	    echo '<tr>';
	    echo 	'<td class="grayb" align="center" valign="middle" rowspan="2"><b>PERGUNTAS</b></td>';
		echo    '<td class="grayb" align="center" width="5%" colspan="2"><b>0,0</b></td>';
		echo    '<td class="grayb" align="center" width="5%" colspan="2"><b>5,0</b></td>';
	    echo 	'<td class="grayb" align="center" width="5%" colspan="2"><b>10,0</b></td>';
	    echo '</tr>';
	    echo '<tr>';
	    echo    '<td class="gray" align="center" width="5%" colspan="6"><b>NOTA</b></td>';
		/*echo 	'<td class="gray" align="center" width="5%" colspan="2"><b>SIM</b></td>';
		echo 	'<td class="gray" align="center" width="5%" colspan="2"><b>SIM</b></td>';*/
	    echo '</tr>';
		$this->viewPergunta( $fetch['cpergunta'], $token );
		echo '<tr>';
		echo '<td class="grayb" width="40%"></td><td colspan="5"><b>AVALIAÇÃO FINAL NOTA :</b><span class="total_'.$token.'"></span></td>';
		echo '</tr>';
		echo '</table>';
	}
	protected function geraPergunta( $idPergunta, $tcomp, $seq ){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM pergunta WHERE idpergunta='$idPergunta'");
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		$token = base64_encode($fetch['idpergunta']);
		echo '<tr>';
			echo '<td>'.$fetch['contexto'].'</td>';
			echo '<td align="center" colspan="2"><input type="radio" required value="0" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaCompC("'.$token.'","'.$tcomp.'");></td>';
			echo '<td align="center" colspan="2"><input type="radio" required value="5" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaCompC("'.$token.'","'.$tcomp.'");></td>';
			echo '<td align="center" colspan="2"><input type="radio" required value="10" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaCompC("'.$token.'","'.$tcomp.'");></td>';
		echo '</tr>';
	}

	private function geraCabecalho(){
		echo '<table class="table" border="1">';
		echo'<thead>';
		echo '<tr>';
			echo '<td class="gray" align="center" colspan="2"><h3>AVALIAÇÃO DE DESEMPENHO COMPETÊNCIAS TÉCNICAS<bR><hr>';
				echo '<small style="color:black;">A competência técnica tem como base o conhecimento adquirido na formação profissional e obtidas com treinamentos, palestras, faculdade, cursos, livros entre outros.</small></h3>';
			echo '</td>';
		echo '</tr>';
		echo '</thead>';
		echo '<tr style="font-size:12px;">';
			echo '<td class="grayb" align="right" colspan="2">AVALIAÇÃO: <span class="badge">'.$this->pacote['titulo'].'</span></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="grayb"><b>NOME DO AVALIADO:</b></td>';
			echo '<td>'.$this->dados['nome'].'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="grayb"><b>CARGO:</b></td>';
			echo '<td>'.$this->dados['funcao'].'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="grayb"><b>SETOR:</b></td>';
			echo '<td>'.$this->dados['setor'].'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="grayb"><b>NOME DO AVALIADOR:</b></td>';
			echo '<td>'.$_SESSION['NOME_RH'].'</td>';
		echo '</tr>';
		echo '</table>';
	}

	private function comentario(){
		echo '<table class="table" border="1">';
		echo '<tr>';
			echo '<td class="gray"><b><center>Comentários do Avaliador</center></b></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td><textarea class="form-control" name="comentario" placeholder="Digite seu comentario aqui." required></textarea></td>';
		echo '</tr>';
		echo '</table>';
		echo '<input type="submit" value="salvar" class="btn btn-block btn-primary"><br><br>';
	}

	protected function pegaPerguntas( $tag ){
		$PERGUNTAS = array(); # array central de todas as perguntas do pacote
		$ac=0;
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM pacote WHERE titulo='$tag'");
		if( $query ){
			$ftch = $query->fetch(PDO::FETCH_ASSOC);
			$competencias = explode("/", $ftch['pcompetencia']);
			for( $x=0; $x < count($competencias); $x++ ){
				$queryPerg = $cconexao->query("SELECT * FROM competencia WHERE idcompetencia='".$competencias[$x]."'");
				$_fetch = $queryPerg->fetch(PDO::FETCH_ASSOC);
				$_perg = explode("/", $_fetch['cpergunta']);
				for( $j=0; $j < count($_perg); $j++){
					$PERGUNTAS[$ac]['p'] = $_perg[$j];
					$PERGUNTAS[$ac]['c'] = $competencias[$x];
					$ac++;
				}
			}

			return $PERGUNTAS;
		}
		else {
			CMessage::danger("Error ao procurar pacote.");
		}
	}

	protected function execInsert( $eu, $avaliado, $pergunta, $resp, $comp ){
		$script = "INSERT INTO resposta (idpergunta,nota,avaliador,avaliado,competencia) VALUES ('$pergunta','$resp','$eu','$avaliado','$comp')";
		$cconexao = $this->conectar();
		$query = $cconexao->query( $script );
		if( $query ){
			$this->error = $this->error + 1;
		}
		else {
			$this->error = $this->error - 1;
		}
    }

    protected function insertcomentario(){
    	$cconexao = $this->conectar();
    	$query = $cconexao->prepare("INSERT INTO coments VALUES (0, :avaliador, :avaliado, :comentario, 'T')");
    	 $query->bindParam(":avaliador", $_SESSION['LOGIN_RH'], PDO::PARAM_INT);
    	 $query->bindParam(":avaliado", base64_decode($_GET['id']), PDO::PARAM_INT);
    	 $query->bindParam(":comentario", $_POST['comentario'], PDO::PARAM_STR);
    	 $query->execute();
    }
	
}
?>