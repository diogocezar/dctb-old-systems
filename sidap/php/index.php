<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include funções ajax
*/
include("../ajax/ajax.php");

/**
* controle de sessão
*/
$mensagemCS = false; // mensagem de entrada negada
include("controlaSession.php");


$titulo   = 'Bem vindo ao SIDAP';
$conteudo = 'Pequeno texto descrevendo o sistema.';

$nivel = $_SESSION['sessNivel'];

if($nivel <= 3){
	$alertasDiarios = true;
	$exiteAjax      = true;
	
	$onLoad .= "onLoad = \"";
	$onLoad .= "Agenda.getAgendaByDateHour('".date('Y-m-d')."');";
	$onLoad .= "\"";
}

include('includeInterna.php');
?>
