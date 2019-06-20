<div class="container">
<br><br><br>
	<table class="table" border="1">
		<thead>
			<tr>
				<td align="center" colspan="4">
					<img src="images/cobap_rh.png" width="120" style="float: left;margin-right: -100px;">
					 <div class="page-header" style="border: 0 !important;margin-bottom:-20px !important;margin-top: -3px;">
				      <h3>MÉDIA GERAL DA EMPRESA</h3>
				    </div>
				</td>
			</tr>
		</thead>
		<tr>
			<td colspan="3"><b>EMPRESA:</b> COBAP COMERCIO E BENEFICIAMENTO DE ARTEFATOS DE PAPEL LTDA</td>
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
			<td width="40%"><b>NÍVEL DE COMPETÊNCIA A SER DESENVOLVIDA</b></td>
			<td align="center"><b>NOTA</b></td>
			<td><b>ENTRE 8,4 - 0,0</b></td>
		</tr>
		<tr>
			<td colspan="3" class="gray" align="center"><b>COMPETÊNCIAS A SEREM AVALIADAS</b></td>
		</tr>
		<?php
		$total = 0;
		while( $dt = $query->fetch(PDO::FETCH_ASSOC) ){
			$titulo = explode(":", $dt['titulo']);
			echo '<tr>';
			echo '<td colspan="2"><b>'.$titulo[0].'</b></td>';
			echo '<td>'.number_format($dt['media'], 2, '.', '').'</td>';
			echo '</tr>';
			$total += $dt['media'];
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>NOTA GERAL: </b><?php echo number_format($total/$query->rowCount(), 2, '.', '');?></td>
		</tr>
	</table>
</div>