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
$escopo = "Depoimentos";
$caminho = "Página Inicial";

/* objeto */
$objeto = $controlador['depoimento'];
$objeto->__toFillGeneric();
$resultado = $objeto->rows(false, false, 0, 'DESC', false);

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$conteudo .= "<div id=\"listaTitulo\"><img src=\"../images/seta_cinza.gif\" width=\"3\" height=\"5\" align=\"absmiddle\" border=\"0\" /> ".$dados[$objeto->campos[1]]."</div>";
	$conteudo .= "<div id=\"listaConteudo\"><a href=\"mailto:".$dados[$objeto->campos[2]]."\">".$dados[$objeto->campos[2]]."</a><br>".$dados[$objeto->campos[3]]."</div>";
	$conteudo .= "<div id=\"listaDivisao\"></div>";
}

$conteudo .= "<div id=\"formDepoimento\">";
$conteudo .= "Deixe seu depoimento sobre nosso serviço:";
$conteudo .= "<br /><br />";
$conteudo .= "<form name=\"formDepo\" action=\"registra.php?tipo=depoimento&acao=adicionar\" method=\"post\">";
$conteudo .= "<div id=\"formTitulo\">Nome</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"nome\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">E-mail</div>";
$conteudo .= "<div id=\"formCampo\"><input name=\"email\" type=\"text\" size=\"40\" class=\"form\" /></div>";
$conteudo .= "<div id=\"formTitulo\">Depoimento</div>";
$conteudo .= "<div id=\"formCampo\"><textarea name=\"depoimento\" cols=\"39\" rows=\"10\" class=\"form\"></textarea></div><br />";
$conteudo .= "<div id=\"formCampo\" align=\"center\"><input name=\"enviar\" type=\"button\" value=\"Enviar\" class=\"botao\" onClick=\"lrcpValDepoimento(formDepo.nome, formDepo.email, formDepo.depoimento, formDepo)\" />";
$conteudo .= "</form>";
$conteudo .= "</div>";

include('includeInterna.php');
?>