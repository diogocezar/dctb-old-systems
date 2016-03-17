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

$contexto      = "pessoafisica";
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
		$objRecPessoa->__get_db($id);
		$idPessoaFisica = $objRecPessoa->getIdpessoafisica();
		$objRec->__get_db($idPessoaFisica);
		break;
}

/* Gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estadoCombo .= "<option value=\"$valor\"";
	$seleciona = $objRecPessoa->getUf();
	if(empty($inscricao['estado'])){
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
	$template->setCurrentBlock("bloco_formulario_pf");
	
		/* titulo */	
			$template->setVariable("tituloPessoaEspecifico", "Pessoa Física");	
		
		/* nomes dos campos */
			$template->setVariable("campoCpf",       "cpf");
			$template->setVariable("campoRg",        "rg");
			$template->setVariable("campoNome",      "nome");
			$template->setVariable("campoSobrenome", "sobrenome");
		
		/* valores dos campos */
			$template->setVariable("valorCpf",       $objRec->getCpf());
			$template->setVariable("valorRg",        $objRec->getRg());
			$template->setVariable("valorNome",      $objRec->getNome());
			$template->setVariable("valorSobrenome", $objRec->getSobrenome());

	$template->parseCurrentBlock("bloco_formulario_pf");

	/* bloco pessoa genérica */
	$template->setCurrentBlock("bloco_formulario_p");
	
		/* titulo */	
			$template->setVariable("tituloPessoaGenerico", "Dados da pessoa");	
		
		/* nomes dos campos */
			$template->setVariable("campoEndereco",   "endereco");
			$template->setVariable("campoBairro",     "bairro");
			$template->setVariable("campoCidade",     "cidade");
			$template->setVariable("campoUf",         "uf");
			$template->setVariable("campoCep",        "cep");
			$template->setVariable("campoFone",       "fone");
			$template->setVariable("campoFax",        "fax");
			$template->setVariable("campoSite",       "site");
			$template->setVariable("campoObservacao", "obs");
			$template->setVariable("campoSituacao",   "situacao");
		
		/* valores dos campos */
			$template->setVariable("valorEndereco",   $objRecPessoa->getEndereco());
			$template->setVariable("valorBairro",     $objRecPessoa->getBairro());
			$template->setVariable("valorCidade",     $objRecPessoa->getCidade());
			$template->setVariable("valorUf",         $objRecPessoa->getUf());
			$template->setVariable("valorCep",        $objRecPessoa->getCep());
			$template->setVariable("valorFone",       $objRecPessoa->getFone());
			$template->setVariable("valorFax",        $objRecPessoa->getFax());
			$template->setVariable("valorSite",       $objRecPessoa->getSite());
			$template->setVariable("valorObservacao", $objRecPessoa->getObs());
			$template->setVariable("valorSituacao",   $textoSituacao);
			
		/* preenchendo combo uf */
		$template->setVariable("campoOpcoesUf", $estadoCombo);

		/* preenchendo data baixa se existir */
			$dataBaixa = $objRecPessoa->getDatabaixa();
			if(!empty($dataBaixa)){
				$template->setCurrentBlock("bloco_formulario_baixa");
					$template->setVariable("campoDataBaixa", "dataBaixa");
					$template->setVariable("valorDataBaixa",  desconverteData($objRecPessoa->getDatabaixa()));
				$template->parseCurrentBlock("bloco_formulario_baixa");
			}
	
	$template->parseCurrentBlock("bloco_formulario_p");
	
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "setaFoco(document.$form.cpf);";
		$onLoad .= "\"";
		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "sifinValPessoafisica($form.cpf, $form.rg, $form.nome, $form.sobrenome, $form.endereco, $form.bairro, $form.cidade, $form.cep, $form.fone, $form.fax, $form.site, $form)");
		
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>