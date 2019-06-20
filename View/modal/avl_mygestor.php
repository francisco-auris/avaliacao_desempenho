
	<div class="col-md-4">
		<ul class="list-group">
		  <li class="list-group-item active"><center><b>Avalie Seu Gestor</b></center></li>
		  <?php
		  while( $ftch = $query->fetch(PDO::FETCH_ASSOC) ){
		  $tipo = $ftch['nivelavaliador'];
		  $func = $ftch['matricula'];
		  $funcao = $ftch['funcao'];
		  $eu = $_SESSION['LOGIN_RH'];

		  if( $eu == '455' and $func == '90000' ){ //REGRA PARA GUTEMBERG NÃO AVALIAR RENATA
			//acontece nada
		  }
		  else {

		  	$_funcao = $cconexao->query("SELECT * FROM pacote WHERE msearch='$funcao'");
		  	$_comp = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='C'");
		  	$_tecn = $cconexao->query("SELECT resp.*, comp.tipo FROM resposta as resp inner join competencia comp on resp.competencia = comp.idcompetencia WHERE resp.avaliador='$eu' AND resp.avaliado='$func' AND comp.tipo='T'");

		  		if( $_SESSION['NIVEL_RH']=="Operacional" || $_SESSION['NIVEL_RH']=="Tatico" ){
		  			if( $_comp->rowCount() > 0 ){
		  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
		  			}
		  			else {
		  				echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
		  			}
		  		}
	
		  		else {
		  			/*if( $ftch['nivelavaliador']!="Estratégico" ){
		  				if( $_comp->rowCount() > 0 ){
			  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
				  		}
				  		else {
				  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
				  		}
		  			}
		  			else {*/
			  			/*if( $_funcao->rowCount() > 0 ){
			  				if( $_comp->rowCount() > 0 AND $_tecn->rowCount() > 0 ){
				  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
					  		}
					  		else {
					  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
					  		}
			  			}
			  			else {*/
				  			if( $_comp->rowCount() > 0 ){
				  				echo '<li class="list-group-item list-group-item-success"> '.$ftch['nome'].'</li>';
					  		}
					  		else {
					  			echo '<li class="list-group-item"><a href="?window=avaliacao&id='.base64_encode($ftch['matricula']).'" class="btn btn-primary btn-xs">AVALIAR</a> '.$ftch['nome'].'</li>';
					  		}
					  	//}
					//}
		  		}

		  }

		} //FIM DE REGRA
		  ?>
		</ul>
	</div>