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
* biblioteca de funcoes
*/
include("../lib/library.php");
include("../lib/util.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Administra��o (Login)";
$caminho = "P�gina Inicial";

$conteudo .= "<form name=\"formLogin\" action=\"entrarLogin.php\" method=\"post\">";
$conteudo .= "<div id=\"boxLogin\">";
$conteudo .= "<div id=\"formTitulo\">Login</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"login\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">Senha</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"senha\" type=\"password\" size=\"40\" class=\"form\" /></div><br />";
$conteudo .= "<div id=\"formCampo\" align=\"center\"><input name=\"enviar\" type=\"button\" value=\"Enviar\" class=\"botao\" onClick=\"lrcpValLogin(formLogin.login, formLogin.senha, formLogin)\" />";

$conteudo .= "</div>";

include('includeInterna.php');
?>