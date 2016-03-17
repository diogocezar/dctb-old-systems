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

$contexto      = "agenda";
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

/* gerando combo de tipos de agendamento */
$tipo = $controlador['tipo'];
$tipo->__toFillGeneric();
$condicao  = $tipo->campos[4].' = TRUE';
$resultado = $tipo->rows(false, false, 1, 'ASC', $condicao);
$tipoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$tipoCombo .= "<option value=\"".$dados[$tipo->campos[0]]."\"";
	if($objRec->getIdtipo() == $dados[$tipo->campos[0]]){
		$tipoCombo .= "selected";
	}
	$tipoCombo .= ">".$dados[$tipo->campos[1]]."</option>";
}

/* gerando combo de clientes */
$cliente = $controlador['cliente'];
$cliente->__toFillGeneric();
$resultado = $cliente->_list();
$clienteCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$clienteCombo .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
	if($objRec->getIdcliente() == $dados[$cliente->campos[0]]){
		$clienteCombo .= "selected";
	}
	$clienteCombo .= ">".$dados[$cliente->campos[3]]."</option>";
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
		$template->setVariable("formAgenda", $form);
		$template->setVariable("actionAgenda", $contextoArray['action']);
	
		/* nomes dos campos */
			$template->setVariable("campoTipo",            "tipo");
			$template->setVariable("campoCliente",         "cliente");
			$template->setVariable("campoDatasolicitacao", "datasolicitacao");
			$template->setVariable("campoDataagendada",    "dataagendada");
			$template->setVariable("campoHoraagendada",    "horaagendada");
			$template->setVariable("campoDescricao",       "descricao");
			$template->setVariable("campoSituacao",        "situacao");
		
		if($acao == 'atualizar'){
		/* valores dos campos */
			$template->setVariable("valorDatasolicitacao", desconverteData($objRec->getDatasolicitacao(),true));
			$template->setVariable("valorDataagenda",      desconverteData($objRec->getDataagenda(), true));
			$template->setVariable("valorHoraagenda",      $objRec->getHoraagenda());
			$template->setVariable("valorDescricao",       $objRec->getDescricao());
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
		$template->setVariable("campoOpcoesTipo", $tipoCombo);
		$template->setVariable("campoOpcoesCliente", $clienteCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.tipo.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>