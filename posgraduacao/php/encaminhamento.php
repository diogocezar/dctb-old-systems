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
<br><h3 align=\"center\">ENCAMINHAMENTO DE PROJETOS DE  PESQUISAS PARA ORGANISMOS DE FOMENTO </h3>
<p align=\"justify\"> Empresas e institui&ccedil;&otilde;es, como&nbsp; a UTFPR,  nos &uacute;ltimos anos, t&ecirc;m sido incentivadas a participar de programas de  desenvolvimento cient&iacute;fico e tecnol&oacute;gico. Um dos motivos seria a cria&ccedil;&atilde;o pelo  governo federal dos Fundos Setoriais, que facilitam a capta&ccedil;&atilde;o de recursos e o  financiamento dessas iniciativas. Esses Fundos, implantados progressivamente  desde 1999, s&atilde;o resultado de discuss&otilde;es, visando ao problema da baixa capacidade  de inova&ccedil;&atilde;o dos diversos setores produtivos brasileiros. Esta preocupa&ccedil;&atilde;o com a  inova&ccedil;&atilde;o n&atilde;o desmerece, mas sim ressaltar o trabalho herculano realizado por  &oacute;rg&atilde;os estaduais e federais como o <a href=\"http://www.cnpq.br\" target=\"_blank\" class=\"link_escuro\"><strong>CNPq</strong></a> que desde 1951 estruturaram a pesquisa no Pa&iacute;s, sem pesquisa n&atilde;o h&aacute; inova&ccedil;&atilde;o.  Neste contexto, a dimens&atilde;o inova&ccedil;&atilde;o &eacute; centro das pol&iacute;ticas desenvolvidas pelo  governo, notadamente, por meio do Minist&eacute;rio da Ci&ecirc;ncia e Tecnologia (MCT). <br />
  Os Fundos Setoriais  s&atilde;o uma iniciativa encabe&ccedil;ada pelo Minist&eacute;rio da Ci&ecirc;ncia e Tecnologia (MCT) que  transforma drasticamente o cen&aacute;rio de financiamento e de gest&atilde;o da pesquisa.  Eles prev&ecirc;em uma verba anual de R$ 1 bilh&atilde;o por ano e enfatizam a dimens&atilde;o  inova&ccedil;&atilde;o, ou seja forte intera&ccedil;&atilde;o com o setor produtivo. Hoje o Pa&iacute;s conta com  14 fundos implementados (mais informa&ccedil;&otilde;es site <a href=\"http://www.mct.gov.br/Fontes/Fundos/\" target=\"_blank\" class=\"link_escuro\"><strong>http://www.mct.gov.br/Fontes/Fundos/</strong></a>).  O principal objetivo &eacute; ampliar a capacidade de gera&ccedil;&atilde;o e de incorpora&ccedil;&atilde;o de  conhecimento cient&iacute;fico e tecnol&oacute;gico na produ&ccedil;&atilde;o de bens e servi&ccedil;os, visando  ao aumento da qualidade de vida da popula&ccedil;&atilde;o brasileira, da competitividade de  empresas e setores da economia.<br />
  Neste sentido a DIPOG  tem atuado em v&aacute;rias linhas de forma a enquadrar a UTFPR neste novo contexto  que exige cada vez mais atividades de pesquisa e desenvolvimento cooperadas com  as empresas. Destacamos grande empenho em editais do CT-INFRA e do FVA/TIB. Com  os editais CT-INFRA esfor&ccedil;os est&atilde;o sendo dirigidos para a re-adequa&ccedil;&atilde;o a  infra-estrutura de laborat&oacute;rios de pesquisa. Os editais FVA/TIB tem por  objetivo o apoio a projetos no &acirc;mbito do Programa TIB (Tecnologia Industrial  B&aacute;sica e Servi&ccedil;os Tecnol&oacute;gicos para a Inova&ccedil;&atilde;o e Competitividade, MCT), visando  expandir e consolidar a infra-estrutura de servi&ccedil;os tecnol&oacute;gicos, desta forma e  em conjunto com a Funda&ccedil;&atilde;o Arauc&aacute;ria no &acirc;mbito da DIPOG cabe destacar a  articula&ccedil;&atilde;o com a UFPR e o TECPAR para a cria&ccedil;&atilde;o e sustenta&ccedil;&atilde;o de uma rede de  N&uacute;cleos de Patenteamento no Estado. A Propriedade Intelectual &eacute; essencial para  que a dimens&atilde;o inova&ccedil;&atilde;o seja agregada as j&aacute; existentes, educa&ccedil;&atilde;o e pesquisa.  Sem um n&uacute;cleo de apoio as a&ccedil;&otilde;es pr&oacute;-inova&ccedil;&atilde;o n&atilde;o se desenvolver&atilde;o  plenamente.Desta forma, as a&ccedil;&otilde;es desenvolvidas pela DIPOG visam fortalecer a pesquisa  e p&oacute;s-gradua&ccedil;&atilde;o na UTFPR. O trabalho &eacute; visa aumentar a qualidade e quantidade  de pesquisas cooperadas com o setor produtivo bem como a valoriza&ccedil;&atilde;o dos  resultados para a UTFPR, pesquisador, empresas e principalmente para sociedade.<br />
  Com o objetivo de  informar padronizar o encaminhamento de projetos de pesquisa no Campus Corn&eacute;lio  Proc&oacute;pio, o DEPOG solicita que seja respeitado o seguinte procedimento:<br />
  <br />
  <strong>1)</strong> Entrega da documenta&ccedil;&atilde;o (formul&aacute;rio + projeto) no DEPOG, sendo que  deve ser entregue duas c&oacute;pias a mais do que o total solicitado pelos Organismos  de Formento (ver item 4).<br />
  <br />
  <strong>2)</strong> O DEPOG encaminhar&aacute; a documenta&ccedil;&atilde;o a Diretoria de Pesquisa e  P&oacute;s-Gradua&ccedil;&atilde;o (DIPOG) para assinatura do Diretor.<br />
  <br />
  <strong>3)</strong> A Diretoria encaminhar&aacute; a documenta&ccedil;&atilde;o aos Organismos de Fomento.  Caso n&atilde;o haja tempo h&aacute;bil para o envio pela UTFPR, o professor enviar&aacute; o  projeto assinado diretamente.<br />
  <br />
<strong>4)</strong> Uma c&oacute;pia ficar&aacute; arquivada no DEPOG e outra retornar&aacute; para o  Professor.</p>

<img src=\"../images/seta_preta.gif\"> <a href =\"../anexos/encaminhamento.doc\" class=\"link_escuro\"><b>Download do arquivo</b></a>
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