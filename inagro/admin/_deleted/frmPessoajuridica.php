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
include("../admin/controlaSession.php");

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

$contexto      = "pessoajuridica";
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
		$idPessoaJuridica = $objRecPessoa->getIdpessoajuridica();
		$objRec->__get_db($idPessoaJuridica);
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
		
	/* bloco pessoa juridica */
	$template->setCurrentBlock("bloco_formulario_pj");
	
		/* titulo */	
			$template->setVariable("tituloPessoaEspecifico", "Pessoa Jurídica");	
		
		/* nomes dos campos */
			$template->setVariable("campoCnpj",          "cnpj");
			$template->setVariable("campoInscEstadual",  "inscricaoestadual");
			$template->setVariable("campoInscMunicipal", "inscricaomunicipal");
			$template->setVariable("campoRazaoSocial",   "razaosocial");
			$template->setVariable("campoNomeFantasia",  "nomefantasia");
		
		/* valores dos campos */
			$template->setVariable("valorCnpj",          $objRec->getCnpj());
			$template->setVariable("valorInscEstadual",  $objRec->getInscricaoestadual());
			$template->setVariable("valorInscMunicipal", $objRec->getInscricaomunicipal());
			$template->setVariable("valorRazaoSocial",   $objRec->getRazaosocial());
			$template->setVariable("valorNomeFantasia",  $objRec->getNomefantasia());

	$template->parseCurrentBlock("bloco_formulario_pj");

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
			$template->setVariable("campoCompramin",  "compramin");
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
			
		/* preenchendo compraminima */
			$template->setCurrentBlock("bloco_formulario_compra_minima");
				$template->setVariable("campoCompramin",  "compramin");
				$template->setVariable("valorCompramin",  $objRecPessoa->getCompraminima());
			$template->parseCurrentBlock("bloco_formulario_compra_minima");
	
	$template->parseCurrentBlock("bloco_formulario_p");
	
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "setaFoco(document.$form.cnpj);";
		$onLoad .= "\"";
				
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "sifinValPessoajuridica($form.cnpj, $form.inscricaoestadual, $form.inscricaomunicipal, $form.razaosocial, $form.nomefantasia, $form.compramin, $form.endereco, $form.bairro, $form.cidade, $form.cep, $form.fone, $form.fax, $form.site, $form)");
		
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../admin/includeInterna.php");	
?>