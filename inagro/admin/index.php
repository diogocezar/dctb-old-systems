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
* controle de sessуo
*/
$mensagemCS = false; // mensagem de entrada negada
include("controlaSession.php");


$titulo   = 'Bem vindo ao Painel Inagro';
$conteudo = 'Navegue pelo menu para administrar o sistema.';

$vencimentosDiarios = false;
$exiteAjax          = false;

include('includeInterna.php');
?>