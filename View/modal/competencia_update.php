<div class="col-md-6 col-md-offset-3">
<br><br>
<form method="post" action="?window=competencia&action=update&id=<?= $_GET['id'];?>">
	<textarea name="titulo" class="form-control"><?php echo $this->_dados['titulo'];?></textarea>
	<!--<input type="text" class="form-control" name="titulo" value="<?= $this->_dados['titulo'];?>">-->
	<br>
	<input type="text" class="form-control" name="perguntas" value="<?= $this->_dados['perguntas'];?>">
	<br>
	<input type="submit" class="btn btn-primary" value="Atualizar">
</form>
</div>