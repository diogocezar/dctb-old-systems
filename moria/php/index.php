<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

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
	$count = count($menuPrincipal);
	foreach($menuPrincipal as $display => $link){
		if($i+1 == $count){
			$separador = "";
		}
		else{
			$separador = "|";
		}
		$menu .= "<a href = \"$link\" class=\"link_menu\">$display</a> $separador "; 
		$i++;
	}
	$template->setVariable("menu", $menu);
	$template->setVariable("data", getData());
$template->parseCurrentBlock("bloco_menu");

/* Bloco Busca */
$template->setCurrentBlock("bloco_busca");
	$template->setVariable("formBusca", "form_busca");
	$template->setVariable("actionBusca", "busca.php");
	$template->setVariable("campoNome", "nome");
	$template->setVariable("comboCategoria", "categoria");
	$template->setVariable("comboFabricante", "fabricante");
	$template->setVariable("linkBusca", "#");
	$template->setVariable("altBusca" , "Buscar !");
	$template->setVariable("onClickBusca", "form_busca.submit();");
	$sql = "SELECT cat_cod, cat_nome FROM {$tabela['categorias']} ORDER BY cat_nome ASC";
	$resultado = $dataBase->query($sql);
	$categorias = "<option value=\"-1\">Todas</option>";
	if(!DB::isError($resultado)){	
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$categorias .= "<option value=\"{$dados['cat_cod']}\"";
			$categorias .= ">{$dados['cat_nome']}</option>";
		}
	}
	$template->setVariable("comboCategoriaOpcoes", $categorias);
	
	$sql = "SELECT fab_cod, fab_nome FROM {$tabela['fabricantes']} ORDER BY fab_nome ASC";
	$resultado = $dataBase->query($sql);
	$fabricantes = "<option value=\"-1\">Todos</option>";
	if(!DB::isError($resultado)){	
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$fabricantes .= "<option value=\"{$dados['fab_cod']}\"";
			$fabricantes .= ">{$dados['fab_nome']}</option>";
		}
	}
	$template->setVariable("comboFabricanteOpcoes", $fabricantes);
$template->parseCurrentBlock("bloco_busca");

/* Bloco Categorias */
$template->setCurrentBlock("bloco_categorias");
	$sql = "SELECT cat_cod, cat_nome FROM {$tabela['categorias']} ORDER BY cat_nome";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){	
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setCurrentBlock("bloco_categorias_itens");
				$codigo    = $dados['cat_cod'];
				$categoria = $dados['cat_nome'];
				$link      = "<a href=\"busca.php?categoria=$codigo\" class=\"link_claro\">$categoria</a>";
				$template->setVariable("categoria", $link);
			$template->parseCurrentBlock("bloco_categorias_itens");
		}
	}
$template->parseCurrentBlock("bloco_categorias");

/* Bloco Fabricantes */
$template->setCurrentBlock("bloco_fabricantes");
	$sql = "SELECT fab_cod, fab_nome FROM {$tabela['fabricantes']} ORDER BY fab_nome ASC";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){	
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setCurrentBlock("bloco_fabricantes_itens");
				$codigo    = $dados['fab_cod'];
				$fabricante = $dados['fab_nome'];
				$link      = "<a href=\"busca.php?fabricante=$codigo\" class=\"link_claro\">$fabricante</a>";
				$template->setVariable("fabricantes", $link);
			$template->parseCurrentBlock("bloco_fabricantes_itens");
		}
	}
$template->parseCurrentBlock("bloco_fabricantes");

/* Bloco Banners */
$template->setCurrentBlock("bloco_banners");
	$IniFile = new IniFile($diretorio['banners']);
	$banners = $IniFile->getIni(true);
	$i = 0;
	foreach($banners as $indice => $valor){
		$ind[$i++] = $indice;
	}
	$i = 0;
	foreach($banners[$ind[0]] as $indice => $valor){
		$imageBan[$i++] = $valor;
	}
	$i = 0;
	foreach($banners[$ind[1]] as $indice => $valor){
		$linkBan[$i++] = $valor;
	}
	for($j=0; $j<$i; $j++){
		$print .= "<a href = \"{$linkBan[$j]}\"><img src =\"{$imageBan[$j]}\" border =\"0\"></a>";
	}
	$template->setVariable("banners", $print);
