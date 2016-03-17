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

$id     = $_GET['id'];

$altera = $_GET['altera'];

switch($altera){
	case 'locar':
		$loc = "Sim";
		break;
	case 'disponibilizar':
		$loc = "Não";
		break;
}

$db = new DataBase();

$db->Query("UPDATE {$tabela['midia']} SET mid_status = '$loc' WHERE mid_cod = $id");

echo "<script language=javascript>alert('O status da mídia foi alterado com sucesso !');location.href='administrar.php'</script>";
?>