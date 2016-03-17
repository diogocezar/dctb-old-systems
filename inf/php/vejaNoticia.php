<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');
/* Verificando se o id está vazio */

$id = anti_sql_injection($_GET['id']);
//echo $id;
if(empty($id)){
	echo "<script language=javascript>alert('Selecione uma notícia para ver seus detalhes !');location.href='index.php'</script>";
	exit();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'mostraNoticia.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Selecionando notícia */

$sql = "SELECT n.tituloNo, n.descricaoNo, n.imagemNo, date_format(n.dataHoraNo, '%d/%m/%Y') as data, a.nomeAd, a.emailAd 
        FROM {$tabela['noticias']} n, {$tabela['administradores']} a
		WHERE n.Administrador_idAdministrador = a.idAdministradores AND
		      n.idNoticias = $id";
//echo $sql;
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
}

$template->setCurrentBlock("blk_mostra_noticia");
	$template->setVariable("tituloDaNoticia", $dados['tituloNo']);
	$template->setVariable("data", $dados['data']);
	if(!empty($dados['imagemNo'])){
		$template->setCurrentBlock("blk_mostra_noticia_img");
			$alt = $altura['not'];
			$lar = $largura['not'];
			$sca = $scalar['not'];
			$template->setVariable("img", "<img src=\"img.php?loc={$dados['imagemNo']}&a=$alt&l=$lar&s=$sca\" border=\"0\">");	
		$template->parseCurrentBlock("blk_mostra_noticia_img");	
	}
	$template->setVariable("descricao", $dados['descricaoNo']);	
	$template->setVariable("enviadoPor", $dados['nomeAd']);	
	$template->setVariable("linkEnviadoPor", "mailto:{$dados['emailAd']}");	
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_mostra_noticia");

$conteudo = $template->get();
$tituloInterna = "Notícias";

include("includeInterna.php");
?>