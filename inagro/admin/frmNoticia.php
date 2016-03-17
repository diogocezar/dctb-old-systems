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

$contexto      = "noticia";
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
		$template->setVariable("campoTitulo",    "titulo");
		$template->setVariable("campoDescricao", "descricao");
		$template->setVariable("campoData",      "data");
		$template->setVariable("campoFoto",      "foto");

	/* valores dos campos */
		$template->setVariable("valorTitulo",     $objRec->getTitulo());
		$template->setVariable("valorDescricao",  $objRec->getDescricao());
		$template->setVariable("valorData",       desconverteData($objRec->getData()));
		$template->setVariable("valorFoto",       $objRec->getFoto());

	/* preenchendo miniaturas */
		if($acao == 'atualizar'){
			$foto = $objRec->getFoto();
			if(!empty($foto)){
				$onClickExcluir = "call_getExcluirFoto('".$tabelaMap['noticia']."','".$camposMap['noticia'][4]."','".$id."','".$foto."');";
				$btnExcluir = "<input name=\"Excluir\" type=\"button\" value=\"Excluir\" class=\"botaoPagar\" onClick=\"".$onClickExcluir."\" />";
				$template->setVariable("textoMiniatura", $foto." - ".$btnExcluir);
				$template->setVariable("miniaturaFoto",  "<img src=\"img.php?l=116&a=91&s=no&loc=".$foto."\" class=\"imgMin\">");
			}
		}
			
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "setaFoco(document.$form.titulo);";
		$onLoad .= "\"";
		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "$contexto($form.titulo, $form.descricao, $form.data, $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

/* incluindo conteudo na página interna */
include("../admin/includeInterna.php");	
?>