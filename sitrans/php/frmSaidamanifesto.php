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

$contexto      = "saidamanifesto";
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
$veiculo = $controlador['veiculo'];
$veiculo->__toFillGeneric();
$resultado = $veiculo->_list();
$veiculoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$veiculoCombo .= "<option value=\"".$dados[$veiculo->campos[0]]."\"";
	if($objRec->getIdveiculo() == $dados[$veiculo->campos[0]]){
		$veiculoCombo .= "selected";
	}
	$veiculoCombo .= ">".$dados[$veiculo->campos[3]]." - ".$dados['nome']."</option>";
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
		
	/* valores dos campos */
		$template->setVariable("valorSituacao", $textoSituacao);

	/* combos */
		$template->setVariable("campoVeiculo", "veiculo");
		
		$data = $objRec->getData();
		$hora = $objRec->getHora();
		
		if(!empty($data)){
			$template->setVariable("valorData", desconverteData($objRec->getData(), true));
		}
		else{
			$template->setVariable("valorData", date('d/m/Y'));
		}
		
		if(!empty($hora)){
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
		$template->setVariable("campoOpcoesVeiculo", $veiculoCombo);
		
	$arrayConhecimentos = array();
		
	/* recuperando conhecimentos cadastrados */
	if($acao == "atualizar"){
		$objEntrega = $controlador['entregas'];
		$objEntrega->__toFillGeneric();
		
		$arrayConhecimentos = $objEntrega->getCon($id);
	}
		
	/* preenchendo os conhecimentos */
	$conhecimentos = $controlador['conhecimento'];
	$conhecimentos->__toFillGeneric();
	$resultado = $conhecimentos->getListOutMan($arrayConhecimentos);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$endereco = "";
		$endereco .= $dados['rua'].", ".$dados['numero'];
		if(!empty($dados['complemento'])){ $endereco .= " - ".$dados['complemento']; }
		
		$template->setCurrentBlock("bloco_selecionar_conhecimentos_items");
			if(in_array($dados['idconhecimento'], $arrayConhecimentos)){
				$template->setVariable("ativo", "checked=\"checked\"");
			}
			else{
				$template->setVariable("ativo", "");
			}
			$template->setVariable("i", $dados['numconhecimento']);
			$template->setVariable("valorConhecimento", $dados['idconhecimento']);
			$template->setVariable("numConhecimento", $dados['numconhecimento']);
			$template->setVariable("destinatario", $dados['nome']);
			$template->setVariable("endereco", $endereco);
			$template->setVariable("cidade", $dados['cidade']);
			
			$template->setVariable("fornecedor", $dados['razaosocial']);
			$template->setVariable("bairro", $dados['bairro']);
			$template->setVariable("volumes", $dados['volumes']);
			$template->setVariable("peso", $dados['peso']);
			$template->setVariable("nf", formataDinheiro($dados['valornotafiscal']));
			$template->setVariable("frete", formataDinheiro($dados['valorfrete']));
			
		$template->parseCurrentBlock("bloco_selecionar_conhecimentos_items");
	}
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.veiculo.focus();";
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

include("../php/includeInterna.php");	
?>