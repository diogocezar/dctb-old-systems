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

$contexto      = "veiculo";
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

/* gerando combo de categoria */
$categoria = $controlador['categoria'];
$categoria->__toFillGeneric();
$condicao  = $categoria->campos[4].' = TRUE';
$resultado = $categoria->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$categoriaCombo .= "<option value=\"".$dados[$categoria->campos[0]]."\"";
	if($objRec->getIdcategodia() == $dados[$categoria->campos[0]]){
		$categoriaCombo .= "selected";
	}
	$categoriaCombo .= ">".$dados[$categoria->campos[1]]."</option>";
}

/* gerando combo de agregado */
$agregado = $controlador['agregado'];
$agregado->__toFillGeneric();
$condicao  = $agregado->campos[7].' = TRUE';
$resultado = $agregado->rows(false, false, 1, 'ASC', $condicao);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$agregadoCombo .= "<option value=\"".$dados[$agregado->campos[0]]."\"";
	if($objRec->getIdagregado() == $dados[$agregado->campos[0]]){
		$agregadoCombo .= "selected";
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
		$template->setVariable("comboCategoria", "categoria");
		$template->setVariable("comboAgregado",  "agregado");
		$template->setVariable("campoPlaca",     "placa");
		$template->setVariable("campoMarca",     "marca");
		$template->setVariable("campoModelo",    "modelo");
		$template->setVariable("campoPrefixo",   "prefixo");
		$template->setVariable("campoSituacao",  "situacao");
	
	/* valores dos campos */
		$template->setVariable("valorPlaca",        $objRec->getPlaca());
		$template->setVariable("valorMarca",        $objRec->getMarca());
		$template->setVariable("valorModelo",       $objRec->getModelo());
		$template->setVariable("valorPrefixo",      $objRec->getPrefixo());
		$template->setVariable("valorSituacao",     $textoSituacao);
		
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
		$template->setVariable("comboCategoriaOpcoes", $categoriaCombo);
		$template->setVariable("comboAgregadoOpcoes", $agregadoCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.placa.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>