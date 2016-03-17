<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Incluindo ajax */
include('../classes/sAjax/Sajax.php');
include('../ajax/ajax.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'index.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

//$template->setVariable("js_sajax", sajax_show_javascript());
//$template->setVariable("on_load", "call_getLista()");

/* Bloco Título */
$template->setCurrentBlock("blk_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("blk_titulo");

/* Destaque */
$template->setVariable("destaque", DESTAQUE);

/* Bloco Top */
$template->setCurrentBlock("blk_top");
	/* Menu */
	$i = 1;
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menu, $titulo);
			$template->setVariable("linkMenu$i", $link);
			$i++;
		}
	}
	
$template->parseCurrentBlock("blk_top");

/* Bloco Links */
$template->setCurrentBlock("blk_links");
	
	$sql = "SELECT * FROM {$tabela['links']} LIMIT 4";
	$resultado = $dataBase->query($sql);	
	
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setCurrentBlock("blk_link_item");
				$template->setVariable("tituloLink", strip_tags(limitaStr($dados['nomeLi'],LIMITE_TITULO_NOTICIA)));
				//$template->setVariable("descricaoLink", strip_tags(limitaStr($dados['descricaoLi'], LIMITE_DESCRICAO_NOTICIA)));
				$template->setVariable("linkLink", "goLink.php?id=".$dados['idLinks']);
				//$template->setVariable("numAcessos", $dados['visitasLi']);
			$template->parseCurrentBlock("blk_link_item");
		}
	}
	$template->setVariable("vejaTodosLinks", "Veja todos os links");
	$template->setVariable("linkVejaTodosLinks", "links.php");
$template->parseCurrentBlock("blk_links");

/* Bloco Notícias */
$template->setCurrentBlock("blk_noticias");
	
	$sql = "SELECT idNoticias, tituloNo, descricaoNo FROM {$tabela['noticias']} ORDER BY dataHoraNo DESC LIMIT 4";
	$resultado = $dataBase->query($sql);	
	
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setCurrentBlock("blk_noticias_item");
				$template->setVariable("tituloNoticia", strip_tags(limitaStr($dados['tituloNo'],LIMITE_TITULO_NOTICIA)));
				$template->setVariable("descricaoNoticia", strip_tags(limitaStr($dados['descricaoNo'], LIMITE_DESCRICAO_NOTICIA)));
				$template->setVariable("linkNoticia", "vejaNoticia.php?id=".$dados['idNoticias']);
			$template->parseCurrentBlock("blk_noticias_item");
		}
	}
	$template->setVariable("vejaTodasNoticias", "Veja todas as notícias");
	$template->setVariable("linkVejaTodasNoticias", "noticias.php");
$template->parseCurrentBlock("blk_noticias");

$sql = "SELECT idProfessores, nickPro, descricaoPro, fotoPro FROM {$tabela['professores']} ORDER BY RAND() DESC LIMIT 2";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$i   = 1;
	$alt = $altura['pro_min'];
	$lar = $largura['pro_min'];
	$sca = $scalar['pro_min'];
	$link      = array();
	$img       = array();
	$nick    = array();
	$descricao = array();
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){			
		$link[$i]      = "vejaProfessor.php?id=".$dados['idProfessores'];
		if(empty($dados['fotoPro'])){
			$foto = "../images/avatar.jpg";			
		}
		else{
			$foto = "img.php?loc={$dados['fotoPro']}&a=$alt&l=$lar&s=$sca";
		}
		$img[$i]       = "<a href = \"{$link[$i]}\"><img src=\"$foto\" border=\"0\"></a>";
		$nick[$i]    = limitaStr($dados['nickPro'], LIMITE_TITULO_NOTICIA);
		$descricao[$i] = limitaStr(strip_tags($dados['descricaoPro']), LIMITE_DESCRICAO_NOTICIA);
		$i++;
	}
}
else{
	$img[1] = $img[2] = "Erro!";
	$nick[1] = $nick[2] = "Erro ao gerar o título";
	$link[1] = $link[2] = "#";
	$descricao[1] = $descricao[2] = "Erro ao gerar descrição";
}

/* Bloco Professor 1 */
$template->setCurrentBlock("blk_professor1");
	$template->setVariable("FP1", $img[1]);
	$template->setVariable("linkProfessor1", $link[1]);
	$template->setVariable("nickP1", $nick[1]);		
	$template->setVariable("descricaoP1", $descricao[1]);	
$template->parseCurrentBlock("blk_professor1");

/* Bloco Professor 2 */
$template->setCurrentBlock("blk_professor2");
	$template->setVariable("FP2", $img[2]);
	$template->setVariable("linkProfessor2", $link[2]);
	$template->setVariable("nickP2", $nick[2]);		
	$template->setVariable("descricaoP2", $descricao[2]);	
	
	$template->setVariable("vejaTodosProfessores", "Todos professores");
	$template->setVariable("linkVejaTodosProfessores", "professores.php");	
$template->parseCurrentBlock("blk_professor2");

$sql = "SELECT idDisciplinas, nomeDi, objetivosDi FROM {$tabela['disciplinas']} ORDER BY RAND() DESC LIMIT 2";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$i   = 1;
	$linkDis      = array();
	$nomeDis      = array();
	$descricaoDis = array();
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){			
		$linkDis[$i]      = "vejaDisciplina.php?id=".$dados['idDisciplinas'];
		$nomeDis[$i]      = $dados['nomeDi'];
		$descricaoDis[$i] = limitaStr(strip_tags($dados['objetivosDi']), LIMITE_DESCRICAO_NOTICIA);
		$i++;
	}
}
else{
	$linkDis[1] = $linkDis[2] = "#";
	$nomeDis[1] = $nomeDis[2] = "Erro ao gerar o título";
	$descricaoDis[1] = $descricaoDis[2] = "Erro ao gerar descrição";
}


/* Bloco Disciplinas */
$template->setCurrentBlock("blk_disciplinas");
	$template->setVariable("disciplina1", $nomeDis[1]);
	$template->setVariable("linkDisciplina1", $linkDis[1]);
	
	$template->setVariable("disciplina2", $nomeDis[2]);
	$template->setVariable("linkDisciplina2", $linkDis[2]);	
	
	$template->setVariable("descricaoD1", $descricaoDis[1]);		
	$template->setVariable("descricaoD2", $descricaoDis[2]);	
	
	$template->setVariable("vejaTodasDisciplinas", "Veja todas as disciplinas");
	$template->setVariable("linkVejaTodasDisciplinas", "disciplinas.php");	
$template->parseCurrentBlock("blk_disciplinas");

/* Bloco Map */
$template->setCurrentBlock("blk_maps");
	$template->setVariable("linkInf", LINK_INF);
	$template->setVariable("linkUtf", LINK_UTF);	
	$template->setVariable("linkKreea", LINK_KREEA);
$template->parseCurrentBlock("blk_maps");

$template->show();
?>