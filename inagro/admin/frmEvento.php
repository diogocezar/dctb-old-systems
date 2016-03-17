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

$contexto      = "evento";
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
		$template->setVariable("campoFoto1",     "foto1");
		$template->setVariable("campoFoto2",     "foto2");
		$template->setVariable("campoFoto3",     "foto3");
		$template->setVariable("campoFoto4",     "foto4");
		$template->setVariable("campoFoto5",     "foto5");
		$template->setVariable("campoFoto6",     "foto6");
		$template->setVariable("campoFoto7",     "foto7");
		$template->setVariable("campoFoto8",     "foto8");	

	/* valores dos campos */
		$template->setVariable("valorTitulo",       $objRec->getTitulo());
		$template->setVariable("valorDescricao",    $objRec->getDescricao());
		$template->setVariable("valorData",         desconverteData($objRec->getData()));
		$template->setVariable("valorFoto1",        $objRec->getFoto1());
		$template->setVariable("valorFoto2",        $objRec->getFoto2());
		$template->setVariable("valorFoto3",        $objRec->getFoto3());
		$template->setVariable("valorFoto4",        $objRec->getFoto4());
		$template->setVariable("valorFoto5",        $objRec->getFoto5());
		$template->setVariable("valorFoto6",        $objRec->getFoto6());
		$template->setVariable("valorFoto7",        $objRec->getFoto5());
		$template->setVariable("valorFoto8",        $objRec->getFoto6());
		
	/* preenchendo miniaturas */
	if($acao == 'atualizar'){
		$miniatura[0] = $objRec->getFoto1();
		$miniatura[1] = $objRec->getFoto2();
		$miniatura[2] = $objRec->getFoto3();
		$miniatura[3] = $objRec->getFoto4();
		$miniatura[4] = $objRec->getFoto5();
		$miniatura[5] = $objRec->getFoto6();
		$miniatura[6] = $objRec->getFoto7();
		$miniatura[7] = $objRec->getFoto8();
		
		for($i=0, $j=4; $i<8; $i++, $j++){
			if(!empty($miniatura[$i])){
				$onClickExcluir = "call_getExcluirFoto('".$tabelaMap['evento']."','".$camposMap['evento'][$j]."','".$id."','".$miniatura[$i]."');";
				$btnExcluir = "<input name=\"Excluir\" type=\"button\" value=\"Excluir\" class=\"botaoPagar\" onClick=\"".$onClickExcluir."\" />";
				$template->setVariable("textoMiniatura$i", $miniatura[$i]." - ".$btnExcluir);
				$template->setVariable("miniaturaFoto$i",  "<img src=\"img.php?l=116&a=91&s=no&loc=".$miniatura[$i]."\" class=\"imgMin\">");
			}
		}
	}
			
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "setaFoco(document.$form.titulo);";
		$onLoad .= "\"";
		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "evento($form.titulo, $form.descricao, $form.data, $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

/* incluindo conteudo na página interna */
include("../admin/includeInterna.php");	
?>