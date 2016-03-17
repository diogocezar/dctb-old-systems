<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

$permitido = false;

@$session = new Session();

if($_SESSION['usuarioSession'] == 'sim'){
	$codUser  = $session->retornaSession('codSession');
	$permitido = true;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='index.php'</script>";
}
else{

	$id = $_GET['id'];
	
	$db = new DataBase();
	
	$db->Query("DELETE FROM {$tabela['favoritos']} WHERE cli_cpf = '$codUser' AND fil_cod = $id");
	
	echo "<script language=javascript>alert('O filme foi removido de seus favoritos.');javascript:history.go(-1);</script>";
}
?>