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

/**
* incluindo controle de ajax
*/
include("../ajax/ajax.php");

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

$contexto      = "agregado";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();

$objRecPessoa = $controlador['pessoa'];
$objRecPessoa->__toFillGeneric();

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
		$idPessoa = $objRec->getIdpessoa();
		$objRecPessoa->__get_db($idPessoa);
		break;
}

/* Gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estadoCombo .= "<option value=\"$valor\"";
	$seleciona = $objRecPessoa->getEstado();
	if(empty($seleciona)){
		$seleciona = $estadosPadrao;
	}
	if($valor == $seleciona){
		$estadoCombo .= "selected";
	}
	$estadoCombo .= ">$estado</option>";
}

/* gerando situação */
if($objRecPessoa->getSituacao() == 't'){
	$textoSituacao = 'Ativo';
}
else{
	$textoSituacao = 'Inativo';
}

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frmPessoa.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_pessoa";
		$template->setVariable("formPessoa", $form);
		$template->setVariable("actionPessoa", $contextoArray['action']);
	
	/* titulos */
		
	/* bloco pessoa fisica */
	$template->setCurrentBlock("bloco_formulario_agregado");
	
		/* titulo */	
			$template->setVariable("tituloPessoaEspecifico", "Agregado");	

		/* nomes dos campos */
			$template->setVariable("campoNomeAgregado",           "nome");
			$template->setVariable("campoCnpjcpfAgregado",        "cnpjcpf");
			$template->setVariable("campoInscestadualrgAgregado", "inscestadualrg");
			$template->setVariable("campoSituacaoAgregado",       "situacao");
		
		/* valores dos campos */
			$template->setVariable("valorNomeAgregado",           $objRec->getNome());
			$template->setVariable("valorCnpjcpfAgregado",        $objRec->getCnpjcpf());
			$template->setVariable("valorInscestadualrgAgregado", $objRec->getInscestadualrg());
			$template->setVariable("valorSituacaoAgregado",       $textoSituacao);
			
		/* preenchendo data baixa e dada cadastro se existir */
			$dataBaixa    = $objRec->getDatabaixa();
			$dataCadastro = $objRec->getDatacadastro();
			if(!empty($dataBaixa)){
				$template->setVariable("campoDataBaixaAgregado", "dataBaixa");
				$template->setVariable("valorDataBaixaAgregado",  desconverteData($dataBaixa));
			}
			if(!empty($dataCadastro)){
				$template->setVariable("campoDataCadastroAgregado", "dataCadastro");
				$template->setVariable("valorDataCadastroAgregado",  desconverteData($dataCadastro));
			}

	$template->parseCurrentBlock("bloco_formulario_agregado");

	/* bloco pessoa genérica */
	$template->setCurrentBlock("bloco_formulario_pessoa");
	
		/* titulo */	
			$template->setVariable("tituloPessoaGenerico", "Dados da pessoa");	

		/* nomes dos campos */
			$template->setVariable("campoRua",         "rua");
			$template->setVariable("campoNumero",      "numero");
			$template->setVariable("campoComplemento", "complemento");
			$template->setVariable("campoBairro",      "bairro");
			$template->setVariable("campoCep",         "cep");
			$template->setVariable("campoCidade",      "cidade");
			$template->setVariable("campoEstado",      "estado");
			$template->setVariable("campoTelefone",    "telefone");
			$template->setVariable("campoFax",         "fax");
			$template->setVariable("campoEmail",       "email");
		
		/* valores dos campos */
			$template->setVariable("valorRua",         $objRecPessoa->getRua());
			$template->setVariable("valorNumero",      $objRecPessoa->getNumero());
			$template->setVariable("valorComplemento", $objRecPessoa->getComplemento());
			$template->setVariable("valorBairro",      $objRecPessoa->getBairro());
			$template->setVariable("valorCep",         $objRecPessoa->getCep());
			$template->setVariable("valorCidade",      $objRecPessoa->getCidade());
			$template->setVariable("valorTelefone",    $objRecPessoa->getTelefone());
			$template->setVariable("valorFax",         trim($objRecPessoa->getFax()));
			$template->setVariable("valorEmail",       $objRecPessoa->getEmail());
			
		/* nome */
			$template->setVariable("nome", "Nome fantasia");
			
		/* preenchendo combo estados */
		$template->setVariable("campoOpcoesEstado", $estadoCombo);
		
		/* preenchendo data baixa se existir */
			$dataBaixa = $objRecPessoa->getDatabaixa();
			if(!empty($dataBaixa)){
				$template->setCurrentBlock("bloco_formulario_baixa");
					$template->setVariable("campoDataBaixa", "dataBaixa");
					$template->setVariable("valorDataBaixa",  desconverteData($objRecPessoa->getDatabaixa()));
				$template->parseCurrentBlock("bloco_formulario_baixa");
			}
	
	$template->parseCurrentBlock("bloco_formulario_pessoa");
	
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