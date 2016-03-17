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
* include funções ajax
*/
include("../ajax/ajax.php");

/**
* incluindo controle de sessão
*/
include("../php/controlaSession.php");

/* extraindo variaveis do navegador */
$acao   = $_GET['acao'];
$id     = $_GET['id'];
$versao = $_GET['versao'];

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

$contexto      = "manifesto";
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

$passouCliente = false;

/* gerando combo de fornecedores */
$fornecedor = $controlador['fornecedor'];
$fornecedor->__toFillGeneric();
$resultado = $fornecedor->_list('fornecedor');
$fornecedorCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$fornecedorCombo .= "<option value=\"".$dados[$fornecedor->campos[0]]."\"";
	if($objRec->getIdfornecedor() == $dados[$fornecedor->campos[0]]){
		$fornecedorCombo .= "selected";
	}
	$fornecedorCombo .= ">".$dados[$fornecedor->campos[4]]."</option>";
}

/* gerando combo de status */
$status = $controlador['statusmanifesto'];
$status->__toFillGeneric();
$resultado = $status->_list();
$statusCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$statusCombo .= "<option value=\"".$dados[$status->campos[0]]."\"";
	if($objRec->getIdstatus() == $dados[$status->campos[0]]){
		$statusCombo .= "selected";
	}
	$statusCombo .= ">".$dados[$status->campos[1]]."</option>";
}

/* gerando situação */
if($objRec->getSituacao() == 't'){
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
		$template->setVariable("form".ucfirst($contexto), $form);
		$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
	
	/* titulos */
		$template->setVariable("titulo".ucfirst($contexto), $contextoArray['titulo']);
		
	/* nomes dos campos */
		$template->setVariable("campoCidade",          "cidade");
		$template->setVariable("campoNumero",          "numero");
		$template->setVariable("campoHoraChegada",     "horachegada");
		$template->setVariable("campoTotalCTRC",       "totalctrc");
		$template->setVariable("campoTotalVolumes",    "totalvolumes");
		$template->setVariable("campoTotalPeso",       "totalpeso");
		$template->setVariable("campoValorTotalNF",    "valortotalnf");
		$template->setVariable("campoValorTotalFrete", "valortotalfrete");
		
	/* combos */
		$template->setVariable("campoFornecedor",      "fornecedor");
		$template->setVariable("campoStatusmanifesto", "statusmanifesto");

	/* valores dos campos */
		$template->setVariable("valorCidade",          $objRec->getCidade());
		$template->setVariable("valorNumero",          $objRec->getNumero());
		$template->setVariable("valorTotalCTRC",       $objRec->getTotalctrc());
		$template->setVariable("valorTotalVolumes",    $objRec->getTotalvolumes());
		$template->setVariable("valorTotalPeso",       $objRec->getTotalpeso());
		$template->setVariable("valorValorTotalNF",    $objRec->getValortotalnf());
		$template->setVariable("valorValorTotalFrete", $objRec->getValortotalfrete());
		$template->setVariable("valorSituacao",        $textoSituacao);
		
		$data = $objRec->getData();
		$horachegada = $objRec->getHora();
		
		if(!empty($data)){
			$template->setVariable("valorData", desconverteData($objRec->getData(), true));
		}
		else{
			$template->setVariable("valorData", date('d/m/Y'));
		}
		
		if(!empty($horachegada)){
			$template->setVariable("valorHoraChegada", $objRec->getHora());
		}
		else{
			$template->setVariable("valorHoraChegada", date('G:i'));
		}
		
	/* preenchendo versão, data baixa, data cadastro e atendente se existir */
		$dataBaixa    = $objRec->getDatabaixa();
		$dataCadastro = $objRec->getDatacadastro();
		$codigo       = $objRec->getCodigo();

		if(!empty($codigo)){
			$template->setCurrentBlock("bloco_formulario_codigo");
				$template->setVariable("campoCodigo", "codigo");
				$template->setVariable("valorCodigo",  $codigo);
			$template->parseCurrentBlock("bloco_formulario_codigo");
		}
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
	
	/* preenchimento do combo de pessoas */
		$template->setVariable("campoOpcoesFornecedor",      $fornecedorCombo);
		$template->setVariable("campoOpcoesStatusManifesto", $statusCombo);
						
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.fornecedor.focus();";
		if(!empty($codigo)){
			$onLoad .= "StatusManifesto.getStatusManifesto();";
			$onLoad .= "StatusManifesto.verificaItens();";
		}
		else{
			$onLoad .= "StatusManifesto.selectAberto();";
		}
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

include("../php/includeInterna.php");	
?>