<?php
/*try {

    $con = new PDO("dblib:host=192.168.16.210\PROD;dbname=SBO_COBAP_PRODUCAO", "usr_general", "General@123");

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

} catch (PDOException $e) {
    die ("Erro na conexao com o banco de dados: ".$e->getMessage());
}*/
?>
<?php
//conexao com o sql
$host = "192.168.16.210\Prod";
$user = "usr_general";
$pass = "General@321";
$banco = "SBO_COBAP_PRODUCAO";
$conexao = mssql_connect($host, $user, $pass) or die(mssql_get_last_message());
    mssql_select_db($banco, $conexao) or die (mssql_get_last_message());

    $version = mssql_query("SELECT TOP 1000 [Code]
      ,[Name]
      ,[DocEntry]
      ,[Canceled]
      ,[Object]
      ,[LogInst]
      ,[UserSign]
      ,[Transfered]
      ,[CreateDate]
      ,[CreateTime]
      ,[UpdateDate]
      ,[UpdateTime]
      ,[DataSource]
  FROM [SBO_COBAP_PRODUCAO].[dbo].[@ACBP_FAVORECIDO]");
    $row = mssql_fetch_array($version);

    //echo $row[1];
    while( $dados = mssql_fetch_assoc($version) ){
      echo $dados['Name']." - ".$dados['DocEntry']."<br>";
    }

// Limpieza
mssql_free_result($version);

?>
