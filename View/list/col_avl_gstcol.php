<div class="container">
<br><br><br>
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
    <div class="page-header" style="margin-top: -15px;">
      <h1>GESTOR AVALIA COLABORADOR</h1>
    </div>
    <?php
    while( $fch = $setores->fetch(PDO::FETCH_ASSOC) ){
      //echo "SELECT * FROM funcionario WHERE nivelavaliador='Operacional' AND setor='".$fch['setor']."' ORDER BY nome ASC<br>";
      $qr = $cconexao->query("SELECT * FROM funcionario WHERE setor='".$fch['setor']."' AND nivelavaliador='$s2' ORDER BY nome ASC");
      $setor = str_replace(" ", "_", utf8_encode($fch['setor']));
      echo '<div id="'.$setor.'" data-style="section">';
      echo '<h2>'.utf8_encode($fch['setor']).'</h2>';
        echo '<br><table class="table table-hover">';
        while( $dados = $qr->fetch(PDO::FETCH_ASSOC) ){
          $gestor = $dados['matricula'];
          $superior = $dados['superior'];
          echo '<tr>';
          echo '<td>'.$dados['nome'].'/'.$dados['matricula'].'</td>';

          if( $superior=="" ){
            $newGestor = str_replace("/", ",", $gestor);
          }
          else {
            $newGestor = str_replace("/", ",", $gestor).",".$superior;
          }
          //$queryG = $cconexao->query("SELECT * FROM funcionario WHERE imediato IN($gestor)");
          $queryG = $cconexao->query("SELECT * FROM funcionario WHERE imediato LIKE '%$gestor%'");
          echo '<td width="45%">';
          while( $gst = $queryG->fetch(PDO::FETCH_ASSOC) ){
            $nome = $gst['nome'];
            echo '<a href="?window=gestorAvlCol&gestor='.base64_encode($dados['matricula']).'&id='.base64_encode($gst['matricula']).'">'.$nome.'</a> /<br> ';
          }
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
