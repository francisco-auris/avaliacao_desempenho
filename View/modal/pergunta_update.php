<div class="col-md-6 col-md-offset-3">
<br><br>
<form method="post" action="?window=pergunta&id=<?= $_GET['id'];?>&action=update">
	<input type="text" class="form-control" name="contexto" value="<?= $this->dadosP['contexto'];?>">
	<br>
	<input type="submit" class="btn btn-primary" value="Atualizar">
</form>
</div>