<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Verificando se o id está vazio */
$id = anti_sql_injection($_GET['id']);
if(empty($id)){
	echo "<script language=javascript>alert('Selecione um link para ser redirecionado!');location.href='index.php'</script>";
	exit();
}

$atualizaVisitas = new DataBase();
$atualizaVisitas->query("UPDATE {$tabela['links']} SET visitasLi = visitasLi+1 WHERE idLinks=$id");

$sql = "SELECT urlLi FROM {$tabela['links']} WHERE idLinks=$id";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
}

$link = replaceLink($dados['urlLi']);

echo "<script language=javascript>location.href='$link'</script>";
?>