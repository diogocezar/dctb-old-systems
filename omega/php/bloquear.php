<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

@$session = new Session();

$permitido = false;

if($_SESSION['permitidoSession'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('codSession'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nomeSession');
	$login = $session->retornaSession('loginSession');
	$tipo = sessionNum($session->retornaSession('tipoSession'));
	$tipo = (int)$tipo;
}

if($permitido != true){
		echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='login.php'</script>";
		exit();
}

$id         = $_GET['id'];

$bloquear   = $_GET['bloquear'];


$db = new DataBase();

$db->Query("UPDATE {$tabela['cliente']} SET cli_bloqueado = '$bloquear' WHERE cli_cpf = $id");

echo "<script language=javascript>alert('A situa��o do cliente foi alterada com sucesso !');javascript:history.go(-1);</script>";
?>