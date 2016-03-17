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
$nivelRequerido = "admin";
include("../php/controlaSession.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Adminsitra��o";
$caminho = "P�gina Inicial";

/* extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

if(empty($acao)){
	echo "<script language=javascript>alert('Uma a��o � necess�ria para acessar essa p�gina.');location.href='administrar.php'</script>";
	exit();
}
else{
	if($acao == "atualizar"){
		if(empty($id)){
			echo "<script language=javascript>alert('Uma identifica��o � necess�ria para acessar essa p�gina.');location.href='administrar.php'</script>";
			exit();
		}
	}
}

$contexto      = "depoimento";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();

switch($acao){
	case 'adicionar' :
		$contextoArray['action'] = "registra.php?tipo=$contexto&acao=$acao";
		$contextoArray['titulo'] = "Inserir ".ucfirst($nome);
		break;
	
	case 'atualizar' :
		$contextoArray['action'] = "registra.php?tipo=$contexto&acao=$acao&id=$id";
		$contextoArray['titulo'] = "Atualizar ".ucfirst($nome);
		
		/* recuperando dados */
		$objRec->__get_db($id);
		break;
}

/* diret�rio dos templates */
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
		$template->setVariable("campoNome",       "nome");
		$template->setVariable("campoEmail",      "email");
		$template->setVariable("campoDepoimento", "depoimento");
	
	/* valores dos campos */
		$template->setVariable("valorNome",         $objRec->getNome());
		$template->setVariable("valorEmail",        $objRec->getEmail());
		$template->setVariable("valorDepoimento",   $objRec->getDepoimento());		
		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "lrcpValDepoimento($form.nome, $form.email, $form.depoimento, $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");	
?>