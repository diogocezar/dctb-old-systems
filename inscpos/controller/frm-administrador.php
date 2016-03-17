<?php
include("start-brain.php");
include("session-control.php");

/* extraindo variaveis do navegador */
$acao = $_GET['action'];
$id   = $_GET['id'];

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

$contexto      = "administrador";
$contextoArray = array();

$objRec = $brain_controller[$contexto];
$objRec->__toFillGeneric();

switch($acao){
	case 'add':
		$contextoArray['action'] = "register.php?tipo=$contexto&acao=$acao";
		$contextoArray['titulo'] = "Inserir registro: ".ucfirst($contexto);
		break;
		
	case 'update':
		$contextoArray['action'] = "register.php?tipo=$contexto&acao=$acao&id=$id";
		$contextoArray['titulo'] = "Atualizar registro: ".ucfirst($contexto);
		
		/* recuperando dados */
		$objRec->__get_db($id);
		break;
}

/* gerando combo de cursos */
$curso = $brain_controller['curso'];
$curso->__toFillGeneric();
$resultado = $curso->rows(false, false, 1, 'ASC', false);
$cursoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$cursoCombo .= "<option value=\"".$dados[$curso->campos[0]]."\"";
	if($objRec->getIdcurso() == $dados[$curso->campos[0]]){
		$cursoCombo .= "selected";
	}
	$cursoCombo .= ">".$dados[$curso->campos[1]]."</option>";
}

/* gerando situação */
if($objRec->getSituacao() == '1'){
	$textoSituacao = 'Ativo';
}
else{
	$textoSituacao = 'Inativo';
}

/* diretório dos templates */
$templateHtmlDir = '../view/html';

$templateHtmlName = "frm-".$contexto.".html";

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
		$template->setVariable("campoNome",     "nome_adm");
		$template->setVariable("campoLogin",    "login_adm");
		$template->setVariable("campoSenha",    "senha_adm");
		$template->setVariable("campoEmail",    "email_adm");
		$template->setVariable("campoCurso",    "curso_adm");		
		$template->setVariable("campoSituacao", "situacao_adm");
		
	/* valores dos campos */
		$template->setVariable("valorNome",     $objRec->getNome());
		$template->setVariable("valorLogin",    $objRec->getLogin());
		$template->setVariable("valorSenha",    $objRec->getSenha());
		$template->setVariable("valorEmail",    $objRec->getEmail());
		$template->setVariable("valorSituacao", $textoSituacao);
		
	/* preenchendo combo estados */
		$template->setVariable("campoOpcoesCurso", $cursoCombo);
		
	/* preenchendo data baixa e dada cadastro se existir */
		$dataBaixa    = $objRec->getDataBaixa();
		$dataCadastro = $objRec->getDataCadastro();
		if(!empty($dataBaixa)){
			$template->setCurrentBlock("bloco_formulario_data_baixa");
				$template->setVariable("campoDataBaixa", "data_baixa");
				$template->setVariable("valorDataBaixa",  desconverteData($dataBaixa));
			$template->parseCurrentBlock("bloco_formulario_data_baixa");
		}
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.nome.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$content = $template->get();

$title   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include('inside-include.php');
?>