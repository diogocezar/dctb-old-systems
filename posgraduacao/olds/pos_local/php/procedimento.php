<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Sobre o DEPOG");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", "
<br><p align=\"center\"><strong><h3 align=\"center\">PROCEDIMENTOS &nbsp;DE ABERTURA DE  NOVOS CURSOS DE ESPECIALIZA&Ccedil;&Atilde;O</h3></strong> </p>
<p align=\"justify\"><br />
  Os cursos de especializa&ccedil;&atilde;o  oferecidos pela UTFPR devem estar de acordo com a Delibera&ccedil;&atilde;o n&ordm; 05/2002, a  Norma Complementar vigente na Delibera&ccedil;&atilde;o n&ordm; 17/98 do Conselho Diretor  (Regulamento dos Cursos de P&oacute;s-Gradua&ccedil;&atilde;o Lato Sensu) e a Resolu&ccedil;&atilde;o n&ordm; 1, de 03  de abril de 2001, da C&acirc;mara de Ensino Superior, do Conselho Nacional de  Educa&ccedil;&atilde;o (CES/CNE).</p>
<p align=\"left\"><br />
  O procedimento para abertura de  um novo curso consiste na:</p>
<ol start=\"1\" type=\"1\">
  <li>Entrega       da <u>proposta de abertura do curso de especializa&ccedil;&atilde;o</u> (<u><a href=\"http://www.cefetpr.br/dipog/downloads/especializacao/modelo_projeto_versao_final_2005.doc\" class=\"link_escuro\"><strong>modelo       de projeto</strong></a></u>). No caso da reedi&ccedil;&atilde;o de um mesmo curso, a an&aacute;lise       somente ser&aacute; feita ap&oacute;s a aprova&ccedil;&atilde;o <u>relat&oacute;rio parcial</u> (<strong><u><a href=\"http://www.cefetpr.br/dipog/downloads/especializacao/modelo_relatorio_versao_final_2005.doc\" class=\"link_escuro\">modelo de relat&oacute;rio</a></u></strong>)       (<strong><u><a href=\"http://www.cefetpr.br/dipog/downloads/especializacao/instrucao_normativa.doc\" class=\"link_escuro\">instru&ccedil;&atilde;o normativa</a></u></strong>)       do curso pela C&acirc;mara de P&oacute;s-Gradua&ccedil;&atilde;o e Pesquisa. No caso de cursos na sua       2&ordf; edi&ccedil;&atilde;o, ap&oacute;s aprova&ccedil;&atilde;o do relat&oacute;rio de conclus&atilde;o da 1&ordf; turma, segue-se       o procedimento descrito na delibera&ccedil;&atilde;o 05/2002 para credenci&aacute;-lo; </li>
  <li>An&aacute;lise       da proposta pela <a href=\"http://www.ct.cefetpr.br/gerep/depog/programas_camara.html\" class=\"link_escuro\"><strong>C&acirc;mara de P&oacute;s-Gradua&ccedil;&atilde;o       e Pesquisa</strong></a>; </li>
  <li>Aprova&ccedil;&atilde;o       da proposta pelo Conselho de Ensino; </li>
  <li>Resolu&ccedil;&atilde;o       do Diretor de Ensino para abertura do curso. </li>
</ol>
<p>A abertura dos cursos se dar&aacute;  com a publica&ccedil;&atilde;o, at&eacute; 30 (trinta) dias antes do in&iacute;cio das inscri&ccedil;&otilde;es, nos  ve&iacute;culos de comunica&ccedil;&atilde;o da pr&oacute;pria institui&ccedil;&atilde;o e na imprensa, do correspondente  edital. O edital (<u><a href=\"http://www.cefetpr.br/dipog/downloads/especializacao/modelo_edital20021205.doc\" class=\"link_escuro\">modelo  de edital</a></u>) dever&aacute; ser redigido pelo Coordenador do curso,  sendo que:</p>
<ol start=\"1\" type=\"1\">
  <li>O n&uacute;mero da <strong>Resolu&ccedil;&atilde;o</strong> ser&aacute; informado pela <strong>DIREN;</strong> </li>
</ol>
<ul type=\"disc\">
  <li>O n&uacute;mero do <strong>Edital</strong> &eacute; atribu&iacute;do pelo <strong>DEPOG.</strong> </li>
</ul>
<p align=\"justify\">O Coordenador tamb&eacute;m &eacute;  respons&aacute;vel pela solicita&ccedil;&atilde;o da confec&ccedil;&atilde;o da Guia de recolhimento no valor da  inscri&ccedil;&atilde;o (FUNCEFET- modelo), Elabora&ccedil;&atilde;o de Folders&nbsp; e Divulga&ccedil;&atilde;o na Internet <br />
  A aprova&ccedil;&atilde;o dos Cursos de  Especializa&ccedil;&atilde;o e Aperfei&ccedil;oamento &eacute; de compet&ecirc;ncia da Diretoria de Ensino,  tomando por base o <u>relat&oacute;rio conclusivo</u> (<u><a href=\"http://www.cefetpr.br/dipog/downloads/especializacao/modelo_relatorio_versao_final_2005.doc\" class=\"link_escuro\"><strong>modelo de relat&oacute;rio</strong></a></u>)  do Coordenador, referendado pelo Conselho de Ensino. </p>

<img src=\"../images/seta_preta.gif\"> <a href =\"../anexos/procedimento.doc\" class=\"link_escuro\"><b>Download do arquivo</b></a><br><br>
<img src=\"../images/seta_preta.gif\"> <a href =\"http://www.cefetpr.br/dipog/downloads/especializacao/\" class=\"link_escuro\"><b>Outros documentos</b></a>

<br><br><div align=\"center\"><input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\"></div><br><br>
	");
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $link => $titulo){
			$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>