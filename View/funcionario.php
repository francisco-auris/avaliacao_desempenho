<div class="container">
<br><br><br>
  <h2 class="display-3">Gerenciamento de Funcionários</h2>
  <?php if(empty($_GET['comp'])){ ?><button class="btn btn-primary" data-toggle="modal" data-target="#modalComp">Adicionar novo funcionario</button><?php }?>
</div>
<!-- Modal -->
<?php if(empty($_GET['comp'])){ ?>
<div id="modalComp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cadastrar funcionario</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="?window=funcionario&action=insert">
        <label>Nome:</label><input type="text" name="nome" class="form-control" placeholder="Nome" required>
        <label>Matricula:</label><input type="number" name="matricula" class="form-control" min="0" required>
        <label>Setor:</label><input type="text" name="setor" class="form-control" required>
        <label>Função:</label><input type="text" name="funcao" class="form-control" required>
        <label>Nivel</label>
        <select name="nivel" class="form-control" required>
          <option value="Operacional">Operacional</option>
          <option value="Tatico">Tatico</option>
          <option value="Estrategico">Estrategico</option>
        </select>
        <label>Horário:</label><input type="text" name="horario" class="form-control" required>
        <div class="row">
          <div class="col-sm-4">
          <label>Admissão:</label><input type="date" name="admissao" class="form-control">
          </div>
          <div class="col-sm-4">
          <label>Nascimento:</label><input type="date" name="nascimento" class="form-control">
          </div>
          <div class="col-sm-4">
          <label>Empresa:</label>
          <select name="empresa" class="form-control" required>
            <option value="COBAP COMERCIO E BENEFICIAMENTO DE ARTEFATOS DE PAPEL LTDA">COBAP COMERCIO E BENEFICIAMENTO DE ARTEFATOS DE PAPEL LTDA</option>
            <option value="PACEL PAPEL CARTAO E EMBALAGEM LTDA">PACEL PAPEL CARTAO E EMBALAGEM LTDA</option>
            <option value="pacel">PACEL</option>
          </select>
          </div>
          <div class="col-sm-6">
          <label>Imediato:</label><input type="text" name="imediato" class="form-control" min="0">
          </div>
          <div class="col-sm-6">
          <label>Superior:</label><input type="number" name="superior" class="form-control" min="0">
          </div>
        </div>
        <br>
        <input type="submit" class="btn btn-primary" value="Salvar">
        </form>
      </div>
    </div>

  </div>

</div>
  <?php } ?>