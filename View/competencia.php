<div class="container">
<br><br><br>
  <h2 class="display-3">Gerenciamento de Competencias</h2>
  <?php
  if( empty($_GET['comp']) ){
    ?>
  <button class="btn btn-primary" data-toggle="modal" data-target="#modalComp">Adicionar competencia</button>
  <?php
  }
  ?>
</div>
<!-- Modal -->
<div id="modalComp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cadastrar competencia</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="?window=competencia&action=insert">
        <label>Titulo da Competencia</label>
        <input type="text" maxlength="200" name="titulo" class="form-control" placeholder="digite o titulo" required>
        <label>Adicione os ID's das perguntas separados por '/'</label>
        <input type="text" maxlength="200" name="perguntas" class="form-control" placeholder="digite os ids" required>
        <label>Tipo de competencia:</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="T" required>T - Técnico</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="C" required>C - Comportamental</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="A" required>A - Auto</label>
        <br>
        <input type="submit" class="btn btn-primary" value="Salvar">
        </form>
      </div>
    </div>

  </div>
</div>