<div class="container">
<br>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Titulo</th>
        <th>Perguntas</th>
        <th width="5%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
    echo '<tr>';
      echo '<td>'.$ftch['idcompetencia'].'</td>';
      echo '<td>'.$ftch['tipo'].'</td>';
      echo '<td>'.$ftch['titulo'].'</td>';
      echo '<td>'.$ftch['cpergunta'].'</td>';
      echo '<td><a href="?window=competencia&comp=update&id='.base64_encode($ftch['idcompetencia']).'" class="btn btn-info btn-xs">atualizar</a></td>';
      echo '<td><a href="?window=competencia&action=delete&id='.base64_encode($ftch['idcompetencia']).'" class="btn btn-danger btn-xs">excluir</a></td>';
    echo '</tr>';
    }
    ?>
      <!--<tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>-->
    </tbody>
  </table>
</div>