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
$escopo = "Serviços";
$caminho = "Página Inicial";

/* objeto */
$objeto = $controlador['servico'];
$objeto->__toFillGeneric();
$resultado = $objeto->rows(false, false, 0, 'DESC', false);

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$conteudo .= "<div id=\"listaTitulo\"><img src=\"../images/seta_cinza.gif\" width=\"3\" height=\"5\" align=\"absmiddle\" border=\"0\" /> ".$dados[$objeto->campos[1]]."</div>";
	$conteudo .= "<div id=\"listaConteudo\">".$dados[$objeto->campos[2]]."</div>";
	$conteudo .= "<div id=\"listaDivisao\"></div>";
}

include('includeInterna.php');
?>