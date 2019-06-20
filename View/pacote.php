<div class="container">
<br><br><br>
  <h2 class="display-3">Gerenciamento de Pacotes</h2>
  <?php
  if( empty($_GET['comp']) ){
    echo '<button class="btn btn-primary" data-toggle="modal" data-target="#modalPacote">Adicionar pacote</button>';
  }
  ?>
  
</div>
<!-- Modal -->
<div id="modalPacote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cadastrar pacote</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="?window=pacote&action=insert">
        <label>Titulo:</label>
        <input type="text" name="titulo" class="form-control" value="<?php echo strtoupper(base64_encode(date('d-His')));?>">
        
        <label>Adicione os ID's das competencias separados por '/'</label>
        <input type="text" maxlength="200" name="competencias" class="form-control" placeholder="digite os ids" required>
        <label>Tipo do pacote:</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="O" required>O - Operacional</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="T" required>T - Tatico</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="E" required>E - Estrategico</label>
        <label class="radio-inline"><input type="radio" name="tipo" value="0" required>0 - Nenhum</label>
        <br>
        <label>Voltado:</label>
        <input type="text" name="msearch" class="form-control" required>
        <br>
        <input type="submit" class="btn btn-primary" value="Salvar">
        </form>
      </div>
    </div>

  </div>
</div>