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

$contexto      = "acervo";
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

/* gerando combo de tipos de acervo */
$tipoAcervo = $controlador['tipoacervo'];
$tipoAcervo->__toFillGeneric();
$condicao  = $tipoAcervo->campos[4].' = 1';
$resultado = $tipoAcervo->rows(false, false, 1, 'ASC', $condicao);
$tipoAcervoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$tipoAcervoCombo .= "<option value=\"".$dados[$tipoAcervo->campos[0]]."\"";
	if($objRec->getIdTipoAcervo() == $dados[$tipoAcervo->campos[0]]){
		$tipoAcervoCombo .= "selected";
	}
	$tipoAcervoCombo .= ">".$dados[$tipoAcervo->campos[1]]."</option>";
}

/* gerando combo de autores */
$autor = $controlador['autor'];
$autor->__toFillGeneric();
$condicao  = $autor->campos[4].' = 1';
$resultado = $autor->rows(false, false, 1, 'ASC', $condicao);
$autorCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$autorCombo .= "<option value=\"".$dados[$autor->campos[0]]."\"";
	if($objRec->getIdAutor() == $dados[$autor->campos[0]]){
		$autorCombo .= "selected";
	}
	$autorCombo .= ">".$dados[$autor->campos[1]]."</option>";
}

/* gerando combo de editoras */
$editora = $controlador['editora'];
$editora->__toFillGeneric();
$condicao  = $editora->campos[4].' = 1';
$resultado = $editora->rows(false, false, 1, 'ASC', $condicao);
$editoraCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$editoraCombo .= "<option value=\"".$dados[$editora->campos[0]]."\"";
	if($objRec->getIdEditora() == $dados[$editora->campos[0]]){
		$editoraCombo .= "selected";
	}
	$editoraCombo .= ">".$dados[$editora->campos[1]]."</option>";
}

/* gerando situação */
if($objRec->getSituacao() == '1'){
	$textoSituacao = 'Ativo';
}
else{
	$textoSituacao = 'Inativo';
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
		$template->setVariable("formAcervo", $form);
		$template->setVariable("actionAcervo", $contextoArray['action']);
	
		/* nomes dos campos */
			$template->setVariable("campoNumero",     "numero");
			$template->setVariable("campoVolume",     "volume");
			$template->setVariable("campoTipoAcervo", "tipoacervo");
			$template->setVariable("campoTitulo",     "titulo");
			$template->setVariable("campoAutor",      "autor");
			$template->setVariable("campoEditora",    "editora");
			$template->setVariable("campoQtdVolumes", "qtdvolumes");
			$template->setVariable("campoStatus",     "status");
			$template->setVariable("campoSituacao",   "situacao");

		if($acao == 'atualizar'){
			/* valores dos campos */
				$template->setVariable("valorNumero",      $objRec->getNumero());
				$template->setVariable("valorVolume",      $objRec->getVolume());
				$template->setVariable("valorTitulo",      $objRec->getTitulo());
				$template->setVariable("valorAutor",       $objRec->getAutor());
				$template->setVariable("valorEditora",     $objRec->getEditora());
				$template->setVariable("valorQtdVolumes",  $objRec->getQtdVolumes());
				
				if($objRec->getStatus() == "LOCADO"){
					$template->setVariable("selLocad", "selected=\"selected\"");
				}
				else{
					$template->setVariable("selDispo", "selected=\"selected\"");
				}
		}
		
		$template->setVariable("valorSituacao",       trim($textoSituacao));
			
		/* preenchendo data baixa e dada cadastro se existir */
			$dataBaixa    = $objRec->getDatabaixa();
			$dataCadastro = $objRec->getDatacadastro();
			if(!empty($dataBaixa)){
				$template->setCurrentBlock("bloco_formulario_data_baixa");
					$template->setVariable("campoDataBaixa", "dataBaixa");
					$template->setVariable("valorDataBaixa",  desconverteData($dataBaixa, false));
				$template->parseCurrentBlock("bloco_formulario_data_baixa");
			}
			if(!empty($dataCadastro)){
				$template->setCurrentBlock("bloco_formulario_data_cadastro");
					$template->setVariable("campoDataCadastro", "dataCadastro");
					$template->setVariable("valorDataCadastro",  desconverteData($dataCadastro, false));
				$template->parseCurrentBlock("bloco_formulario_data_cadastro");
			}
			
		/* preenchendo combo estados */
		$template->setVariable("campoOpcoesTipoAcervo", $tipoAcervoCombo);
		$template->setVariable("campoOpcoesAutor",      $autorCombo);
		$template->setVariable("campoOpcoesEditora",    $editoraCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.titulo.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>