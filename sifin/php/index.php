<?php
/**
* arquivo de configuraчуo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include funчѕes ajax
*/
include("../ajax/ajax.php");

/**
* controle de sessуo
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