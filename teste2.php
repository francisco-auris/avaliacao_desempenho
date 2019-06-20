<?php
//conexao com o sql
$host = "192.168.16.210\Prod";
$user = "usr_general";
$pass = "General@321";
$banco = "humanus-prod";
$conexao = mssql_connect($host, $user, $pass) or die(mssql_get_last_message());
    mssql_select_db($banco, $conexao) or die (mssql_get_last_message());

    $version = mssql_query("SELECT
	E.EMPCODEMPRESA		AS	'COD EMPRESA',
	B.FILNROFILIAL		AS	'FILIAL',
	A.MTENROMATREXTERNO	AS	'MATRICULA',
	A.MTENOMEEXTENSO	AS	'NOME',
	J.DENOMINACAO		AS	'CARGO',
	C.PFIDATANASCIM		AS	'DT NASCIMENTO',
	DAY(C.PFIDATANASCIM)	AS	'DIA',
	MONTH(C.PFIDATANASCIM)	AS	'MES'

FROM
	[humanus-prod].[dbo].[MATRICULA_EXTERNA] AS A
	INNER JOIN [humanus-prod].[dbo].[FILIAL] AS B ON A.MTECODEMPRESA = FILCODEMPRESA
	INNER JOIN [humanus-prod].[dbo].[PESSOA_FISICA] AS C ON A.MTECODPESSOA = C.PFICODPESSOA
	INNER JOIN [humanus-prod].[dbo].[PESSOA_PESS] AS D ON A.MTECODPESSOA = D.PESCODPESSOA
	INNER JOIN [humanus-prod].[dbo].[EMPRESA] AS E ON B.FILCODEMPRESA = E.EMPCODEMPRESA
	INNER JOIN [humanus-prod].[dbo].[PESSOA_FUNC] AS F ON C.PFICODPESSOA = F.PFUCODPESSOA
	INNER JOIN [humanus-prod].[dbo].[EMPRESA_DESCRITOR] AS G ON E.EMPCODEMPRESA = DCRCODEMPRESA
	INNER JOIN [humanus-prod].[dbo].[LOTACAO] AS H ON F.PFUCODLOTACAO = H.LOTCODLOTACAO
	INNER JOIN [humanus-prod].[dbo].[PESSOA_FIS_FUNC] AS I ON PFFCODPESSOA = A.MTECODPESSOA
	INNER JOIN [humanus-prod].[dbo].[CES_CARGO] AS J ON I.PFFCODCARGO = J.CODCARGO
WHERE
	A.MTEULTSITUACAO = '1' AND B.FILNROFILIAL != 2") or die('error');
    //$row = mssql_fetch_array($version);

    //echo $row[1];
    while( $dados = mssql_fetch_assoc($version) ){
      echo $dados['COD EMPRESA']." - ".$dados['MATRICULA']."<br>";
    }

// Limpieza
mssql_free_result($version);

?>