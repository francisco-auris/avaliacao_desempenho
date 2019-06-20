<div class="container">
<br><br><br>
  <h2 class="display-3">Gerenciamento de Perguntas</h2>
  <?php if( empty($_GET['id']) ){?><button class="btn btn-primary" data-toggle="modal" data-target="#modalPergunta">Adicionar pergunta</button><?php }?>
</div>
<!-- Modal -->
<?php
if( empty($_GET['id']) ){
?>
<div id="modalPergunta" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cadastrar pergunta</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="?window=pergunta&action=insert" name="cadPergunta">
        <label>Digite o texto da pergunta:</label>
        <textarea class="form-control" placeholder="Digite o texto da pergunta..." name="pergunta" required></textarea>
        <br>
        <input type="submit" class="btn btn-primary" value="Salvar">
        </form>
      </div>
    </div>

  </div>
</div>
<?php
}
?>