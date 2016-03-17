<link href="../pikture/css/cssPikture.css" rel="stylesheet" type="text/css">
<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'servicos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_servicos");
	$template->setVariable("fotoServico", "Servicos");
	$template->setVariable("textoServicos", SERVICOS);
$template->parseCurrentBlock("bloco_servicos");

/* Bloco Dicas */
$sql = "SELECT s.ser_titulo, s.ser_descricao, s.ser_cod
        FROM {$tabela['servicos']} s";

$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_servicos_itens");
		$template->setVariable("titulo", $dados['ser_titulo']);
		$template->setVariable("descricao", $dados['ser_descricao']);
		$template->setVariable("idServico", "servico_".$dados['ser_cod']);
	$template->parseCurrentBlock("bloco_servicos_itens");
}

$show = $template->get();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* Bloco Menu */
$template->setCurrentBlock("bloco_menu");
	$i = 0;
	foreach($menu as $replace => $link){
		$template->setVariable($replace, $link);
	}
$template->parseCurrentBlock("bloco_menu");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("conteudoInterno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>