<div class="container">
<br><br><br>
	<table class="table" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					<h2>AVALIAÇÃO DE DESEMPENHO</h2>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="2"><b>NOME:</b> <?php echo $this->dados['nome'];?></td>
			<td><b>MATRÍCULA:</b> <?php echo $this->dados['matricula'];?></td>
		</tr>
		<tr>
			<td><b>FUNÇÃO:</b> <?php echo utf8_encode($this->dados['funcao']);?></td>
			<td><b>SETOR:</b> <?php echo utf8_encode($this->dados['setor']);?></td>
			<td><b>GESTOR:</b> <?php echo $this->dados['gestor'];?></td>
		</tr>
		<tr><td colspan="3">&ensp;</td></tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>NOTAS</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA ATENDE </b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>A PARTIR 8,5</b></td>
		</tr>
		<tr>
			<td><b>NÍVEL DE COMPETÊNCIA A SER DESENVOLVIDA</b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>ENTRE 8,4 - 0,0</b></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMPETÊNCIAS A SEREM AVALIADAS</b></td>
		</tr>
		<tr>
			<td colspan="3"><b>COMPORTAMENTAL</b></td>
		</tr>
		<?php
		$total = 0;
		for( $j=0; $j < count($this->avaliacao); $j++ ){
			echo '<tr>';
				echo '<td>'.$this->avaliacao[$j]['titulo'].'</td>';
				echo '<td colspan="2">'.number_format($this->avaliacao[$j]['media'], 2, '.', '').'</td>';
			echo '</tr>';
			$total = $total + $this->avaliacao[$j]['media'];
		}
		?>
		
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total/count($this->avaliacao), 2, '.', '');?></td>
		</tr>
		<tr>
			<td colspan="3"><b>TÉCNICA</b></td>
		</tr>

		<?php
		$valores = explode("/", $this->avl);
		//echo count($valores);
		$total_tecnica = 0;
		$cconexao = $this->conectar();
		for( $j=0; $j < count($valores); $j++ ){
			$script = "SELECT * FROM resposta AS resp INNER JOIN pergunta AS pg ON resp.idpergunta = pg.idpergunta WHERE resp.idpergunta='".$valores[$j]."' AND avaliador='".$this->gst."' AND avaliado='".$this->id."'";
			$temp = $cconexao->query( $script );
			if( $temp ){

				$datas = $temp->fetch(PDO::FETCH_ASSOC);
				echo '<tr>';
					echo '<td>'.$datas['contexto'].'</td>';
					echo '<td colspan="2">'.$datas['nota'].'</td>';
				echo '</tr>';
				$total_tecnica = $total_tecnica + $datas['nota'];

			}else {
				echo '<tr>';
					echo '<td colspan="3">NOT</td>';
				echo '</tr>';
			}
			
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total_tecnica/count($valores), 2, '.', '');?></td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="#ccc" align="center"><b>COMENTÁRIOS</b></td>
		</tr>
		<tr><td colspan="3"><p><?php echo ucfirst($this->dados['comentario']);?></p></td></tr>
	</table>
</div>