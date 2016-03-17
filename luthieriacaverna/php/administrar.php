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
* incluindo controle de sess�o
*/
include("../php/controlaSession.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Adminsitra��o";
$caminho = "P�gina Inicial";
$conteudo .= "Bem vindo ao painel de adminstra��o, selecione uma das seguintes op��es:";
$conteudo .= "<div id=\"painelAdmin\">";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmInformacoes.php\">Gerenciar Informa��es Institucionais</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmServico.php?acao=adicionar\">Inserir Servi�o</a></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=servico&campos=1\">Gerenciar Servi�os</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmDica.php?acao=adicionar\">Inserir Dica</a></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=dica&campos=1\">Gerenciar Dicas</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmNoticia.php?acao=adicionar\">Inserir Noticia</a></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=noticia&campos=1\">Gerenciar Noticias</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmLink.php?acao=adicionar\">Inserir Link</a></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=link&campos=1\">Gerenciar Links</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=depoimento&campos=1\">Gerenciar Depoimentos</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"logOut.php\">Sair</a></div><br />";
$conteudo .= "</div>";

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");
?>