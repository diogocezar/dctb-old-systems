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
* incluindo controle de sessão
*/
include("../php/controlaSession.php");

/* definições para página interna */
$pagina = getPaginaAtual();
$escopo = "Adminsitração";
$caminho = "Página Inicial";
$conteudo .= "Bem vindo ao painel de adminstração, selecione uma das seguintes opções:";
$conteudo .= "<div id=\"painelAdmin\">";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmInformacoes.php\">Gerenciar Informações Institucionais</a></div>";
$conteudo .= "<div id=\"menuAdmDivisao\"></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"frmServico.php?acao=adicionar\">Inserir Serviço</a></div>";
$conteudo .= "<div id=\"itemAdmin\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" /> <a href = \"gerenciar.php?tabela=servico&campos=1\">Gerenciar Serviços</a></div>";
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

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");
?>