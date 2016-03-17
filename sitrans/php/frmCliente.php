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

$contexto      = "cliente";
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

/* gerando combo das frequencias de coleta */
$frequenciaColeta = $controlador['frequenciacoleta'];
$frequenciaColeta->__toFillGeneric();
$condicao  = $frequenciaColeta->campos[5].' = TRUE';
$resultado = $frequenciaColeta->rows(false, false, 1, 'ASC', $condicao);
$idFc      = $objRec->getIdfrequenciacoleta();
$fcCombo  .= "<option value=\"NULL\"";
if(empty($idFc)){
	$fcCombo .= "selected";
}
$fcCombo .= "></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$fcCombo .= "<option value=\"".$dados[$frequenciaColeta->campos[0]]."\"";
	if($idFc == $dados[$frequenciaColeta->campos[0]]){
		$fcCombo .= "selected";
	}
	$fcCombo .= ">".$dados[$frequenciaColeta->campos[1]]."</option>";
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
	$template->setCurrentBlock("bloco_formulario_cliente");
	
		/* titulo */	
			$template->setVariable("tituloPessoaEspecifico", "Cliente");	

		/* nomes dos campos */
			$template->setVariable("campoFrequenciaColetaCliente", "frequenciacoleta");
			$template->setVariable("campoNomeCliente",             "nome");
			$template->setVariable("campoCnpjcpfCliente",          "cnpjcpf");
			$template->setVariable("campoInscestadualrgCliente",   "inscestadualrg");
			$template->setVariable("campoSituacaoCliente",        "situacao");
		
		/* valores dos campos */
			$template->setVariable("valorNomeCliente",           $objRec->getNome());
			$template->setVariable("valorCnpjcpfCliente",        $objRec->getCnpjcpf());
			$template->setVariable("valorInscestadualrgCliente", $objRec->getInscestadualrg());
			$template->setVariable("valorSituacaoCliente",       $textoSituacao);
			
		/* preenchendo combo frequencia de coleta */
		$template->setVariable("campoOpcoesFrequenciaColetaCliente", $fcCombo);
			
		/* preenchendo data baixa e dada cadastro se existir */
			$dataBaixa    = $objRec->getDatabaixa();
			$dataCadastro = $objRec->getDatacadastro();
			if(!empty($dataBaixa)){
				$template->setVariable("campoDataBaixaCliente", "dataBaixa");
				$template->setVariable("valorDataBaixaCliente",  desconverteData($dataBaixa));
			}
			if(!empty($dataCadastro)){
				$template->setVariable("campoDataCadastroCliente", "dataCadastro");
				$template->setVariable("valorDataCadastroCliente",  desconverteData($dataCadastro));
			}

	$template->parseCurrentBlock("bloco_formulario_cliente");

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