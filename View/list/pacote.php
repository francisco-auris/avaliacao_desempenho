<div class="container">
<br>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Tipo</th>
        <th>Voltado</th>
        <th>Competencias(ID)</th>
        <th width="5%"></th>
      </tr>
    </thead>
    <tbody>
    <?php
    while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
    echo '<tr>';
      echo '<td>'.$ftch['idpacote'].'</td>';
      echo '<td>'.$ftch['titulo'].'</td>';
      echo '<td>'.$ftch['tipo'].'</td>';
      echo '<td>'.utf8_encode($ftch['msearch']).'</td>';
      echo '<td>'.$ftch['pcompetencia'].'</td>';
      echo '<td><a href="?window=pacote&comp=update&id='.base64_encode($ftch['idpacote']).'" class="btn btn-info btn-xs">atualizar</a></td>';
      echo '<td><button onclick=messagePreUrl("pacote","?window=pacote&action=delete&id='.base64_encode($ftch['idpacote']).'"); class="btn btn-danger btn-xs">excluir</button></td>';
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