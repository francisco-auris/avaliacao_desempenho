<?php
class CMessage {

    public static function alerta( $text ){
        echo '<div class="col-md-4 col-md-offset-4"><div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-info-sign"></i> '.$text.'</div></div>';
    }
    public static function sucesso( $text ){
        echo '<div class="col-md-4 col-md-offset-4"><div class="alert alert-success" role="alert"><i class="glyphicon glyphicon-ok-sign"></i> '.$text.'</div></div>';
    }
    public static function danger( $text ){
        echo '<div class="col-md-4 col-md-offset-4"><div class="alert alert-danger" role="alert"><i class="glyphicon glyphicon-remove-sign"></i> '.$text.'</div></div>';
    }

    public static function centralError( $text ){
    	echo '<div class="flat">
			  <div class="message">
			  	<center><br><h3>'.$text.'</h3>
			  		<i class="glyphicon glyphicon-remove-circle" style="color:#e74c3c;"></i>
			  	</center>
			  </div>
			  </div>';
    }
    public static function centralSucesso( $text ){
    	echo '<div class="flat">
			  <div class="message">
			  	<center><br><h3>'.$text.'</h3>
			  		<i class="glyphicon glyphicon-ok-circle" style="color:#20674B;"></i>
			  	</center>
			  </div>
			  </div>';
    }
    public static function fixed( $texto,$type ){
    	echo '<div class="alert alert-'.$type.' mensagem-fixa" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="glyphicon glyphicon-remove-sign"></i> '.$texto.'</div>';
    }
    public static function centralNext( $text ){
    	echo '<div class="flat">';
		echo '	  <div class="message">';
		echo '	  	<center><br><h3>'.$text.'</h3>';
		echo '	  		<a href="?window=avaliacaoc&id='.$_GET['id'].'"><i class="glyphicon glyphicon-circle-arrow-right" style="color:#3498db;"></i><br>Fazer avaliacao Técnica</a>';
		echo '	  	</center>';
		echo '	  </div>';
		echo '	  </div>';
    }
    
}
?>