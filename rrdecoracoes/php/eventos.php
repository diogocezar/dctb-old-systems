<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo sAjax */
include('../classes/sAjax/Sajax.php');

/* Pikture */
include('../classes/Pikture.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

$getOp  = $_GET['folder'];
$getPag = $_GET['page'];
$getPagSess = $_GET['pages'];

if(empty($getPag)){
	$getPag = 0;
}

$ini = new IniFile("../pikture/config/gerais.ini");
$gerais = $ini->getIni(false);

$diretorio     = $gerais['diretorio'];
$colunas       = $gerais['colunas'];
$fotosPP       = $gerais['fotosPorPagina'];
$iconePastinha = $gerais['iconePastinha'];
$iconePrimeiro = $gerais['iconePrimeiro'];
$iconeProximo  = $gerais['iconeProximo'];
$iconeAnterior = $gerais['iconeAnterior'];
$iconeUltimo   = $gerais['iconeUltimo'];
$iconeVoltar   = $gerais['iconeVoltar'];
$scalar        = $gerais['fotoEscalar'];
$imprimeNome   = $gerais['imprimirNome'];
$imprimeTam    = $gerais['imprimirTamanho'];
$colunasCapa   = $gerais['colunasCapa'];
$galerias      = $gerais['galerias'];

$paginaAtual   = getPaginaAtual();

$pikture = new Pikture($diretorio, $fotosPP, $colunas);
$pikture->countDir();
$total = $pikture->qtdSessoes;

/* Funções executadas pelo sAjax */
function getGaleria($pagina){
	global $diretorio;
	global $fotosPP;
	global $colunas;
	global $paginaAtual;
	global $iconePastinha;
	global $colunasCapa;
	global $galerias;
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	$pikture->countDir();
	$total = $pikture->qtdSessoes;
	if($total > $galerias){
		$de    = ($pagina-1)*$galerias;
		$ate   = ($de+$galerias)-1;
		$show  = $pikture->printFolders($paginaAtual, 'folder', $iconePastinha, $colunasCapa, $de, $ate);
	}
	else{
		$show  = $pikture->printFolders($paginaAtual, 'folder', $iconePastinha, $colunasCapa);
	}
	return $show;
}

/* Configurando o sAjax */

sajax_init();

$sajax_debug_mode = 0;

sajax_export("getGaleria");

sajax_handle_client_request();

/* Bloco JavaScript sAjax */

$funcaoJs  = "function executado(retorno){
			      document.getElementById('galerias').innerHTML = retorno;
              }";

$funcaoJs .= "function getGaleria(opcao){
			     if(opcao == 'inicial'){
				    x_getGaleria(pag, executado);
				 }
				 else{
				    if(opcao == 'proximo'){
					   pag++;
					   passou = 'proximo';
					}
					if(opcao == 'anterior'){
					   pag--;
					   passou = 'anterior';
					}
					
				    if(pag >= 1 && pag <= paginas){
			           x_getGaleria(pag, executado);
				    }
					else{
						if(passou == 'proximo'){
						   pag--;
						}
						if(passou == 'anterior'){
						   pag++;
						}						
					}
			     }
              }";

$pagControl  = "var pag = 1;";
$pagControl .= "var total = $total;";
$pagControl .= "var galerias = $galerias;";
$pagControl .= "var paginas = Math.ceil(total/galerias);";
$pagControl .= "getGaleria('inicial');";

if(!empty($getOp)){
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';	
	$templateHtmlName = 'galeria.html';	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);

	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	$show   .= $pikture->showPhotos($getOp, $getPag, $scalar, $imprimeNome, $imprimeTam);
	$pikture->countDir();
	$show   .= $pikture->printPaging($getPag, $paginaAtual, $iconePrimeiro, $iconeAnterior, $iconeProximo, $iconeUltimo); 
	
	/* Bloco galeria */
	$template->setCurrentBlock("bloco_galeria");
		$template->setVariable("titulo", $pikture->folder);
		$template->setVariable("conteudo", $show);
	$template->parseCurrentBlock("bloco_galeria");
}
else{
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';	
	$templateHtmlName = 'eventos.html';
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco Java Scrip */
	$template->setCurrentBlock("java_script");
		$template->setVariable("sajax_javascript", sajax_show_javascript());
		$template->setVariable("funcoes_javascript", $funcaoJs);
		$template->setVariable("pagecontrol_javascript", $pagControl);
	$template->parseCurrentBlock("java_script");
	
	/* Bloco Eventos */
	$template->setCurrentBlock("bloco_eventos");
		$template->setVariable("urlIframe", "../html/galeriaSelecione.html");
	$template->parseCurrentBlock("bloco_eventos");
}

$template->show();
?>