$template->parseCurrentBlock("bloco_banners");

/* Bloco Tops */
$template->setCurrentBlock("bloco_tops");
	$template->setVariable("top1", "<a href = \"".$top[1]['link']."\">".$top[1]['imag']."</a>");
	$template->setVariable("top2", "<a href = \"".$top[2]['link']."\">".$top[2]['imag']."</a>");
$template->parseCurrentBlock("bloco_tops");

/* Bloco Produtos */
$ini = new IniFile($diretorio['opcoes']);
$arrayOpcoes = $ini->getIni(true);

$qtdProdutos = ceil($arrayOpcoes['configuraçõesGerais']['numProdPag']/2);

$sql = "SELECT p.pro_cod, p.pro_nome, p.pro_preco, p.pro_descricao, f.fot_url, fa.fab_nome, fa.fab_cod
        FROM {$tabela['produtos']} p, {$tabela['produtos_fotos']} pf, {$tabela['fotos']} f, {$tabela['fabricantes']} fa
		WHERE p.pro_cod = pf.pro_cod AND f.fot_cod = pf.fot_cod AND pf.pro_fot_principal = 'S' AND p.pro_promocao = 'Sim' AND fa.fab_cod = p.fab_cod
		ORDER BY pro_cod DESC LIMIT $qtdProdutos";

$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){	
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_produtos_1");
			$template->setVariable("titulo1",    limitaStr($dados['pro_nome'], 35));
			$template->setVariable("subTitulo1", "<a href =\"busca.php?fabricante={$dados['fab_cod']}\" class=\"link_claro\">".$dados['fab_nome']."</a>");
			$template->setVariable("descricao1", limitaStr(limpaQuebra($dados['pro_descricao']), 125));
			$template->setVariable("valor1",     number_format($dados['pro_preco'], 2, ',','.'));
			$template->setVariable("img1",       "<a href =\"mostraProduto.php?id={$dados['pro_cod']}\"><img src=\"img.php?loc={$dados['fot_url']}&a=85&l=85\" border=\"0\"></a>");
			$template->setVariable("linkInfo1",  "mostraProduto.php?id={$dados['pro_cod']}");
			$template->setVariable("altInfo1",   "Detalhes : {$dados['pro_nome']}");
		$template->parseCurrentBlock("bloco_produtos_1");
	}
}

$sql = "SELECT p.pro_cod, p.pro_nome, p.pro_preco, p.pro_descricao, f.fot_url, fa.fab_nome, fa.fab_cod
        FROM {$tabela['produtos']} p, {$tabela['produtos_fotos']} pf, {$tabela['fotos']} f, {$tabela['fabricantes']} fa
		WHERE p.pro_cod = pf.pro_cod AND f.fot_cod = pf.fot_cod AND pf.pro_fot_principal = 'S' AND p.pro_promocao <> 'Sim' AND fa.fab_cod = p.fab_cod
		ORDER BY pro_cod DESC LIMIT $qtdProdutos";

$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){	
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_produtos_2");
			$template->setVariable("titulo2",    limitaStr($dados['pro_nome'], 35));
			$template->setVariable("subTitulo2", "<a href =\"busca.php?fabricante={$dados['fab_cod']}\" class=\"link_claro\">".$dados['fab_nome']."</a>");
			$template->setVariable("descricao2", limitaStr(limpaQuebra($dados['pro_descricao']), 125));
			$template->setVariable("valor2",     number_format($dados['pro_preco'], 2, ',','.'));
			$template->setVariable("img2",       "<a href =\"mostraProduto.php?id={$dados['pro_cod']}\"><img src=\"img.php?loc={$dados['fot_url']}&a=85&l=85\" border=\"0\"></a>");
			$template->setVariable("linkInfo2",  "mostraProduto.php?id={$dados['pro_cod']}");
			$template->setVariable("altInfo2",   "Detalhes : {$dados['pro_nome']}");
		$template->parseCurrentBlock("bloco_produtos_2");
	}
}

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("linkPrincipal", "index.php");
	$template->setVariable("altPrincipal", "ShowRoom Kompre");
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>