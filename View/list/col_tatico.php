<div class="container">
<br><br>
  <div class="row">
  <div class="escolha">
    <nav class="col-sm-3" id="myScrollspy">
      <ul class="nav nav-pills nav-stacked">
      <?php
      while( $ftch = $setor->fetch(PDO::FETCH_ASSOC) ){
        ?>
        <li class="select"><a href="#<?= str_replace(" ","_", utf8_encode($ftch['setor']));?>"><?php echo utf8_encode($ftch['setor']);?></a></li>
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
      $qr = $cconexao->query("SELECT * FROM funcionario WHERE (nivelavaliador='$s1' OR nivelavaliador='$s2') AND setor='".$fch['setor']."' ORDER BY nome ASC");
      $setor = str_replace(" ", "_", $fch['setor']);
      echo '<div id="'.utf8_encode($setor).'" data-style="section">';
      echo '<h2>'.utf8_encode($fch['setor']).'</h2>';
        echo '<br><table class="table table-hover">';
        while( $dados = $qr->fetch(PDO::FETCH_ASSOC) ){
          $gestor = $dados['imediato'];
          $superior = $dados['superior'];
          echo '<tr>';
          echo '<td>'.$dados['nome'].'</td>';
          echo '<td width="20%">';
          echo '<a href="?window=reportTatico&id='.base64_encode($dados['matricula']).'&gestor='.base64_encode($dados['imediato']).'" class="link">Relatório</a>';
          echo '</td>';
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
