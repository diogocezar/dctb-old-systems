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

$contexto      = "baixaconhecimento";
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

/* gerando combo de veículos */
$conhecimento = $controlador['conhecimento'];
$conhecimento->__toFillGeneric();
$resultado = $conhecimento->_list();
$conhecimentoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$conhecimentoCombo .= "<option value=\"".$dados[$conhecimento->campos[0]]."\"";
	if($objRec->getIdconhecimento() == $dados[$conhecimento->campos[0]]){
		$conhecimentoCombo .= "selected";
	}
	$conhecimentoCombo .= ">".$dados[$conhecimento->campos[2]]."</option>";
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
		$template->setVariable("campoData", "data");
		$template->setVariable("campoHora", "hora");
		$template->setVariable("campoNome", "nome");
		
	/* valores dos campos */
		$template->setVariable("valorSituacao", $textoSituacao);
		$template->setVariable("valorNome", $objRec->getNome());

	/* combos */
		$template->setVariable("campoConhecimento", "conhecimento");
		
		$data = $objRec->getData();
		$hora = $objRec->getHora();
		
		if(!empty($data)){
			$template->setVariable("valorData", desconverteData($objRec->getData(), true));
		}
		else{
			$template->setVariable("valorData", date('d/m/Y'));
		}
		
		if(!empty($hora)){
			$template->setVariable("valorHora", $objRec->getHora());
		}
		else{
			$template->setVariable("valorHora", date('G:i'));
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
		$template->setVariable("campoOpcoesConhecimento", $conhecimentoCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.conhecimento.focus();";
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

include("../php/includeInterna.php");	
?>