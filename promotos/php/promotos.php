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

$templateHtmlName = 'aPromotos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Promotos */
$template->setCurrentBlock("bloco_promotos");
	$template->setVariable("fotoHistorico", "histórico");
	$template->setVariable("textoInstitucional", HISTORICO);
$template->parseCurrentBlock("bloco_promotos");

/* Bloco Lojas */
$sql = "SELECT l.loj_descricao, l.loj_foto_url, l.loj_endereco, l.loj_telefone, l.loj_email, l.loj_contatos, l.loj_titulo, l.loj_cod
        FROM {$tabela['lojas']} l";

$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_lojas");
		$template->setVariable("tituloLoja", $dados['loj_titulo']);
		$descricao = $dados['loj_descricao'];
		$endereco  = $dados['loj_endereco'];
		$telefone  = $dados['loj_telefone'];
		$email     = "<a href =\"mailto:{$dados['loj_email']}\" class=\"link_vermelho\">{$dados['loj_email']}</a>";
		$contatos  = $dados['loj_contatos'];
		$replace   = $descricao."<br>";
		$replace  .= "<br>".$endereco."<br><br>";
		$replace  .= "Fone / Fax <br> <b>$telefone</b><br><br>";
		if(!empty($dados['loj_email'])){
			$replace .= "E-mail: <b>$email</b><br><br>";
		}
		if(!empty($dados['loj_gerente'])){
			$replace .= "Contatos: <b>$contatos</b><br>";
		}
		$template->setVariable("descricaoLoja", $replace);
		$template->setVariable("fotoLoja", "<img src=\"img.php?loc=".$dados['loj_foto_url']."&l=200&a=150&s=nao\" align=\"absmiddle\" border=\"0\">");
		$template->setVariable("idLoja", "loja_{$dados['loj_cod']}");
	$template->parseCurrentBlock("bloco_lojas");
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