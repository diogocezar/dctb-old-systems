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
include("../admin/controlaSession.php");

/**
* incluindo ajax
*/
include("../ajax/ajax.php");

/* extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

if(empty($acao)){
	echo "<script language=javascript>alert('Uma ação é necessária para acessar essa página.');location.href='index.php'</script>";
	exit();
}
else{
	if($acao == "atualizar"){
		if(empty($id)){
			echo "<script language=javascript>alert('Uma identificação é necessária para acessar essa página.');location.href='index.php'</script>";
			exit();
		}
	}
}

$contexto      = "parceiro";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();

switch($acao){
	case 'adicionar' :
		$contextoArray['action'] = "registra.php?tipo=$contexto&acao=$acao";
		$contextoArray['titulo'] = "Inserir registro: ".ucfirst($nome);
		break;
	
	case 'atualizar' :
		$contextoArray['action'] = "registra.php?tipo=$contexto&acao=$acao&id=$id";
		$contextoArray['titulo'] = "Atualizar registro: ".ucfirst($nome);
		
		/* recuperando dados */
		$objRec->__get_db($id);
		break;
}

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frm".ucfirst($contexto).".html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_".$contexto;
		$template->setVariable("form".ucfirst($contexto), $form);
		$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
	
	/* titulos */
		$template->setVariable("titulo".ucfirst($contexto), $contextoArray['titulo']);

	/* nomes dos campos */
		$template->setVariable("campoFoto", "foto");
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoLink", "link");

	/* valores dos campos */
		$template->setVariable("valorFoto", $objRec->getFoto());
		$template->setVariable("valorNome", $objRec->getNome());
		$template->setVariable("valorLink", $objRec->getLink());
			
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "setaFoco(document.$form.nome);";
		$onLoad .= "\"";
		
	/* preenchendo miniaturas */
		if($acao == 'atualizar'){
			$arquivo = $objRec->getFoto();
			if(!empty($arquivo)){
				$onClickExcluir = "call_getExcluirFoto('".$tabelaMap['parceiro']."','".$camposMap['parceiro'][1]."','".$id."','".$arquivo."');";
				$btnExcluir = "<input name=\"Excluir\" type=\"button\" value=\"Excluir\" class=\"botaoPagar\" onClick=\"".$onClickExcluir."\" />";
				$template->setVariable("textoMiniatura", "<img src=\"img.php?l=116&a=91&s=no&loc=".$arquivo."\" class=\"imgMin\"> - ".$btnExcluir);
			}
		}

		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "parceiro($form.nome, $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

$exiteAjax = true;

/* incluindo conteudo na página interna */
include("../admin/includeInterna.php");	
?>