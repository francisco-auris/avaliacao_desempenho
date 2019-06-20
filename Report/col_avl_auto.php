<div class="container">
<br><br><br>
	<table class="table" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					 <div class="page-header" style="border: 0 !important;margin-bottom:-20px !important;margin-top: -3px;">
				      <h3>AVALIAÇÃO DE DESEMPENHO <br><small>AUTO AVALIAÇÃO</small></h3>
				    </div>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="3"><b>NOME:</b> <?php echo $this->dados['nome'];?></td>
		</tr>
		<tr>
			<td><b>FUNÇÃO:</b> <?php echo utf8_encode($this->dados['funcao']);?></td>
			<td><b>SETOR:</b> <?php echo utf8_encode($this->dados['setor']);?></td>
			<td><b>MATRICULA:</b> <?php echo $this->dados['matricula'];?></td>
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
		<?php
		$total = 0;
		for( $j=0; $j < count($this->avaliacao); $j++ ){
			echo '<tr>';
				echo '<td><b>'.$this->avaliacao[$j]['titulo'].'</b></td>';
				echo '<td colspan="2">'.number_format($this->avaliacao[$j]['media'], 2, '.', '').'</td>';
			echo '</tr>';
			$total = $total + $this->avaliacao[$j]['media'];
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total/count($this->avaliacao), 2, '.', '');?></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMENTÁRIOS</b></td>
		</tr>
		<tr><td colspan="3"><p><?php echo ucfirst($this->dados['comentario']);?></p></td></tr>
	</table>
</div>