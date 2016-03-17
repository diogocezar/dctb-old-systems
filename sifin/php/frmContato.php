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

$passouPf = false;
$passouPj = false;

/* gerando combo de pessoas físicas */
$pessoaFisica = $controlador['pessoafisica'];
$pessoaFisica->__toFillGeneric();
$resultado = $pessoaFisica->listPf();
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$pfCombo .= "<option value=\"".$dados[$camposMap['pessoa'][0]]."\"";
	if($objRec->getIdpessoa() == $dados[$camposMap['pessoa'][0]]){
		$pfCombo .= "selected";
		$passouPf = true;
	}
	$pfCombo .= ">".$dados[$pessoaFisica->campos[3]]." ".$dados[$pessoaFisica->campos[4]]."</option>";
}

/* gerando combo de pessoas jurídicas */
$pessoaJuridica = $controlador['pessoajuridica'];
$pessoaJuridica->__toFillGeneric();
$resultado = $pessoaJuridica->listPj();
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$pjCombo .= "<option value=\"".$dados[$camposMap['pessoa'][0]]."\"";
	if($objRec->getIdpessoa() == $dados[$camposMap['pessoa'][0]]){
		$pjCombo .= "selected";
		$passouPj = true;
	}
	$pjCombo .= ">".$dados[$pessoaJuridica->campos[4]].' ('.$dados[$pessoaJuridica->campos[5]].')'."</option>";
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
		$template->setVariable("campoNome",         "nome");
		$template->setVariable("campoEmail",        "email");
		$template->setVariable("campoMsn",          "msn");
		$template->setVariable("campoSkype",        "skype");
		$template->setVariable("campoFone",         "fone");
		$template->setVariable("campoFax",          "fax");
		$template->setVariable("campoCelular",      "celular");
		$template->setVariable("campoRamal",        "ramal");
		$template->setVariable("campoDepartamento", "departamento");
		$template->setVariable("campoSituacao",     "situacao");
		
	/* radio */		
		$template->setVariable("opPessoa", "pessoa");
		$template->setVariable("valorOpPessoaFisica",   "pessoa_fisica");
		$template->setVariable("valorOpPessoaJuridica", "pessoa_juridica");
		
	/* combos */
		$template->setVariable("campoPessoaFisica",   "comboPessoaFisica");
		$template->setVariable("campoPessoaJuridica", "comboPessoaJuridica");
	
	/* valores dos campos */
		$template->setVariable("valorNome",         $objRec->getNome());
		$template->setVariable("valorEmail",        $objRec->getEmail());
		$template->setVariable("valorMsn",          $objRec->getMsn());
		$template->setVariable("valorSkype",        $objRec->getSkype());
		$template->setVariable("valorFone",         $objRec->getFone());
		$template->setVariable("valorFax",          $objRec->getFax());
		$template->setVariable("valorCelular",      $objRec->getCelular());
		$template->setVariable("valorRamal",        $objRec->getRamal());
		$template->setVariable("valorDepartamento", $objRec->getDepartamento());
		$template->setVariable("valorSituacao",     $textoSituacao);
		
	/* preenchendo data baixa se existir */
		$dataBaixa = $objRec->getDatabaixa();
		if(!empty($dataBaixa)){
			$template->setCurrentBlock("bloco_formulario_baixa");
				$template->setVariable("campoDataBaixa", "dataBaixa");
				$template->setVariable("valorDataBaixa",  desconverteData($objRec->getDatabaixa()));
			$template->parseCurrentBlock("bloco_formulario_baixa");
		}
		
	/* preenchimento do combo de pessoas */
		$template->setVariable("campoOpcoesPessoaFisica",   $pfCombo);
		$template->setVariable("campoOpcoesPessoaJuridica", $pjCombo);

	/* java script radios */
		$template->setVariable("onClickPessoaJuridica", "clickRadio(form_contato.pessoa, 'pessoa_juridica')");
		$template->setVariable("onClickPessoaFisica",   "clickRadio(form_contato.pessoa, 'pessoa_fisica')");
		
	/* java script para selecionar a pessoa */
		$onLoad .= "onLoad = \"";
		if($acao == 'atualizar'){
			if($passouPf == true){
				$onLoad .= "clickRadio(document.form_contato.pessoa, 'pessoa_fisica');";
			}
			if($passouPj == true){
				$onLoad .= "clickRadio(document.form_contato.pessoa, 'pessoa_juridica');";
			}
		}
		
	/* foco no campo inicial */
		$onLoad .= "setaFoco(document.$form.nome);";
		$onLoad .= "\"";
		
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "sifinValContato($form.nome, $form.email, $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>