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

if(empty($opCliente)){
	/**
	* incluindo controle de nível
	*/
	include("../php/controlaNivel.php");
}

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

$contexto      = "coleta";
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
		$contextoArray['action'] = "registra.php?tipo=$contexto&acao=$acao&id=$id&versao=$versao";
		$contextoArray['titulo'] = "Atualizar registro: ".ucfirst($nome);
		
		/* recuperando dados */
		$objRec->__get_dbColeta($id, $versao);
		break;
}

if(!empty($opCliente)){
	$contextoArray['action'] .= "&tcliente=sim";
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

/* gerando combo de clientes */
if(!empty($opCliente)){
	$cliente = $controlador['cliente'];
	$cliente->__toFillGeneric();
	$resultado = $cliente->_list('cliente');
	$clienteCombo .= "<option value=\"NULL\"></option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$clienteCombo .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
		
		if($_SESSION['sessIdEmpresa'] == $dados[$cliente->campos[0]]){
			$clienteCombo .= "selected";
			$passouCliente = true;
		}
		$clienteCombo .= ">".$dados[$cliente->campos[3]]."</option>";
	}
}
else{
	$cliente = $controlador['cliente'];
	$cliente->__toFillGeneric();
	$resultado = $cliente->_list('cliente');
	$clienteCombo .= "<option value=\"NULL\"></option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$clienteCombo .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
		if($objRec->getIdcliente() == $dados[$cliente->campos[0]]){
			$clienteCombo .= "selected";
			$passouCliente = true;
		}
		$clienteCombo .= ">".$dados[$cliente->campos[3]]." - ".$dados['telefone']."</option>";
	}
}

/* gerando o combo de contatos */
if(!empty($opCliente)){
	$contato = $controlador['contato'];
	$contato->__toFillGeneric();
	$resultado = $contato->_list();
	$contatoCombo .= "<option value=\"NULL\"></option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$contatoCombo .= "<option value=\"".$dados[$contato->campos[0]]."\"";
		
		if($_SESSION['sessIdContato'] == $dados[$contato->campos[0]]){
			$contatoCombo .= "selected";
		}
		$contatoCombo .= ">".$dados[$contato->campos[2]]."</option>";
	}
}

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

/* gerando combo de status */
$status = $controlador['status'];
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

/* gerando combo de embalagens */
$embalagem = $controlador['embalagem'];
$embalagem->__toFillGeneric();
$resultado = $embalagem->_list();
$embalagemCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$embalagemCombo .= "<option value=\"".$dados[$embalagem->campos[0]]."\"";
	if($objRec->getIdembalagem() == $dados[$embalagem->campos[0]]){
		$embalagemCombo .= "selected";
	}
	$embalagemCombo .= ">".$dados[$embalagem->campos[1]]."</option>";
}

/* gerando combo de restrições */
$restricao = $controlador['restricao'];
$restricao->__toFillGeneric();
$resultado = $restricao->_list();
$restricaoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$restricaoCombo .= "<option value=\"".$dados[$restricao->campos[0]]."\"";
	if($objRec->getIdembalagem() == $dados[$restricao->campos[0]]){
		$restricaoCombo .= "selected";
	}
	$restricaoCombo .= ">".$dados[$restricao->campos[1]]."</option>";
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

