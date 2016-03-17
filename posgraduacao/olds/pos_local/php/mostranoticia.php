<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Identificação do curso */
$id = $_GET['id'];

/* Extraindo id do curso atual */
$idCurso = sessionNum($_SESSION['curso']);

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

$sql = "SELECT not_cod, not_titulo, not_conteudo, not_quando, adm_cod, cur_cod FROM {$tabela['noticias']} WHERE not_cod = $id";
		
$resultado  = $dataBase->query($sql);
$dados      = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
$idCurso    = $dados['cur_cod']; 
$autor      = retornaNomeAdm($dados['adm_cod']);
$quando     = extraiData($dados['not_quando']).', '.extraiHora($dados['not_quando']);
$titulo     = $dados['not_titulo'];
$descricao  = "<br>";
$descricao .= "<div align=\"left\"><span class=\"titulo\">$titulo</span></div><br><br>"; 
$descricao .= "<div align=\"justify\"><span class=\"letra_noticia\">".$dados['not_conteudo']."</span></div>";
$descricao .= "<br>";
$descricao .= "<div align=\"right\">";
$descricao .= $quando.' por <b>'.$autor.'</b>';
$descricao .= "</div>";
$descricao .= "<br><br><div align=\"center\"><input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\"></div><br><br>";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$idCurso]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Notícia completa");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $descricao);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['interno'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$link = str_replace('#', "?id=$idCurso", $link);
			$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>