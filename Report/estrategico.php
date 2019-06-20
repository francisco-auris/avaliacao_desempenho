<div class="container">
<br><br><br>
<table class="table table-hover" border="1">
	<thead class="gray">
		<td width="60%"><b>NOME</b></td>
		<td width="10%" align="center"><b>COMPORTAMENTAL</b></td>
		<td width="10%" align="center"><b>TÉCNICA</b></td>
	</thead>
	<?php
	//echo '<h1>'.$indice.'</h1>';
	for( $j=0; $j < count($this->dados); $j++ ){
		echo '<tr>';
		echo '<td>'.$this->dados[$j]['nome'].'</td>';
		echo '<td align="center">'.$this->dados[$j]['comp'].'</td>';
		echo '<td align="center">'.$this->dados[$j]['tecn'].'</td>';
		echo '</tr>';
	}
	?>
</table>
</div>