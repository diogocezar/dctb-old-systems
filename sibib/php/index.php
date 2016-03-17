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

$titulo   = 'Bem vindo ao SIBIB';
$conteudo = 'Pequeno texto descrevendo o sistema.';

include('includeInterna.php');
?>
