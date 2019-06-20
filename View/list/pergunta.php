<div class="container">
<br>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Contexto</th>
        <th width="5%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
    echo '<tr>';
      echo '<td>'.$ftch['idpergunta'].'</td>';
      echo '<td>'.$ftch['contexto'].'</td>';
      echo '<td><a href="?window=pergunta&id='.base64_encode($ftch['idpergunta']).'" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-refresh"></i> atualizar</a></td>';
      echo '<td><button onclick=messagePreUrl("pergunta","?window=pergunta&action=delete&id='.base64_encode($ftch['idpergunta']).'"); class="btn btn-danger btn-xs">excluir</a></td>';
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