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

$contexto      = "locacao";
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

/* gerando combo de usuarios */
$usuario = $controlador['usuario'];
$usuario->__toFillGeneric();
$resultado = $usuario->_list();
$usuarioCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$usuarioCombo .= "<option value=\"".$dados[$usuario->campos[0]]."\"";
	if($objRec->getIdUsuario() == $dados[$usuario->campos[0]]){
		$usuarioCombo .= "selected";
	}
	$usuarioCombo .= ">".$dados[$usuario->campos[1]]."</option>";
}

/* gerando combo de acervos */
$acervo = $controlador['acervo'];
$acervo->__toFillGeneric();
$resultado = $acervo->_list();
$acervoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$acervoCombo .= "<option value=\"".$dados[$acervo->campos[0]]."\"";
	$acervoCombo .= ">".$dados[$acervo->campos[6]]." vol. ".$dados[$acervo->campos[5]]."</option>";
}

/* gerando situação */
if($objRec->getSituacao() == '1'){
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
		$template->setVariable("formLocacao", $form);
		$template->setVariable("actionLocacao", $contextoArray['action']);
	
		/* nomes dos campos */
			$template->setVariable("campoUsuaio",        "usuario");
			$template->setVariable("campoAcervos",       "acervos");
			$template->setVariable("campoListaAcervos",  "lista_acervos");
			$template->setVariable("campoDataLocacao",   "data_locacao");
			$template->setVariable("campoDataDevolucao", "data_devolucao");
			$template->setVariable("campoStatus",        "status");
		
		if($acao == 'atualizar'){
			/* valores dos campos */
				if($objRec->getStatus() == "FECHADO"){
					$template->setVariable("selFechado", "selected=\"selected\"");
				}
				else{
					$template->setVariable("selAberto", "selected=\"selected\"");
				}
		}
			
		$template->setVariable("valorSituacao", trim($textoSituacao));
		
		$dataLocacao   = $objRec->getDataLocacao();
		$dataDevolucao = $objRec->getDataDevolucao();
		
		if(!empty($dataLocacao)){
			$template->setVariable("valorDataLocacao", desconverteData($dataLocacao, true));
		}
		else{
			$template->setVariable("valorDataLocacao", date('d/m/Y'));
		}
		
		if(!empty($dataDevolucao)){
			$template->setVariable("valorDataDevolucao", desconverteData($dataDevolucao, true));
		}
		
		$arrayAcervos = array();
			
		/* recuperando acervos cadastrados */
		if($acao == "atualizar"){
			$objAcervo = $controlador['acervo'];
			$objAcervo->__toFillGeneric();
			
			$objAcervoLocacao = $controlador['acervolocacao'];
			$objAcervoLocacao->__toFillGeneric();
			
			$arrayAcervos = $objAcervoLocacao->getAcer($id);

			$resultado = $objAcervo->_listWithFil($arrayAcervos);
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaAcervosCombo .= "<option value=\"".$dados[$objAcervo->campos[0]]."\"";
				$listaAcervosCombo .= ">".$dados[$objAcervo->campos[6]]." vol. ".$dados[$acervo->campos[5]]."</option>";
			}			
		}
			
		/* preenchendo data baixa e dada cadastro se existir */
			$dataBaixa     = $objRec->getDataBaixa();
			$dataCadastro  = $objRec->getDataCadastro();
			$dataDevolvido = $objRec->getDataDevolvido();
			if(!empty($dataBaixa)){
				$template->setCurrentBlock("bloco_formulario_data_baixa");
					$template->setVariable("campoDataBaixa", "dataBaixa");
					$template->setVariable("valorDataBaixa",  desconverteData($dataBaixa, false));
				$template->parseCurrentBlock("bloco_formulario_data_baixa");
			}
			if(!empty($dataCadastro)){
				$template->setCurrentBlock("bloco_formulario_data_cadastro");
					$template->setVariable("campoDataCadastro", "dataCadastro");
					$template->setVariable("valorDataCadastro",  desconverteData($dataCadastro, false));
				$template->parseCurrentBlock("bloco_formulario_data_cadastro");
			}
			if(!empty($dataDevolvido)){
				$template->setCurrentBlock("bloco_formulario_data_devolvido");
					$template->setVariable("campoDataDevolvido", "dataDevolvido");
					$template->setVariable("valorDataDevolvido",  desconverteData($dataDevolvido, true));
				$template->parseCurrentBlock("bloco_formulario_data_devolvido");
			}			
		/* preenchendo combo estados */
		$template->setVariable("campoOpcoesUsuario",      $usuarioCombo);
		$template->setVariable("campoOpcoesAcervo",       $acervoCombo);
		$template->setVariable("campoOpcoesListaAcervo",  $listaAcervosCombo);
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.usuario.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>