if(!empty($opCliente)){
	$templateHtmlDir = '../html/cliente';	
}

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
		$template->setVariable("campoQtdadeNotaFiscal", "qtdadeNotaFiscal");
		$template->setVariable("campoQtdadeVolumes",    "qtdadeVolumes");
		$template->setVariable("campoData",             "data");
		$template->setVariable("campoHora",             "hora");
		$template->setVariable("campoPeso",             "peso");
		$template->setVariable("campoObservacao",       "obsColeta");
		
	/* combos */
		$template->setVariable("campoCliente",    "cliente");
		$template->setVariable("campoFornecedor", "fornecedor");
		$template->setVariable("campoMotivo",     "motivo");
		$template->setVariable("campoEmbalagem",  "embalagem");
		$template->setVariable("campoRestricao",  "restricao");

	/* valores dos campos */
		$template->setVariable("valorQtdadeNotaFisca", $objRec->getQtdadenotafiscal());
		$template->setVariable("valorQtdadeVolumes",   $objRec->getQtdadevolumes());
		$template->setVariable("valorPeso",            $objRec->getPeso());
		$template->setVariable("valorObservacao",      $objRec->getObscoleta());
		$template->setVariable("valorSituacao",        $textoSituacao);
		
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
		$versao       = $objRec->getVersao();
		$codigo       = $objRec->getCodigo();
		$idusuario    = $objRec->getIdusuario();
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
		if(!empty($versao)){
			$template->setCurrentBlock("bloco_formulario_versao");
				$template->setVariable("campoVersao", "versao");
				$template->setVariable("valorVersao",  $versao);
			$template->parseCurrentBlock("bloco_formulario_versao");
		}
		if(!empty($idusuario)){
			$usuario      = $controlador['usuario'];
			$usuario->__toFillGeneric();
			$usuario->__get_db($idusuario);
			$nomeUsuario = $usuario->getNome();
			$template->setCurrentBlock("bloco_formulario_usuario");
				$template->setVariable("campoAtendente", "atendente");
				$template->setVariable("valorAtendente",  $nomeUsuario);
			$template->parseCurrentBlock("bloco_formulario_usuario");
		}
		
	/* preenchendo status e veículo dependendo do nível */
	
		if($nivel['permissao']['veiculo']){
			$template->setCurrentBlock("bloco_formulario_veiculo");
				$template->setVariable("campoVeiculo", "veiculo");
				$template->setVariable("campoOpcoesVeiculo", $veiculoCombo);
			$template->parseCurrentBlock("bloco_formulario_veiculo");
		}
		
		if($nivel['permissao']['status']){
			$template->setCurrentBlock("bloco_formulario_status");
				$template->setVariable("campoStatus", "status");
				$template->setVariable("campoOpcoesStatus", $statusCombo);
			$template->parseCurrentBlock("bloco_formulario_status");
		}
	
	/* preenchimento do combo de pessoas */
		$template->setVariable("campoOpcoesFornecedor", $fornecedorCombo);
		$template->setVariable("campoOpcoesCliente",    $clienteCombo);
		$template->setVariable("campoOpcoesEmbalagem",  $embalagemCombo);
		$template->setVariable("campoOpcoesRestricao",  $restricaoCombo);
		if(!empty($opCliente)){
			$template->setVariable("campoOpcoesContato",  $contatoCombo);
		}
		
	/* preenchendo informações adicionais */
	if($acao == 'atualizar'){
		$idcontato = $objRec->getIdcontato();
		$idcliente = $objRec->getIdcliente();
		
		$cliente = $controlador['cliente'];
		$cliente->__toFillGeneric();
		$cliente->__get_db($idcliente);
		
		$contato = $controlador['contato'];
		$contato->__toFillGeneric();
		$contato->__get_db($idcontato);		
		
		$idpessoa = $cliente->getIdpessoa();
		$pessoaCliente = $controlador['pessoa'];
		$pessoaCliente->__toFillGeneric();
		$pessoaCliente->__get_db($idpessoa);
		
		$template->setCurrentBlock("bloco_infos_adicionais");
			$template->setVariable("cnpf", $cliente->getCnpjcpf());
			$template->setVariable("nome", $cliente->getNome());
			$template->setVariable("endereco", $pessoaCliente->getRua().' '.$pessoaCliente->getNumero());
			$template->setVariable("bairro", $pessoaCliente->getBairro());
			$template->setVariable("cidade", $pessoaCliente->getCidade());
			$template->setVariable("fone", $contato->getTelefone());
		$template->parseCurrentBlock("bloco_infos_adicionais");		
	}
		
	/* java script para selecionar a pessoa */
		$onLoad .= "onLoad = \"";
		if($acao == 'atualizar'){
			if($passouCliente == true && empty($opCliente)){
				$onLoad .= "jQuery(document).ready(Contacts.getContacts);";
			}
		}
		
	/* foco no campo inicial */
		$onLoad .= "document.$form.cliente.focus();";
	
	/* verificando se jah existe coleta para o cliente na data */	
	if(!empty($opCliente)){
		$onLoad .= "CheckColeta.getCheckColeta();";
	}
			
	if(empty($opCliente)){		
		/* carregando o mapa */
			if($acao == 'atualizar'){
				$template->setCurrentBlock("bloco_mapa");	
					$template->setVariable("idmapa", "mapag");			
				$template->parseCurrentBlock("bloco_mapa");	
				$onLoad .= "load();try{marcaPonto(A,'A','".$cliente->getNome()."','".$pessoaCliente->getRua()." ".$pessoaCliente->getNumero()."','".$pessoaCliente->getCidade()." - ".$pessoaCliente->getEstado()."');}catch(E){}";
			}
			
		/* fechando onLoad */
			$onLoad .= "\"  onunload=\"javascript:GUnload();";
	}

	$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo  = $template->get();

$titulo    = $contextoArray['titulo'];

$exiteAjax = true;

if(!empty($opCliente)){
	/* incluindo conteudo na página interna específica para cliente*/
	include("../php/includeInternaCliente.php");	
}
else{
	/* incluindo conteudo na página interna */
	include("../php/includeInterna.php");	
}
?>