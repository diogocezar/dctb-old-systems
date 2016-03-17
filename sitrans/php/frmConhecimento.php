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

$contexto      = "conhecimento";
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

/* Gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estadoCombo .= "<option value=\"$valor\"";
	if(empty($seleciona)){
		$seleciona = $estadosPadrao;
	}
	if($valor == $seleciona){
		$estadoCombo .= "selected";
	}
	$estadoCombo .= ">$estado</option>";
}

/* gerando combo de cliente */
$cliente = $controlador['cliente'];
$cliente->__toFillGeneric();
$resultado = $cliente->_list('cliente');

$clienteComboRem .= "<option value=\"NULL\"></option>";
$clienteComboDes .= "<option value=\"NULL\"></option>";

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$clienteComboRem .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
	$clienteComboDes .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
	if($objRec->getIdclienteremetente() == $dados[$cliente->campos[0]]){
		$clienteComboRem .= "selected";
	}
	if($objRec->getIdclientedestinatario() == $dados[$cliente->campos[0]]){
		$clienteComboDes .= "selected";
	}	
	$clienteComboRem .= ">".$dados[$cliente->campos[3]]."</option>";
	$clienteComboDes .= ">".$dados[$cliente->campos[3]]."</option>";
}

/* gerando combo de status */
$status = $controlador['statusconhecimento'];
$status->__toFillGeneric();
$resultado = $status->_list();
$statusCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$statusCombo .= "<option value=\"".$dados[$status->campos[0]]."\"";
	if($dados[$status->campos[0]] == 1){
		$statusCombo .= "selected";
	}
	$statusCombo .= ">".$dados[$status->campos[1]]."</option>";
}

/* gerando combo de manifestos */
$manifesto = $controlador['manifesto'];
$manifesto->__toFillGeneric();
$resultado = $manifesto->_list();
$manifestoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$manifestoCombo .= "<option value=\"".$dados[$manifesto->campos[0]]."\"";
	$idManifesto = $objRec->getIdmanifesto();
	if($idManifesto == $dados[$manifesto->campos[0]]){
		$manifestoCombo .= "selected";
	}
	$manifestoCombo .= ">".$dados[$manifesto->campos[3]]."</option>";
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
		
	/* remetente */
			$template->setVariable("campoCnpjcpfClienteRemetente",        "cnpf_remetente");
			$template->setVariable("campoInscestadualrgClienteRemetente", "inscestadualrg_remetente");
			$template->setVariable("campoNomeClienteRemetente",           "nome_remetente");
			
			$template->setVariable("campoRuaRemetente",                   "rua_remetente");
			$template->setVariable("campoNumeroRemetente",                "numero_remetente");
			$template->setVariable("campoComplementoRemetente",           "complemento_remetente");
			$template->setVariable("campoBairroRemetente",                "bairro_remetente");
			$template->setVariable("campoCepRemetente",                   "cep_remetente");
			$template->setVariable("campoCidadeRemetente",                "cidade_remetente");
			$template->setVariable("campoEstadoRemetente",                "estado_remetente");
			$template->setVariable("campoTelefoneRemetente",              "telefone_remetente");
			$template->setVariable("campoFaxRemetente",                   "fax_remetente");
			$template->setVariable("campoEmailRemetente",                 "email_remetente");
			
			if($acao == "atualizar"){
				/* inserindo valor de cnpj ou cpf */
				$idClienteRemetente = $objRec->getIdclienteremetente();
				$cliente = $controlador['cliente'];
				$cliente->__toFillGeneric();
				$cnpjCpfClienteRemetente = $cliente->returnCnpfById($idClienteRemetente);
				$template->setVariable("valorCnpjcpfClienteRemetente", $cnpjCpfClienteRemetente);
			}
	
	/* destinatário */
	
			$template->setVariable("campoCnpjcpfClienteDestinatario",        "cnpf_destinatario");
			$template->setVariable("campoInscestadualrgClienteDestinatario", "inscestadualrg_destinatario");
			$template->setVariable("campoNomeClienteDestinatario",           "nome_destinatario");
			
			$template->setVariable("campoRuaDestinatario",                   "rua_destinatario");
			$template->setVariable("campoNumeroDestinatario",                "numero_destinatario");
			$template->setVariable("campoComplementoDestinatario",           "complemento_destinatario");
			$template->setVariable("campoBairroDestinatario",                "bairro_destinatario");
			$template->setVariable("campoCepDestinatario",                   "cep_destinatario");
			$template->setVariable("campoCidadeDestinatario",                "cidade_destinatario");
			$template->setVariable("campoEstadoDestinatario",                "estado_destinatario");
			$template->setVariable("campoTelefoneDestinatario",              "telefone_destinatario");
			$template->setVariable("campoFaxDestinatario",                   "fax_destinatario");
			$template->setVariable("campoEmailDestinatario",                 "email_destinatario");
			
			if($acao == "atualizar"){			
				/* inserindo valor de cnpj ou cpf */
				$idClienteDestinatario = $objRec->getIdclientedestinatario();
				$cliente = $controlador['cliente'];
				$cliente->__toFillGeneric();
				$cnpjCpfClienteDestinatario = $cliente->returnCnpfById($idClienteDestinatario);
				$template->setVariable("valorCnpjcpfClienteDestinatario", $cnpjCpfClienteDestinatario);
			}
			
	/* nomes dos campos */
		$template->setVariable("comboManifesto",           "manifesto");
		$template->setVariable("comboClienteRemetente",    "clienteremetente");
		$template->setVariable("comboClienteDestinatario", "clientedestinatario");
		$template->setVariable("comboStatusconhecimento",  "statusconhecimento");
		$template->setVariable("campoNumero",              "numero");
		$template->setVariable("campoDataEmissao",         "dataemissao");
		$template->setVariable("campoPeso",                "peso");
		$template->setVariable("campoVolumes",             "volumes");
		$template->setVariable("campoValorNotaFiscal",     "valornotafiscal");
		$template->setVariable("campoValorFrete",          "valorfrete");
		$template->setVariable("campoSituacao",            "situacao");
	
	/* valores dos campos */
		$template->setVariable("valorNumero",          $objRec->getNumero());
		$template->setVariable("valorPeso",            $objRec->getPeso());
		$template->setVariable("valorVolumes",         $objRec->getVolumes());
		$template->setVariable("valorValorNotaFiscal", $objRec->getValornotafiscal());
		$template->setVariable("valorValorFrete",      $objRec->getValorfrete());		
		$template->setVariable("valorSituacao",        $textoSituacao);
		
		$data = $objRec->getDataemissao();
		if(!empty($data)){
			$template->setVariable("valorDataEmissao", desconverteData($objRec->getDataemissao(), true));
		}
		else{
			$template->setVariable("valorDataEmissao", date('d/m/Y'));
		}

		
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
		
	/* preenchimento dos combos */
		$template->setVariable("comboManifestoOpcoes",           $manifestoCombo);
		$template->setVariable("comboClienteRemetenteOpcoes",    $clienteComboRem);
		$template->setVariable("comboClienteDestinatarioOpcoes", $clienteComboDes);
		$template->setVariable("campoOpcoesStatusConhecimento",  $statusCombo);
		$template->setVariable("campoOpcoesEstadoRemetente",     $estadoCombo);
		$template->setVariable("campoOpcoesEstadoDestinatario",  $estadoCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.numero.focus();";
		if($acao == "atualizar"){		
			$onLoad .= "SessionManifesto.checkSession();";
		}
		$onLoad .= "BuscaCliente.start()";
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>