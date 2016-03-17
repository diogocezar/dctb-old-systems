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

$contexto      = "cliente";
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

/* gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estadoCombo .= "<option value=\"$valor\"";
	$seleciona = $objRec->getEstado();
	if(empty($seleciona)){
		$seleciona = $estadosPadrao;
	}
	if($valor == $seleciona){
		$estadoCombo .= "selected";
	}
	$estadoCombo .= ">$estado</option>";
}

/* gerando combo de grupos de usuário */
$grupo = $controlador['grupo'];
$grupo->__toFillGeneric();
$condicao  = $grupo->campos[4].' = TRUE';
$resultado = $grupo->rows(false, false, 1, 'ASC', $condicao);
$grupoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$grupoCombo .= "<option value=\"".$dados[$grupo->campos[0]]."\"";
	if($objRec->getIdgrupo() == $dados[$grupo->campos[0]]){
		$grupoCombo .= "selected";
	}
	$grupoCombo .= ">".$dados[$grupo->campos[1]]."</option>";
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
		$template->setVariable("formCliente", $form);
		$template->setVariable("actionCliente", $contextoArray['action']);
	
		/* nomes dos campos */
			$template->setVariable("campoGrupo",            "grupo");
			$template->setVariable("campoNome",             "nome");
			$template->setVariable("campoDatanascimento",   "datanascimento");
			$template->setVariable("campoBairro",           "bairro");
			$template->setVariable("campoCidade",           "cidade");
			$template->setVariable("campoEndereco",         "endereco");
			$template->setVariable("campoCep",              "cep");
			$template->setVariable("campoEstado",           "estado");
			$template->setVariable("campoTelefone1",        "telefone1");
			$template->setVariable("campoTelefone2",        "telefone2");
			$template->setVariable("campoCelular",          "celular");
			$template->setVariable("campoNumbeneficio",     "numbeneficio");
			$template->setVariable("campoNit",              "nit");
			$template->setVariable("campoObservacao",       "observacao");
			$template->setVariable("campoSituacao",         "situacao");
		
		if($acao == 'atualizar'){
		/* valores dos campos */
			$template->setVariable("valorNome",           trim($objRec->getNome()));
			$template->setVariable("valorDatanascimento", desconverteData($objRec->getDatanascimento(),true));
			$template->setVariable("valorBairro",         trim($objRec->getBairro()));
			$template->setVariable("valorCidade",         trim($objRec->getCidade()));
			$template->setVariable("valorEndereco",       trim($objRec->getEndereco()));
			$template->setVariable("valorCep",            trim($objRec->getCep()));
			$template->setVariable("valorEstado",         trim($objRec->getEstado()));
			$template->setVariable("valorTelefone1",      trim($objRec->getTelefone1()));
			$template->setVariable("valorTelefone2",      trim($objRec->getTelefone2()));
			$template->setVariable("valorCelular",        trim($objRec->getCelular()));
			$template->setVariable("valorNumbeneficio",   trim($objRec->getNumbeneficio()));
			$template->setVariable("valorNit",            trim($objRec->getNit()));
			$template->setVariable("valorObservacao",     $objRec->getObservacao());
			$template->setVariable("valorBairro",         trim($objRec->getBairro()));
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
			
		/* colocando botão imprimir */
		if($acao == 'atualizar'){
			$template->setCurrentBlock("onClickImprimir");
				$id = $objRec->getId();
				$template->setVariable("onClickImprimir", "tb_show('Informe os documentos :', 'frmFormPrintCliente.php?id=$id&acao=adicionar&opcao=documentos&height=170&width=695;', '');");
			$template->parseCurrentBlock("onClickImprimir");
		}
			
		/* preenchendo combo estados */
		$template->setVariable("campoOpcoesEstado", $estadoCombo);
		$template->setVariable("campoOpcoesGrupo", $grupoCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.nome.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>