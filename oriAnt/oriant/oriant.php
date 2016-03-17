<?php
//session_start();
/**
* Arquivo de configuração
*/
include("../conf/config.php");

/**
* Biblioteca de funções
*/
include("../lib/library.php");

/**
* Indioma do sistema
*/
include("../lang/lang.php");

/**
* Cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* Incluindo funções ajax
*/ 
include("../ajax/ajax.php");

$cookie  = $controlador['cookie']->retornaCookie(COOKIE_GRUPO);
$session = $controlador['session']->retornaSession(SESSION_GRUPO);

/* Adicionar variáveis de cookie na sessão */

$redefineGrupo = $_GET['redefGrupo'];

if(!empty($redefineGrupo) || empty($cookie)){
	$escondeGrupo = false;
	/**
	* Excluindo conteúdos das possíveis cookies cadastradas.
	*/
	$controlador['cookie']->deletaCookie(COOKIE_GRUPO);
	$controlador['cookie']->deletaCookie(COOKIE_QUALG);
	$controlador['cookie']->deletaCookie(COOKIE_CONTE);
	$controlador['cookie']->deletaCookie(COOKIE_TIPOO);
	/**
	* Excluindo conteúdos das possíveis sessions cadastradas.
	*/
	$controlador['session']->limpaSessions();

	$executeJava = 'call_getGrupos();';
}
else{
	$escondeGrupo = true;
	$executeJava  = 'goExtractLinks();';
	
	$codGrupo = $controlador['cookie']->retornaCookie(COOKIE_QUALG);
	
	$tipo     = $controlador['cookie']->retornaCookie(COOKIE_TIPOO);
	$contexto = $controlador['cookie']->retornaCookie(COOKIE_CONTE);
	
	if(empty($tipo) || empty($contexto)){	
		$tipo     = $controlador['session']->retornaSession(SESSION_TIPOO);
		$contexto = $controlador['session']->retornaSession(SESSION_CONTE);
	}
	
	if(empty($tipo) || empty($contexto)){	
		$tipo     = TIPO_PADRAO;
		$contexto = CONTEXTO_PADRAO;
	}
	
	if($tipo == "ori"){
		$executeJava  .= 'onOriRelacionada();';
	}
	else{
		$executeJava  .= 'offOriRelacionada();';
	}
			
	$controlador['grupo']->__get_db($codGrupo);
	$nomeGrupo = $controlador['grupo']->getNome();

	/* Combo Opções */
	$arrayCombo = array('obj' => $lang['cmp_tipo_orientacao_obj'],
						'ori' => $lang['cmp_tipo_orientacao_ori'],
						'par' => $lang['cmp_tipo_orientacao_par']
						);
						
	$comboOpcoes = '';

	foreach($arrayCombo as $valor => $opcao){
		$comboOpcoes .= "<option value=\"$valor\"";
		if($valor == $tipo){
			$comboOpcoes .= "selected";
		}
		$comboOpcoes .= ">$opcao</option>";
	}

	$tipoOrientacao = $arrayCombo[$tipo];

}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'oriant.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Titulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
/* Bloco Skin */
	$template->setCurrentBlock("bloco_skin");
		$skin = $_GET['skin'];
		$template->setVariable("skin", $skin);
	$template->parseCurrentBlock("bloco_skin");
	
/* Bloco Javascript */
	$template->setCurrentBlock("bloco_javascript");
		$template->setVariable("sjax", sajax_show_javascript());
		$template->setVariable("domain", DOMAIN);
		$template->setVariable("cookie_grupo", COOKIE_GRUPO);
		$template->setVariable("cookie_qualg", COOKIE_QUALG);
		$template->setVariable("cookie_conte", COOKIE_CONTE);
		$template->setVariable("cookie_tipoo", COOKIE_TIPOO);
	$template->parseCurrentBlock("bloco_javascript");
	
/* Bloco Html */
	$template->setCurrentBlock("bloco_html");
		
		/* Links */
		$template->setVariable("link_help", "help.php");
		$template->setVariable("link_language", "language.php");
		
		/* Titulos */	
		$template->setVariable("titulo_grupo", $lang['titulo_grupo']);
		$template->setVariable("titulo_contexto", $lang['titulo_contexto']);
		
		/* Formulario */
		$template->setVariable("id_form", "id_form");
		
			/* Radio Box */
			$template->setVariable("cmp_radio_op1", $lang['cmp_radio_op1']);
			$template->setVariable("cmp_radio_op2", $lang['cmp_radio_op2']);
			$template->setVariable("radio_name", "contexto_orientacao");
			$template->setVariable("radio_value_1", "this_page");
			$template->setVariable("radio_value_2", "all_pages");
			
				/* Marcando o contexto selecionado */
				
				if($contexto == "all_pages"){
					$template->setVariable("radio_check_2", "checked");
				}
				else{
					$template->setVariable("radio_check_1", "checked");
				}

			/* Combo Box */
			$template->setVariable("combo_name", "combo_tipo_orientacao");
			$template->setVariable("combo_opcoes", $comboOpcoes);
		
		/* JavaScripts */
		$template->setVariable("execute_java", $executeJava);
		$template->setVariable("combo_java", "call_changeSystem()");
		$template->setVariable("radio_java_1", "clickRadio(id_form.contexto_orientacao, 'this_page')");
		$template->setVariable("radio_java_2", "clickRadio(id_form.contexto_orientacao, 'all_pages')");
				
		/* Alt's */
		$template->setVariable("alt_logo", $lang['alt_logo']);
		
		/* Campos */
		$template->setVariable("cmp_titulo", $lang['cmp_titulo']);
		$template->setVariable("cmp_help", $lang['cmp_help']);
		$template->setVariable("cmp_lnaguage", $lang['cmp_lnaguage']);
		$template->setVariable("cmp_selecione_grupo", $lang['cmp_selecione_grupo']);
		$template->setVariable("cmp_tipo_orientacao", $tipoOrientacao);
		$template->setVariable("cmp_lb_tipo_oriantcao", $lang['cmp_lb_tipo_oriantcao']);
		$template->setVariable("cmp_carregando", $lang['cmp_carregando']);
		$template->setVariable("cmp_disposicao_rel", $lang['cmp_disposicao_rel']);
		
		/* Grupos */
		if($escondeGrupo){
			$template->setVariable("cmp_titulo_grupo", $lang['cmp_titulo_grupo']);
			$template->setVariable("cmp_grupo", $nomeGrupo);
			$template->setVariable("cmp_alterar", "&nbsp;<a href=\"oriant.php?redefGrupo=ok&skin=$skin\"><img src=\"../images/alterarGrupo.gif\" border=\"0\" alt=\"".$lang['alt_alterar_grupo']."\"/></a>");
		}
		
	$template->parseCurrentBlock("bloco_html");
	
$template->show();
?>