
	<div class="col-md-4">
		<ul class="list-group">
		  <li class="list-group-item active"><center><b>Avalie sua equipe</b></center></li>
		  <?php
		  while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
		  $tipo = $ftch['nivelavaliador'];
		  $funcao = $ftch['funcao'];
		  $func = $ftch['matricula'];
		  $eu = $_SESSION['LOGIN_RH'];
		  	if( $tipo == "Tatico" OR $tipo == "Estrategico"){

		  		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
		  		$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");
		  			$vefTecnica = $cconexao->query("SELECT * FROM pacote WHERE msearch='$funcao'");

		  		//if( $vefTecnica AND $vefTecnica->rowCount() > 0 ){
		  			if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
		  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
			  		}
			  		else {
			  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
			  		}
		  		/*}
		  		else {
		  			if( $_comp->rowCount() > 0 ){
		  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
			  		}
			  		else {
			  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
			  		}
		  		}*/
		  		
		  			
		  	}
		  	if( $tipo == "Operacional" ){
		  		$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
		  		$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");
		  		 if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
		  			echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
		  		 }
		  		 else {
		  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
		  		 }
		  	}
		  	
		  }
		  ?>
		</ul>
	</div>