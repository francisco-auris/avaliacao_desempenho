<div class="container">
    <div class="col-md-6 col-md-offset-3">
    <br>
        <form method="post" action="?window=pacote&action=update&id=<?= $_GET['id'];?>">
        <label>Titulo:</label>
        <input type="text" name="titulo" class="form-control" value="<?= $this->_dados['titulo'];?>" disabled>
        
        <label>Adicione os ID's das competencias separados por '/'</label>
        <input type="text" maxlength="200" name="competencias" class="form-control"value="<?= $this->_dados['competencias'];?>" placeholder="digite os ids" required>
        <label>Tipo do pacote:</label>
        <Select name="tipo" class="form-control">
        <?php echo '<option value="'.$this->_dados['tipo'].'" style="color:red !important;">'.$this->_dados['ntipo'].'</option>';?>
                <option value="O">O - Operacional</option>
                <option value="O">T - Tatico</option>
                <option value="O">E - Estrategico</option>
                <option value="O">0 - Nenhum</option>
        </select>
        <label>Voltado:</label>
        <select name="msearch" class="form-control" required>
        <?php 
                echo '<option value="'.$this->_dados['msearch'].'" style="color:red !important;">'.$this->_dados['msearch'].'</option>';
                
                for( $j=0; $j < count($this->_dados['funcoes']); $j++ ){
                    echo '<option value="'.$this->_dados['funcoes'][$j].'">'.$this->_dados['funcoes'][$j].'</option>';
                }
        ?>
        </select>
        <br>
        <input type="submit" class="btn btn-primary" value="Atualizar">
        </form>
    </div>
</div>