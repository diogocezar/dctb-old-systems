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
* biblioteca de funcoes
*/
include("../lib/library.php");
include("../lib/util.php");

/* definições para página interna */
$pagina = getPaginaAtual();
$escopo = "Contato";
$caminho = "Página Inicial";

$conteudo .= "<div id=\"formContato\">";
$conteudo .= "Entre em contato com nossa empresa:";
$conteudo .= "<br /><br />";
$conteudo .= "<form name=\"formCont\" action=\"enviaContato.php\" method=\"post\">";
$conteudo .= "<div id=\"formTitulo\">Nome</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"nome\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">E-mail</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"email\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">Assunto</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"assunto\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">Mensagem</div>";
$conteudo .= "<div id=\"formCampo\"><textarea name=\"mensagem\" cols=\"39\" rows=\"10\" class=\"form\"></textarea></div><br />";
$conteudo .= "<div id=\"formCampo\" align=\"center\"><input name=\"enviar\" type=\"button\" value=\"Enviar\" class=\"botao\" onClick=\"lrcpValContato(formCont.nome, formCont.email,  formCont.assunto, formCont.mensagem, formCont)\" />";
$conteudo .= "</form>";
$conteudo .= "</div>";

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>