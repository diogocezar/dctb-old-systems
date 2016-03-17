<link href="../pikture/css/cssPikture.css" rel="stylesheet" type="text/css">
<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'dicas.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_dicas");
	$template->setVariable("fotoDicas", "Dicas");
	$template->setVariable("textoDicas", DICAS);
$template->parseCurrentBlock("bloco_dicas");

/* Bloco Dicas */
$sql = "SELECT d.dic_titulo, d.dic_descricao, d.dic_cod
        FROM {$tabela['dicas']} d";

$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_dicas_item");
		$template->setVariable("titulo", $dados['dic_titulo']);
		$template->setVariable("descricao", $dados['dic_descricao']);
		$template->setVariable("idDica", "dica_".$dados['dic_cod']);
	$template->parseCurrentBlock("bloco_dicas_item");
}

$show = $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Título */
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