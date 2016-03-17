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


$titulo    = 'Atualizações do sistema';
$conteudo .= 'Caro colaborador, <br><br>';
$conteudo .= 'Fique sempre atento a esse informativo para conhecer as atualizações do sistema.<br><br>';
$conteudo .= '<ol>';
$conteudo .= '<li>Para visualizar os detalhes dos registros é necessário clicar sobre os mesmos;</li>';
$conteudo .= '<li>O gerenciamento de coletas só mostrará informações caso o colaborador digite alguma informação relativa a coleta;</li>';
$conteudo .= '</ol>';
$conteudo .= '<br>';
$conteudo .= 'Qualquer dúvida, queira reportar a equipe de desenvolvimento. <br><br>';
$conteudo .= 'Obrigado e bom trabalho.';

$vencimentosDiarios = false;
$exiteAjax          = false;


if(!empty($opCliente)){
	$conteudo = TEXTO_LOGIN_CLIENTE;
	$titulo   = "";
	/* incluindo conteudo na página interna específica para cliente*/
	include("../php/includeInternaCliente.php");	
}
else{
	/* incluindo conteudo na página interna */
	include("../php/includeInterna.php");	
}
?>