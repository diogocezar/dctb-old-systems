<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
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
		echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
		exit();
}

$id         = $_GET['id'];

$bloquear   = $_GET['bloquear'];


$db = new DataBase();

$db->Query("UPDATE {$tabela['cliente']} SET cli_bloqueado = '$bloquear' WHERE cli_cpf = $id");

echo "<script language=javascript>alert('A situação do cliente foi alterada com sucesso !');javascript:history.go(-1);</script>";
?>