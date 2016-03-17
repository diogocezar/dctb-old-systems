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

$contexto      = "conta";
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

/* gerando combo de tipo de documento */
$tipoDocumento = $controlador['tipodocumento'];
$tipoDocumento->__toFillGeneric();
$condicao  = $tipoDocumento->campos[2].' = TRUE';
$resultado = $tipoDocumento->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$tdCombo .= "<option value=\"".$dados[$tipoDocumento->campos[0]]."\"";
	if($objRec->getIdtipodocumento() == $dados[$tipoDocumento->campos[0]]){
		$tdCombo .= "selected";
	}
	$tdCombo .= ">".$dados[$tipoDocumento->campos[1]]."</option>";
}

/* gerando combo de periodicidade */
$periodicidade = $controlador['periodicidade'];
$periodicidade->__toFillGeneric();
$condicao  = $periodicidade->campos[4].' = TRUE';
$resultado = $periodicidade->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$peCombo .= "<option value=\"".$dados[$periodicidade->campos[0]]."\"";
	if($objRec->getIdtipodocumento() == $dados[$periodicidade->campos[0]]){
		$peCombo .= "selected";
	}
	$peCombo .= ">".$dados[$periodicidade->campos[1]]."</option>";
}

/* gerando combo dos bancos */
$banco = $controlador['banco'];
$banco->__toFillGeneric();
$condicao  = $banco->campos[2].' = TRUE';
$resultado = $banco->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$baCombo .= "<option value=\"".$dados[$banco->campos[0]]."\"";
	if($objRec->getIdtipodocumento() == $dados[$banco->campos[0]]){
		$baCombo .= "selected";
	}
	$baCombo .= ">".$dados[$banco->campos[1]]."</option>";
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
		$template->setVariable("campoDocumento",           "documento");
		$template->setVariable("campoDescricao",           "descricao");
		$template->setVariable("campoNumparcelas",         "numeroparcelas");
		$template->setVariable("campoValortotal",          "valortotal");
		$template->setVariable("campoPrimeirovencimento",  "primeirovencimento");
		$template->setVariable("campoTipoconta",           "tipoconta");
		$template->setVariable("campoSituacao",            "situacao");
		
	/* radio */		
		$template->setVariable("opPessoa", "pessoa");
		$template->setVariable("valorOpPessoaFisica",   "pessoa_fisica");
		$template->setVariable("valorOpPessoaJuridica", "pessoa_juridica");
		
	/* combos */
		$template->setVariable("campoPessoaFisica",   "comboPessoaFisica");
		$template->setVariable("campoPessoaJuridica", "comboPessoaJuridica");
		$template->setVariable("campoTipodocumento",  "comboTipodocumento");
		$template->setVariable("campoPeriodicidade",  "comboPeriodicidade");
		$template->setVariable("campoBanco",          "comboBanco");
	
	/* valores dos campos */
		$template->setVariable("valorDocumento",          $objRec->getDocumento());
		$template->setVariable("valorDescricao",          $objRec->getDescricao());
		$template->setVariable("valorNumparcelas",        $objRec->getNumparcelas());
		$template->setVariable("valorValortotal",         formataDinheiro($objRec->getValortotal()));
		$template->setVariable("valorPrimeirovencimento", date('d/m/Y'));
		$template->setVariable("valorTipoconta",          $objRec->getTipoconta());
		$template->setVariable("valorSituacao",           $textoSituacao);
		
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
		$template->setVariable("campoOpcoesTipodocumento",  $tdCombo);
		$template->setVariable("campoOpcoesPeriodicidade",  $peCombo);
		$template->setVariable("campoOpcoesBanco",          $baCombo);
		
	/* java script radios */
		$template->setVariable("onClickPessoaJuridica", "clickRadio(form_conta.pessoa, 'pessoa_juridica')");
		$template->setVariable("onClickPessoaFisica",   "clickRadio(form_conta.pessoa, 'pessoa_fisica')");
		
	/* java script gerar parcelas */
		$template->setVariable("onClickGerar", "clickGerar(form_conta.numeroparcelas, form_conta.valortotal, form_conta.comboPeriodicidade, form_conta.primeirovencimento, form_conta)");
		$onLoad .= "onLoad = \"";
		if($acao == 'atualizar'){
			$conta = $id;
			$onLoad .= "call_getParcelasFromDB('$conta');";
		}
		
	/* java script para selecionar a pessoa */
		if($acao == 'atualizar'){
			if($passouPf == true){
				$onLoad .= "clickRadio(document.form_conta.pessoa, 'pessoa_fisica');";
			}
			if($passouPj == true){
				$onLoad .= "clickRadio(document.form_conta.pessoa, 'pessoa_juridica');";
			}
		}
		
	/* foco no campo inicial */
		$onLoad .= "setaFoco(document.$form.documento);";
		$onLoad .= "\"";
		
	/* java script ajax */
		$template->setVariable("js_sajax", sajax_show_javascript());
				
	/* java script ao enviar */
		$template->setVariable("onClickEnviar", "sifinValConta($form.documento, $form.descricao,  $form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>