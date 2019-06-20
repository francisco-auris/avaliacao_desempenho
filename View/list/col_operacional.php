<div class="container">
  <div class="row">
  <div class="escolha">
    <nav class="col-sm-3" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked">
      <?php
      while( $ftch = $setor->fetch(PDO::FETCH_ASSOC) ){
        ?>
        <li class="select"><a href="#<?= str_replace(" ","_", $ftch['setor']);?>"><?php echo utf8_encode($ftch['setor']);?></a></li>
        <?php
      }
      ?>
      </ul>
    </nav>
  </div>
    <div class="col-sm-9">
    <?php
    while( $fch = $setores->fetch(PDO::FETCH_ASSOC) ){
      //echo "SELECT * FROM funcionario WHERE nivelavaliador='Operacional' AND setor='".$fch['setor']."' ORDER BY nome ASC<br>";
      $qr = $cconexao->query("SELECT * FROM funcionario WHERE nivelavaliador='Operacional' AND setor='".$fch['setor']."' ORDER BY nome ASC");
      $setor = str_replace(" ", "_", $fch['setor']);
      echo '<div id="'.$setor.'" data-style="section">';
      echo '<h2>'.utf8_encode($fch['setor']).'</h2>';
        echo '<br><table class="table table-hover">';
        while( $dados = $qr->fetch(PDO::FETCH_ASSOC) ){
          echo '<tr>';
            echo '<td>'.utf8_encode($dados['nome']).'/'.$dados['matricula'].'</td>';
            //$_gestores = explode("/", $dados['imediato']);
            $_gestores = str_replace("/", ",", $dados['imediato']);
            echo '<td>';

            echo '<a href="?window=colOperacional&id='.base64_encode($dados['matricula']).'&gestor='.base64_encode($_gestores).'" class="link">Gestores</a> /<br>';

            /*for( $j=0; $j < count($_gestores); $j++ ){
              $_temp = $cconexao->query("SELECT nome,matricula FROM funcionario WHERE matricula='".$_gestores[$j]."'");
              $fetchADO = $_temp->fetch(PDO::FETCH_ASSOC);
              echo '<a href="?window=colOperacional&id='.base64_encode($dados['matricula']).'&gestor='.base64_encode($fetchADO['matricula']).'" class="link">'.$fetchADO['nome'].'</a> /<br>';
            }*/

            echo '</td>';
           // echo '<td width="5%"><a href="?window=colOperacional&id='.base64_encode($dados['matricula']).'" class="link">Relatório</a></td>';
          echo '</tr>';
        }
       echo '</table>';
      echo '</div>';
    }
    ?>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  // Add scrollspy to <body>
  $('body').scrollspy({target: ".nav", offset: 60});

  // Add smooth scrolling on all links inside the navbar
  $("#myScrollspy a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 500, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
        $(hash).css("border-left","solid 2px #337ab7");
      });
    }  // End if
  });
});
</script>
