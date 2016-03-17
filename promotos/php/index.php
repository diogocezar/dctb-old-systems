<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Pikture */
include('../classes/Pikture.php');


/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templatePrincipal.html';

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

/* Bloco Sobre */
$template->setCurrentBlock("bloco_sobre");

$sql = "SELECT l.loj_descricao, l.loj_foto_url, l.loj_cod
        FROM {$tabela['lojas']} l";

$resultado = $dataBase->query($sql);

$i=1;

if(!DB::isError($resultado)){
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$lojas[$i]['codi'] = $dados['loj_cod'];
	$lojas[$i]['desc'] = $dados['loj_descricao'];
	$lojas[$i]['foto'] = $dados['loj_foto_url'];
	$i++;
}
}
$i--;
$sorteado = rand(1,$i);

	$template->setVariable("fotoPromotos", "<a href=\"promotos.php#loja_{$lojas[$sorteado]['codi']}\"><img src=\"img.php?loc=".$lojas[$sorteado]['foto']."&l=100&a=71&s=nao\" align=\"absmiddle\" border=\"0\"></a>");
	$template->setVariable("textoPromotos", limitaStr(limpaQuebra($lojas[$sorteado]['desc']),160));
	$template->setVariable("linkSobre", "promotos.php?#loja_{$lojas[$sorteado]['codi']}");
	
$template->parseCurrentBlock("bloco_sobre");

/* Bloco Serviços */
$template->setCurrentBlock("bloco_servicos");

$sql = "SELECT s.ser_titulo, s.ser_descricao, s.ser_cod
        FROM {$tabela['servicos']} s";

$resultado = $dataBase->query($sql);

$i=1;
if(!DB::isError($resultado)){
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$servicos[$i]['codi'] = $dados['ser_cod'];
	$servicos[$i]['desc'] = $dados['ser_descricao'];
	$servicos[$i]['titu'] = $dados['ser_titulo'];
	$i++;
}
}

$i--;
$sorteado = rand(1,$i);

	$template->setVariable("textoServicos", limitaStr(limpaQuebra($servicos[$sorteado]['desc']), 115));
	$template->setVariable("fotoServicos", "foto");
	$template->setVariable("linkServicos", "servicos.php#servico_".$servicos[$sorteado]['codi']);
	
$template->parseCurrentBlock("bloco_servicos");

/* Bloco Galeria */
$template->setCurrentBlock("bloco_galeria");

	$ini = new IniFile("../pikture/config/gerais.ini");
	$gerais = $ini->getIni(false);
	
	$diretorio     = $gerais['diretorio'];
	$colunas       = $gerais['colunas'];
	$fotosPP       = $gerais['fotosPorPagina'];

	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	
	$fotos = $pikture->returnPictures();
	
	$i=1;
	
	foreach($fotos['fotos'] as $indice => $foto){
		$titulo = $foto;
		$foto = $diretorio.'/'.$fotos['folder'].'/'.$foto;
		$tamanho = $pikture->getSize($foto);					
		$largura = $tamanho[0]; 
		$altura  = $tamanho[1];			
		$replace  = "<a href=\"#\" onClick=\"abrir('mostra.php?loc=".$foto."&t=1&a=$altura&l=$largura&titulo=".$titulo."', '".$largura."', '".$altura."', 'no');\">";
		$replace .= "<img src=\"img.php?loc=".$foto."&l=65&a=55&s=nao\" align=\"absmiddle\" border=\"0\">";
		$replace .= "</a>";
		$template->setVariable("foto0$i", $replace);
		$i++;
	}
	$template->setVariable("linkGaleria", "galeria.php");
	#$template->setVariable("linkGaleria", "galeria.php?folder={$fotos['folder']}");
$template->parseCurrentBlock("bloco_galeria");

/* Bloco Loja */
$template->setCurrentBlock("bloco_loja");

$sql = "SELECT p.pro_cod, p.pro_nome, f.fot_url
        FROM {$tabela['produtos']} p, {$tabela['produtos_fotos']} pf, {$tabela['fotos']} f
		WHERE p.pro_cod = pf.pro_cod AND f.fot_cod = pf.fot_cod AND pf.pro_fot_principal = 'S' AND p.pro_promocao = 'Sim'
		ORDER BY pro_cod DESC LIMIT 4";

$resultado = $dataBase->query($sql);

echo $sql;

$i=1;
if(!DB::isError($resultado)){
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$dados['fot_url'] = str_replace("../images", "../kompre/images", $dados['fot_url']);
	$replace  = "<a href =\"../kompre/php/mostraProduto.php?id={$dados['pro_cod']}\" target=\"_blank\">";
	$replace .= "<img src=\"img.php?loc={$dados['fot_url']}&a=55&l=65\" border=\"0\">";
	$replace .= "</a>";
	$template->setVariable("oferta0$i", $replace);
	$i++;
}
}
	$template->setVariable("linkOferta", "http://kompre.promotos.com.br/php/ofertas.php");
$template->parseCurrentBlock("bloco_loja");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>
