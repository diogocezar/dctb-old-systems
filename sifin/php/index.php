<?php
/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include fun��es ajax
*/
include("../ajax/ajax.php");

/**
* controle de sess�o
*/
$mensagemCS = false; // mensagem de entrada negada
include("controlaSession.php");


$titulo   = 'Bem vindo ao SIFIN';
$conteudo = 'Pequeno texto descrevendo o sistema.';

$vencimentosDiarios = true;
$exiteAjax          = true;

$onLoad .= "onLoad = \"";
$onLoad .= "call_getParcelasFromDBByDate('".date('Y-m-d')."');";
$onLoad .= "\"";

include('includeInterna.php');
?>