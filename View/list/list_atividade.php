<div class="container">
<br><br><br>
<table class="table table-hover" >
	<thead>
		<td></td>
		<td width="5%"><b>MATRICULA</b></td>
		<td><b>NOME</b></td>
		<td><b>SETOR</b></td>
		<td><b>ATIVIDADE(s)</b></td>
	</thead>
	<?php
	while( $fetch = $query->fetch(PDO::FETCH_ASSOC) ){
		$nivel = $fetch['nivelavaliador'];
		$mat = $fetch['matricula'];
		$adc = 0;$adcg = 0;

			$imediato = $fetch['imediato'];
		
		$funcao = $fetch['funcao'];
		$listagem = '';
		echo '<tr>';
		echo '<td><a onclick="total('.$fetch['matricula'].');" data-toggle="tooltip" title="Mais informações." style="cursor:pointer;"><i class="glyphicon glyphicon-info-sign"></i></a></td>';
		echo '<td>'.$fetch['matricula'].'</td>';
		echo '<td>'.$fetch['nome'].'</td>';
		echo '<td>'.utf8_encode($fetch['setor']).'</td>';
		echo '<td>';
		if( $nivel=="Estrategico" ){
			$_auto = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='$mat'");
			if( $_auto AND $_auto->rowCount() > 0 ){
				echo '<span class="badge success">AUTO AVL</span>';
			}
			else {
				echo '<span class="badge notfeito">AUTO AVL</span>';
			}
			$_col = $cconexao->query("SELECT * FROM funcionario WHERE imediato LIKE '%$mat%'");
			$colaboradores='';
			while( $col = $_col->fetch(PDO::FETCH_ASSOC) ){
				$adcol = $col['matricula'];
				//---> $temp = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='$adcol'");
				$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$mat' AND resp.avaliado='$adcol' AND comp.tipo='C'");
		  		$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$mat' AND resp.avaliado='$adcol' AND comp.tipo='T'");
		  			$vefTecnica = $cconexao->query("SELECT * FROM pacote WHERE msearch='$funcao'");
				if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
					$adc++;
				}
				$colaboradores .= $col['nome'].'&ensp; \ &ensp;';
			}
			if( $adc == $_col->rowCount() ){
				echo '<span class="badge success" data-toggle="tooltip" data-placement="bottom" title="'.$colaboradores.'">EQUIPE '.$adc.'/'.$_col->rowCount().'</span>';
			}
			else {
				echo '<span class="badge notfeito" data-toggle="tooltip" data-placement="bottom" title="'.$colaboradores.'">EQUIPE '.$adc.'/'.$_col->rowCount().'</span>';
			}
			# em busca do imediato
			if( $imediato == "0" OR $imediato=="" ){

			}else { //inicio do else
				$imediatos = explode("/", $imediato);
				for( $j=0; $j < count($imediatos); $j++ ){
					$_query = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='".$imediatos[$j]."'");
					if( $_query AND $_query->rowCount() > 0 ){
						$adcg++;
					}
				}
				if( $adcg == count($imediatos) ){
					echo '<span class="badge success">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
				else {
					echo '<span class="badge notfeito">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
			}//fim do else		
		}
		if( $nivel=="Tatico" ){
			$_auto = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='$mat'");
			if( $_auto AND $_auto->rowCount() > 0 ){
				echo '<span class="badge success">AUTO AVL</span>';
			}
			else {
				echo '<span class="badge notfeito">AUTO AVL</span>';
			}
			# em busca do imediato
			if( $imediato == "0" OR $imediato=="" ){

			}else { //inicio do else
				$imediatos = explode("/", $imediato);
				for( $j=0; $j < count($imediatos); $j++ ){
					$_query = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='".$imediatos[$j]."'");
					if( $_query AND $_query->rowCount() > 0 ){
						$adcg++;
					}
				}
				if( $adcg == count($imediatos) ){
					echo '<span class="badge success">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
				else {
					echo '<span class="badge notfeito">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
			}

		}
		if( $nivel=="Operacional" ) {
			# em busca do imediato
			if( $imediato == "0" OR $imediato=="" ){

			}else { //inicio do else
				
				$imediatos = explode("/", $imediato);
				for( $j=0; $j < count($imediatos); $j++ ){
					$_query = $cconexao->query("SELECT * FROM resposta WHERE avaliador='$mat' AND avaliado='".$imediatos[$j]."'");
					if( $_query AND $_query->rowCount() > 0 ){
						$adcg++;
					}
				}
				if( $adcg == count($imediatos) ){
					echo '<span class="badge success">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
				else {
					echo '<span class="badge notfeito">GESTOR '.$adcg.'/'.count($imediatos).'</span>';
				}
			}
		}
		echo '</td>';
		echo '</tr>';
	}
	?>
</table>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>