	<div class="col-md-4">
		<ul class="list-group">
		  <li class="list-group-item active"><center><b>Auto Avaliação</b></center></li>
		  <?php
		  if( $_comp->rowCount() > 0 ){
		  		echo '<li class="list-group-item list-group-item-success"><center>AUTO AVALIAÇÃO CONCLUÍDA</center></li>';
		  }
		  else {
		  		echo '<li class="list-group-item"><center><a href="?window=auto&id='.base64_encode($_SESSION['LOGIN_RH']).'" class="btn btn-primary btn-xs">INICIAR AUTO AVALIAÇÃO</a></center></li>';
		  	}
		  ?>
		</ul>
	</div>