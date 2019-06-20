<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>RH</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" media="print" href="print.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="central.js"></script>
    <script type="text/javascript" src="atividade.js"></script>
    
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!--<a class="navbar-brand" href="."><img src="images/min.png" style="margin-top:-15px;"></a>-->
        <a class="navbar-brand" href="?window=home"><?php echo $_SESSION['NOME_RH'];?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php
        if( CRestricted::vef($_SESSION['LOGIN_RH']) == 'yes' ){
        ?>
        <ul class="nav navbar-nav">
            <li><a href="?window=funcionario">Funcionarios</a></li>
            <li><a href="?window=pacote">Pacotes</a></li>
            <li><a href="?window=pergunta">Perguntas</a></li>
            <li><a href="?window=competencia">Competencias</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?window=colAvlGestor">Espelho Colaborador avalia gestor</a></li>
                <li><a href="?window=gestorAvlCol">Espelho Gestor avalia colaborador</a></li>
                <li><a href="?window=autoAvaliacao">Espelho Auto avaliação</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="?window=colOperacional">Relatório Resumo Operacional  </a></li>               
                <li><a href="?window=reportGestor">Relatório Resumo Estratégico</a></li>
                <li><a href="?window=reportTatico">Relatório Resumo Tático</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="?window=setorGestor">Relatório de Avaliação do Gestor Por Competencias e Setor</a></li>
                <li><a href="?window=geralEmpresa">Relatório Geral Da Empresa</a></li>
                <li><a href="?window=estrategico">Relatório Geral Média do Gestor</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="?window=setorGeral">Relatório Geral por Setor</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="?window=extra">Média Geral de Todos Colaboradores</a></li>
              </ul>
            </li>
            <li><a href="?window=atividade">Atividade</a></li>
        </ul>
        <?php
        }
        ?>
        <ul class="nav navbar-nav navbar-right">
            <li><a id="fontMenor" class="fontChange" onclick="fontMenor();">A -</a></li>
            <li><a id="fontMaior" class="fontChange" onclick="fontMaior();"><b>A +</b></a><input type="number" min="0" hidden name="font"></li>
            <li><a href="?action=logout">Sair</a></li>
        </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
    </nav>