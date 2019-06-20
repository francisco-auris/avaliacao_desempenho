<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RH - login</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">
    <div class="col-md-6 col-md-offset-3">
    <br><br><br><br>
    <center><img src="images/cobap_rh.png" width="320"></center>
    <form class="form-horizontal" method="post" action="?action=login">
        <div class="form-group">
            <label class="control-label col-sm-4" for="email">Matricula:</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" name="login" id="email" placeholder="Digite sua matricula">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="pwd">Data de Nascimento:</label>
            <div class="col-sm-6"> 
            <input type="date" class="form-control" name="senha" id="pwd" placeholder="Data de nascimento">
            </div>
        </div>
        <div class="form-group"> 
            <div class="col-sm-offset-4 col-sm-10">
            <button type="submit" class="btn btn-default">Entrar</button>
            </div>
        </div>
    </form>
    </div>
    </div>
    <!--<footer class="footer navbar-fixed-bottom">
    <div class="container">
        <p class="text-muted"><i class="glyphicon glyphicon-asterisk" style="color:#1D5A40;"></i> Acesse os resultados<a href="#"> aqui.</a></p>
      </div>
    </footer>-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>