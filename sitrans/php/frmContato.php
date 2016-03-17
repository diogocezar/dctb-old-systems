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

$contexto      = "contato";
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

$passouFornecedor = false;
$passouCliente    = false;
$passouAgregado   = false;

/* gerando combo de fornecedores */
$fornecedor = $controlador['fornecedor'];
$fornecedor->__toFillGeneric();
$resultado = $fornecedor->_list();
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$fornecedorCombo .= "<option value=\"".$dados[$fornecedor->campos[1]]."\"";
	if($objRec->getIdpessoa() == $dados[$fornecedor->campos[1]]){
		$fornecedorCombo .= "selected";
		$passouFornecedor = true;
	}
	$fornecedorCombo .= ">".$dados[$fornecedor->campos[4]]."</option>";
}

/* gerando combo de clientes */
$cliente = $controlador['cliente'];
$cliente->__toFillGeneric();
$resultado = $cliente->_list();
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$clienteCombo .= "<option value=\"".$dados[$cliente->campos[1]]."\"";
	if($objRec->getIdpessoa() == $dados[$cliente->campos[1]]){
		$clienteCombo .= "selected";
		$passouCliente = true;
	}
	$clienteCombo .= ">".$dados[$cliente->campos[3]]."</option>";
}

/* gerando combo de agregados */
$agregado = $controlador['agregado'];
$agregado->__toFillGeneric();
$resultado = $agregado->_list();
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$agregadoCombo .= "<option value=\"".$dados[$agregado->campos[1]]."\"";
	if($objRec->getIdpessoa() == $dados[$agregado->campos[1]]){
		$agregadoCombo .= "selected";
		$passouAgregado = true;
	}
	$agregadoCombo .= ">".$dados[$agregado->campos[2]]."</option>";
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
		$template->setVariable("campoNome",      "nome");
		$template->setVariable("campoFuncao",    "funcao");
		$template->setVariable("campoTelefone",  "telefone");
		$template->setVariable("campoCelular",   "celular");
		$template->setVariable("campoRamal",     "ramal");
		$template->setVariable("campoEmail",     "email");
		$template->setVariable("campoSituacao",  "situacao");
		
	/* radio */		
		$template->setVariable("opPessoa", "pessoa");
		$template->setVariable("valorOpFornecedor", "pessoa_fornecedor");
		$template->setVariable("valorOpCliente",    "pessoa_cliente");
		$template->setVariable("valorOpAgregado",   "pessoa_agregado");
		
	/* combos */
		$template->setVariable("campoFornecedor", "fornecedor");
		$template->setVariable("campoCliente",    "cliente");
		$template->setVariable("campoAgregado",   "agregado");
	
	/* valores dos campos */
		$template->setVariable("valorNome",     $objRec->getNome());
		$template->setVariable("valorFuncao",   $objRec->getFuncao());
		$template->setVariable("valorTelefone", $objRec->getTelefone());
		$template->setVariable("valorCelular",  $objRec->getCelular());
		$template->setVariable("valorRamal",    $objRec->getRamal());
		$template->setVariable("valorEmail",    $objRec->getEmail());
		$template->setVariable("valorSituacao", $textoSituacao);
		
	/* preenchendo login e senha */
		$loginContato = $objRec->getLogin();
		$senhaContato = $objRec->getSenha();
		if(!empty($loginContato) && !empty($senhaContato)){
			$template->setVariable("campoLogin", "login_cliente");
			$template->setVariable("campoSenha", "senha_cliente");
		
			$template->setVariable("valorLogin", $loginContato);
			$template->setVariable("valorSenha", $senhaContato);
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
		
	/* preenchimento do combo de pessoas */
		$template->setVariable("campoOpcoesFornecedor", $fornecedorCombo);
		$template->setVariable("campoOpcoesCliente",    $clienteCombo);
		$template->setVariable("campoOpcoesAgregado",   $agregadoCombo);

	/* java script radios */
		$template->setVariable("onClickFornecedor", "clickRadio(form_contato.pessoa, 'pessoa_fornecedor')");
		$template->setVariable("onClickCliente",    "clickRadio(form_contato.pessoa, 'pessoa_cliente')");
		$template->setVariable("onClickAgregado",   "clickRadio(form_contato.pessoa, 'pessoa_agregado')");
		
	/* java script para selecionar a pessoa */
		$onLoad .= "onLoad = \"";
		if($acao == 'atualizar'){
			if($passouFornecedor == true){
				$onLoad .= "clickRadio(document.form_contato.pessoa, 'pessoa_fornecedor');";
			}
			if($passouCliente == true){
				$onLoad .= "clickRadio(document.form_contato.pessoa, 'pessoa_cliente');";
			}
			if($passouAgregado == true){
				$onLoad .= "clickRadio(document.form_contato.pessoa, 'pessoa_agregado');";
			}
			$template->setVariable("onClickFornecedor", "");
			$template->setVariable("onClickCliente",    "");
			$template->setVariable("onClickAgregado",   "");
		}
		
	/* foco no campo inicial */
		$onLoad .= "document.$form.nome.focus();";
		$onLoad .= "\"";
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>