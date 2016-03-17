<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/HTML_BBCodeParser/BBCodeParser.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'detalhes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$tipo = $_GET['tipo'];
$id   = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
	exit();
}

switch($tipo){
	case 'fabricante':
		$sql       = "SELECT fab_nome, fab_telefone, fab_website FROM {$tabela['fabricantes']} WHERE fab_cod = $id";
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$conteudo  = "<div align=\"center\">";
		$conteudo  = "<b>Fabricante:</b> ".$dados['fab_nome']."<br><br>";
		$conteudo .= "<b>Telefone:</b> ".$dados['fab_telefone']."<br><br>";
		$conteudo .= "<b>Web Site:</b><br><a href=\"{$dados['fab_website']}\" class=\"link_claro\" target=\"_blank\">".$dados['fab_website']."</a>";
		$conteudo .= "</div>";
		$titulo    = "Detalhes do Fabricante";
		$tituloDetalhes = "Descrição do Fabricante:";
	break;
	
	case 'categoria':
		$sql       = "SELECT cat_nome, cat_descricao FROM {$tabela['categorias']} WHERE cat_cod = $id";
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		
		/* Opções do BBCode */
		
		$options = array('quotestyle'    => 'double',
						 'quotewhat'     => 'all',
						 'open'          => '[',
						 'close'         => ']',
						 'xmlclose'      => true,
						 'filters'       => 'Basic'
						 );
						 
		$parser = new HTML_BBCodeParser($options);		
		$parser->setText($dados['cat_descricao']);		
		$parser->parse();
		
		$conteudo  = "<div align=\"justify\">";
		$conteudo .= "<b>Categoria:</b> ".$dados['cat_nome']."<br><br>";
		$conteudo .= "<b>Descrição:</b> ".$parser->getParsed();
		$conteudo .= "</div>";
		$titulo    = "Detalhes da Categoria";
		$tituloDetalhes = "Descrição da Categoria:";
	break;
}

$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", $titulo);
$template->parseCurrentBlock("bloco_titulo");

$template->setCurrentBlock("bloco_detalhes");
	$template->setVariable("tituloDetalhes", $tituloDetalhes);
	$template->setVariable("conteudo", $conteudo);
$template->parseCurrentBlock("bloco_detalhes");

$template->show();
?>