<?php
/**
* arquivo de configuraзгo
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


/* diretуrio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'principal.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* conversгo das variбveis dos blocos */

/* bloco do tнtulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* bloco login */
$template->setCurrentBlock("bloco_login");
	$template->setVariable("actionLogin", "login.php");
	$template->setVariable("formLogin", "form_login");
	$template->setVariable("login", "login");
	$template->setVariable("senha", "senha");
	$template->setVariable("onKpLogin", "pulaCampoNoEnter(senha)");
	$template->setVariable("onKpSenha", "enviaLoginOnEnter(form_login.login, form_login.senha, form_login)");
	$template->setVariable("onClickLogin", "serValLogin(form_login.login, form_login.senha, form_login)");
$template->parseCurrentBlock("bloco_login");

/* bloco servilha intro */
$template->setCurrentBlock("bloco_servilhaIntro");
	$template->setVariable("servilhaIntro", INTRO_SERVILHA);
$template->parseCurrentBlock("bloco_servilhaIntro");

/* bloco area atuacao */
$template->setCurrentBlock("bloco_areaAtuacao");
	$atuacao = $controlador['atuacao'];
	$atuacao->__toFillGeneric();
	$atuacao->retornaRand();
	$template->setVariable("linkArea", "atuacao.php");
	$template->setVariable("tituloArea", $atuacao->getTitulo());
	$template->setVariable("conteudoArea", limitaStr($atuacao->getDescricao(), STR_LIMITE_AREA_ATUACAO));
$template->parseCurrentBlock("bloco_areaAtuacao");

/* bloco sobre servilha */
$template->setCurrentBlock("bloco_sobreServilha");
	$template->setVariable("sobreServilha", SOBRE_SERVILHA);
$template->parseCurrentBlock("bloco_sobreServilha");

/* bloco ultimos artigos */
$template->setCurrentBlock("bloco_ultimosArtigos");
	$artigo = $controlador['artigo'];
	$artigo->__toFillGeneric();
	$resultado = $artigo->lastArticles(3);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_ultimosArtigosInterno");
			$link = "vejaArtigo.php?id=".$dados[$artigo->campos[0]];
			$template->setVariable("tituloArtigo",limitaStr($dados[$artigo->campos[2]], STR_LIMITE_TITULO_ARTIGO_RESUMO));
			$template->setVariable("linkArtigo", $link);
		$template->parseCurrentBlock("bloco_ultimosArtigosInterno");
	}	
$template->parseCurrentBlock("bloco_ultimosArtigos");

/* bloco vocabulario */
$template->setCurrentBlock("bloco_vocabulario");
	$template->setVariable("vocabularioJuridico", VOCABULARIO_SERVILHA);
$template->parseCurrentBlock("bloco_vocabulario");

/* bloco links */
$template->setCurrentBlock("bloco_links");
	$link = $controlador['link'];
	$link->__toFillGeneric();
	$resultado = $link->lastLinks(4);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_linksInterno");
			$linkLink = $dados[$link->campos[2]];
			$template->setVariable("tituloLink", limitaStr($dados[$link->campos[1]],STR_LIMITE_TITULO_LINK));
			$template->setVariable("linkLink", $linkLink);
		$template->parseCurrentBlock("bloco_linksInterno");
	}	
$template->parseCurrentBlock("bloco_links");

/* bloco menu */
$template->setCurrentBlock("bloco_menu");
	foreach($menu as $link){
		$template->setVariable($menu, $link);
	}
$template->parseCurrentBlock("bloco_menu");	

/* bloco conteudo */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $conteudo);
$template->setCurrentBlock("bloco_conteudo");

/* bloco kreea */
$template->setCurrentBlock("bloco_kreea");	
	$template->setVariable("linkKreea", "http://www.kreea.com.br");
$template->parseCurrentBlock("bloco_kreea");

/* bloco principal */
$template->setCurrentBlock("bloco_principal");
	$onLoad .= 	"setaFoco(document.form_login.login);";
	$template->setVariable("onLoad", $onLoad);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>