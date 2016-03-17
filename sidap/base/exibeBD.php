<HTML>
<HEAD>
<TITLE> Exibindo DBF </TITLE>
</HEAD>
<BODY>
<?php
set_time_limit(0);
$banco = $_GET['banco'];
if(!empty($banco)){
	//Arquivo DBF
	$dbname = './bancosDBF/'.$banco;
	//Conectando com o MySQL
	$conMS = mysql_connect('localhost','root','') or die('erro na conexão');
	$id = mysql_select_db('sidap',$conMS) or die('Erro na seleção do Database');
	
	//Abre o banco de dados Dbase
	//0 - somente leitura
	//1 - somente escrita
	//2 - leitura / escrita
	$con = dbase_open($dbname,0) or die('Erro na Conexão com o arquivo DBF');
	//Lista os dados da Tabela
	$rows = dbase_numrecords($con);
	echo 'Numero de registros ... >>> <b> ' . $rows . ' </b><br><br>';
	
	for($i=1;$i<=$rows;$i++) {
	$registro = dbase_get_record_with_names($con,$i); //Pega o registro do arquivo DBF
		print_r($registro);
		echo "<hr>";
	}
}
?>
</BODY>
</HTML>