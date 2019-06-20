<div class="container">
<br><br>
<table class="table table-hover" >
<thead>
	<tr>
		<td><b>ID</b></td>
		<td><b>NOME</b></td>
		<td><b>MATRICULA</b></td>
		<td><b>SETOR</b></td>
		<td><b>FUNCAO</b></td>
		<td><b>NIVEL</b></td>
		<td><b>IMEDIATO</b></td>
		<td><b>SUPERIOR</b></td>
		<td colspan="2"></td>
	</tr>
</thead>
<?php
while( $dados = $query->fetch(PDO::FETCH_ASSOC) ){
	echo '<tr>';
	echo '<td>'.$dados['idfuncionario'].'</td>';
	echo '<td>'.utf8_encode($dados['nome']).'</td>';
	echo '<td>'.$dados['matricula'].'</td>';
	echo '<td>'.utf8_encode($dados['setor']).'</td>';
	echo '<td>'.utf8_encode($dados['funcao']).'</td>';
	echo '<td>'.utf8_encode($dados['nivelavaliador']).'</td>';
	echo '<td>'.$dados['imediato'].'</td>';
	echo '<td>'.$dados['superior'].'</td>';	
	echo '<td><a onclick=messagePreUrl("Funcionario","?window=funcionario&action=delete&id='.base64_encode($dados['matricula']).'");><i class="glyphicon glyphicon-trash"></i></a></td>';
	echo '<td><a href="?window=funcionario&comp=update&id='.base64_encode($dados['matricula']).'"><i class="glyphicon glyphicon-refresh"></i></a></td>';
	echo '</tr>';
}
?>
</table>
</div>