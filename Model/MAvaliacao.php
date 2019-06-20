<?php
class MAvaliacao extends CConexao {

	private $pacote;

	protected function verify(){
		$cconexao = $this->conectar();
		$func = base64_decode($this->id);
		$avaliador = $_SESSION['LOGIN_RH'];
		$query = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$avaliador' AND resp.avaliado='$func' AND comp.tipo='C'");
		$conta = $query->rowCount();
		if( $conta > 0 ){
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
				$this->dados['matricula'] = $ftch['matricula'];
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
			include_once "View/modal/hd_avaliacao.php";
			//echo $this->dados['nivel'];
		}
		else {
			CMessage::danger("Nenhum funcionario encontrado.");
		}
	}

	protected function geraAvaliacao(){
		$cconexao = $this->conectar();
		$serchPCT = $cconexao->query("SELECT * FROM pacote WHERE tipo='".$this->dados['nivel']."'");
		if( $serchPCT AND $serchPCT->rowCount() > 0 ){
			# joga dados do pacote no $pacote[private]
			while( $ftch = $serchPCT->fetch(PDO::FETCH_ASSOC) ){
				$this->pacote['titulo'] = $ftch['titulo'];
				$this->pacote['competencias'] = $ftch['pcompetencia'];
			}
			echo '<div class="container">';
			echo '<form method="post" action="?window=avaliacao&id='.$_GET['id'].'&action=salva&tag='.$this->pacote['titulo'].'">';
			# instancia render comp e pergunta
			$this->geraCabecalho();
			$this->viewCompetencia( $this->pacote['competencias'] );
			$this->comentario();
			echo '</form>';
			echo '</div>';
		}
		else {
			CMessage::danger("Nenhuma avaliacao encontrada.");
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
	    echo   '<tr class="gray">';
	    echo     '<th colspan="5">'.$fetch['titulo'].'</th>';
	    echo  '</tr>';
	    echo '';
	    echo '<tr>';
	    echo 	'<td class="grayb" align="center"><b>Perguntas</b></td><td class="grayb" align="center" width="5%"><b>10</b></td>';
	    echo 	'<td class="grayb" align="center" width="5%"><b>7,5</b></td>';
	    echo 	'<td class="grayb" align="center" width="5%"><b>5,0</b></td>';
	    echo 	'<td class="grayb" align="center" width="5%"><b>0,0</b></td>';
	    echo '</tr>';
		$this->viewPergunta( $fetch['cpergunta'], $token );
		echo '<tr>';
		echo '<td colspan="3" class="grayb"></td><td colspan="2"><b>Total:</b><span class="total_'.$token.'"></span></td>';
		echo '</tr>';
		echo '</table>';
	}
	protected function geraPergunta( $idPergunta, $tcomp, $seq ){
		$cconexao = $this->conectar();
		$query = $cconexao->query("SELECT * FROM pergunta WHERE idpergunta='$idPergunta'");
		$fetch = $query->fetch(PDO::FETCH_ASSOC);
		$token = $fetch['idpergunta'];
		#$texto = mb_convert_encoding($fetch['contexto'], 'ISO-8859-14', 'UTF-8');
		echo '<tr>';
			echo '<td>'.$fetch['contexto'].'</td>';
			echo '<td align="center"><input type="radio" required value="10" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaComp("'.$token.'","'.$tcomp.'");></td>';
			echo '<td align="center"><input type="radio" required value="7.5" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaComp("'.$token.'","'.$tcomp.'");></td>';
			echo '<td align="center"><input type="radio" required value="5" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaComp("'.$token.'","'.$tcomp.'");></td>';
			echo '<td align="center"><input type="radio" required value="0" data-seq="'.$seq.'" data-comp="'.$tcomp.'" name="'.$token.'" onclick=calMediaComp("'.$token.'","'.$tcomp.'");></td>';
		echo '</tr>';
	}

	private function geraCabecalho(){
		echo '<table class="table" border="1">';
		echo'<thead>';
		echo '<tr>';
			echo '<td class="gray" align="center" colspan="4"><h3>AVALIAÇÃO DE DESEMPENHO COMPETÊNCIAS COMPORTAMENTAIS<br><hr>';
				echo '<small style="color:black;">Competências Comportamentais é a compreensão e domínio sobre as  habilidades, capacidades, oportunidades de melhoria e potencialidades do ser humano.</small></h3>';
			echo '</td>';
		echo '</tr>';
		echo '</thead>';
		echo '<tr style="font-size:12px;">';
			echo '<td class="grayb" align="right" colspan="4">AVALIAÇÃO: <span class="badge">'.$this->pacote['titulo'].'</span></td>';
		echo '</tr>';
		echo '<tr style="font-size:2em;">';
			echo '<td align="center"><b>10</b></td>';
			echo '<td align="center"><b>7,5</b></td>';
			echo '<td align="center"><b>5,0</b></td>';
			echo '<td align="center"><b>0,0</b></td>';
		echo '</tr>';
		echo '<tr style="font-size:12px;" class="grayb">';
			echo '<td align="center"><b>ATENDE TOTALMENTE</b></td>';
			echo '<td align="center"><b>ATENDE PARCIALMENTE</b></td>';
			echo '<td align="center"><b>ATENDE RARAMENTE</b></td>';
			echo '<td align="center"><b>NUNCA ATENDE</b></td>';
		echo '</tr>';
		echo '</table>';
	}

	private function comentario(){
		echo '<table class="table" border="1">';
		echo '<tr>';
			echo '<td class="gray"><b><center>COMENTÁRIO(S)</center></b></td>';
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
			//echo "[C] - ".$script."<br>";
			/*if( $this->dados['nivel']=="T" OR $this->dados['nivel']=="E" ){
				CCentral::redireciona("?window=avaliacaoc&id=".$this->id."");
				//CMessage::centralNext('Avaliacao feita com sucesso');
			}
			else {
				CCentral::redireciona("?window=home");
			}*/
			$this->error = $this->error + 1;
			
		}
		else {
			//echo "[E] - ".$script."<br>";
			$this->error = $this->error - 1;
			//CMessage::centralError("Não foi possivel salvar sua avaliação.");
		}
    }

    protected function insertcomentario(){
    	$cconexao = $this->conectar();
    	$id = base64_decode($_GET['id']);
    	$query = $cconexao->prepare("INSERT INTO coments VALUES (0, :avaliador, :avaliado, :comentario, 'C')");
    	 $query->bindParam(":avaliador", $_SESSION['LOGIN_RH'], PDO::PARAM_INT);
    	 $query->bindParam(":avaliado", $id, PDO::PARAM_INT);
    	 $query->bindParam(":comentario", $_POST['comentario'], PDO::PARAM_STR);
    	 $query->execute();
    }
	
}
?>