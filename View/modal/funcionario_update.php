<div class="container">

<form method="post" action="?window=funcionario&comp=update&id=<?= $_GET['id']?>&action=update">
        <label>Nome:</label><input type="text" name="nome" class="form-control" placeholder="Nome" required value="<?= $fetch['nome'];?>">
        <label>Matricula:</label><input type="number" name="matricula" class="form-control" min="0" required value="<?= $fetch['matricula'];?>">
        <label>Setor:</label><input type="text" name="setor" class="form-control" required value="<?= $fetch['setor'];?>">
        <label>Função:</label><input type="text" name="funcao" class="form-control" required value="<?= $fetch['funcao'];?>">
        <label>Nivel</label>
        <select name="nivel" class="form-control" required>
          <option value="<?= $fetch['nivelavaliador'];?>"><?php echo $fetch['nivelavaliador'];?></option>
          <option value="Operacional">Operacional</option>
          <option value="Tatico">Tatico</option>
          <option value="Estrategico">Estrategico</option>
        </select>
        <label>Horário:</label><input type="text" name="horario" class="form-control" required value="<?= $fetch['horario'];?>">
        <div class="row">
          <div class="col-sm-4">
          <label>Admissão:</label><input type="date" name="admissao" class="form-control" value="<?= $fetch['admissao'];?>">
          </div>
          <div class="col-sm-4">
          <label>Nascimento:</label><input type="date" name="nascimento" class="form-control" value="<?= $fetch['nascimento'];?>">
          </div>
          <div class="col-sm-4">
          <label>Empresa:</label>
          <select name="empresa" class="form-control" required>
            <option value="<?= $fetch['empresa'];?>"><?php echo $fetch['empresa'];?></option>
            <option value="COBAP COMERCIO E BENEFICIAMENTO DE ARTEFATOS DE PAPEL LTDA">COBAP COMERCIO E BENEFICIAMENTO DE ARTEFATOS DE PAPEL LTDA</option>
            <option value="PACEL PAPEL CARTAO E EMBALAGEM LTDA">PACEL PAPEL CARTAO E EMBALAGEM LTDA</option>
          </select>
          </div>
          <div class="col-sm-6">
          <label>Imediato:</label><input type="text" name="imediato" class="form-control" min="0" value="<?= $fetch['imediato'];?>">
          </div>
          <div class="col-sm-6">
          <label>Superior:</label><input type="number" name="superior" class="form-control" min="0" value="<?= $fetch['superior'];?>">
          </div>
        </div>
        <br>
        <input type="submit" class="btn btn-primary" value="Atualizar">
        <br><br><br>
        </form>
</div>