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

/* extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

if(empty($acao)){
	echo "<script language=javascript>alert('Uma a��o � necess�ria para acessar essa p�gina.');location.href='index.php'</script>";
	exit();
}
else{
	if($acao == "atualizar"){
		if(empty($id)){
			echo "<script language=javascript>alert('Uma identifica��o � necess�ria para acessar essa p�gina.');location.href='index.php'</script>";
			exit();
		}
	}
}

$contexto      = "usuario";
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

/* gerando combo de nivel de usu�rio */
$nivel = $controlador['nivel'];
$nivel->__toFillGeneric();
$condicao  = $nivel->campos[4].' = TRUE';
$resultado = $nivel->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$niveisCombo .= "<option value=\"".$dados[$nivel->campos[0]]."\"";
	if($objRec->getIdnivel() == $dados[$nivel->campos[0]]){
		$niveisCombo .= "selected";
	}
	$niveisCombo .= ">".$dados[$nivel->campos[1]]."</option>";
}

/* gerando situa��o */
if($objRec->getSituacao() == 't'){
	$textoSituacao = 'Ativo';
}
else{
	$textoSituacao = 'Inativo';
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
		$template->setVariable("comboNivel",     "nivel");
		$template->setVariable("campoNome",      "nome");
		$template->setVariable("campoLogin",     "loginUsuario");
		$template->setVariable("campoSenha",     "senhaUsuario");
		$template->setVariable("campoSituacao",  "situacao");
	
	/* valores dos campos */
		$template->setVariable("valorNome",      $objRec->getNome());
		$template->setVariable("valorLogin",     $objRec->getLogin());
		$template->setVariable("valorSenha",     $objRec->getSenha());
		$template->setVariable("valorSituacao",  $textoSituacao);
		
	/* preenchendo data baixa e dada cadastro se existir */
		$dataBaixa    = $objRec->getDatabaixa();
		$dataCadastro = $objRec->getDatacadastro();
		if(!empty($dataBaixa)){
			$template->setCurrentBlock("bloco_formulario_data_baixa");
				$template->setVariable("campoDataBaixa", "dataBaixa");
				$template->setVariable("valorDataBaixa",  desconverteData($dataBaixa));
			$template->parseCurrentBlock("bloco_formulario_data_baixa");
		}
		if(!empty($dataCadastro)){
			$template->setCurrentBlock("bloco_formulario_data_cadastro");
				$template->setVariable("campoDataCadastro", "dataCadastro");
				$template->setVariable("valorDataCadastro",  desconverteData($dataCadastro));
			$template->parseCurrentBlock("bloco_formulario_data_cadastro");
		}
		
	/* preenchimento do combo de niveis */
		$template->setVariable("comboNiveisOpcoes", $niveisCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.nome.focus();";
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");	
?>