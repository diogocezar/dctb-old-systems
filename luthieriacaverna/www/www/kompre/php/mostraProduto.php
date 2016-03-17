<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');
include('../classes/HTML_BBCodeParser/BBCodeParser.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Resgatando o id do produto */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
	exit();
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'produto.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Op��es do BBCode */

$options = array('quotestyle'    => 'double',
				 'quotewhat'     => 'all',
				 'open'          => '[',
				 'close'         => ']',
				 'xmlclose'      => true,
				 'filters'       => 'Basic'
				 );
				 
$parser = new HTML_BBCodeParser($options);

$sql = "SELECT p.pro_nome, p.pro_peso, p.pro_preco, p.pro_qtd, p.pro_disponibilidade, p.pro_classificacao, p.pro_promocao, p.pro_descricao,
               p.pro_especificacao, p.pro_dados_tecnicos, p.pro_itens_inclusos, p.pro_garantia, c.cat_nome, f.fab_nome
        FROM {$tabela['produtos']} p, {$tabela['fabricantes']} f, {$tabela['categorias']} c
		WHERE f.fab_cod = p.fab_cod AND c.cat_cod = p.cat_cod AND p.pro_cod = $id";

$resultado = $dataBase->query($sql);
$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

if(!empty($dados['pro_dados_tecnicos'])){
	$template->setCurrentBlock("bloco_produto_dados");
		$parser->setText($dados['pro_dados_tecnicos']);		
		$parser->parse();
		$template->setVariable("dadosTecnicos", $parser->getParsed());		
	$template->parseCurrentBlock("bloco_produto_dados");
}

if(!empty($dados['pro_itens_inclusos'])){
	$template->setCurrentBlock("bloco_produto_itens");
		$parser->setText($dados['pro_itens_inclusos']);		
		$parser->parse();
		$template->setVariable("itensInclusos", $parser->getParsed());		
	$template->parseCurrentBlock("bloco_produto_dados");
}

if(!empty($dados['pro_garantia'])){
$template->setCurrentBlock("bloco_produto_garantia");
		$parser->setText($dados['pro_garantia']);		
		$parser->parse();
		$template->setVariable("garantia", $parser->getParsed());		
$template->parseCurrentBlock("bloco_produto_garantia");
}

$template->setCurrentBlock("bloco_produto");
		$template->setVariable("nome", $dados['pro_nome']);	
		$template->setVariable("fabricante", $dados['fab_nome']);	
		
		$parser->setText($dados['pro_descricao']);		
		$parser->parse();
		$template->setVariable("descricao", $parser->getParsed());	
		
		$template->setVariable("disponibilidade", $dados['pro_disponibilidade']);		
		$template->setVariable("qtd", $dados['pro_qtd']);	
		$template->setVariable("categoria", $dados['cat_nome']);	
		$template->setVariable("classificacao", $dados['pro_classificacao']);		
		$template->setVariable("valor", number_format($dados['pro_preco'], 2, ',','.'));
		$template->setVariable("peso", number_format($dados['pro_peso'], 2, '.','.'));
		
		$sql = "SELECT f.fot_url
				FROM {$tabela['fotos']} f, {$tabela['produtos_fotos']} pf
				WHERE f.fot_cod = pf.fot_cod AND pf.pro_cod = $id
				ORDER BY pro_fot_principal DESC";

		$resultado = $dataBase->query($sql);
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$tamanho = getSize($dados['fot_url']);					
			$largura = $tamanho[0]; 
			$altura  = $tamanho[1];	
			$link   = "<a href =\"#\" onClick = \"abrir('mostra.php?loc={$dados['fot_url']}&l=$largura&a=$altura', '".$largura."', '".$altura."', 'no')\">";
			$fotos .= $link."<img src=\"img.php?loc={$dados['fot_url']}&a=95&l=95\" border=\"0\"></a>";
			$fotos .= "<br>";
			$fotos .= $link."<img src=\"../images/zoom.gif\" border=\"0\"></a>";
			$fotos .= "<br><br>";
		}
		
		$template->setVariable("fotos", $fotos);
		$largura = 260;
		$altura  = 365;
		$template->setVariable("frete", "<a href =\"#frete\" onClick=\"abrir('frete.php?id=$id', '".$largura."', '".$altura."', 'no')\" class=\"link_claro\">Consultar Frete</a><br><br>");		
			
$template->parseCurrentBlock("bloco_produto");

$show  = $template->get();
$show .= "<br>";

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
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$categorias .= "<option value=\"{$dados['cat_cod']}\"";
		$categorias .= ">{$dados['cat_nome']}</option>";
	}
	$template->setVariable("comboCategoriaOpcoes", $categorias);
	
	$sql = "SELECT fab_cod, fab_nome FROM {$tabela['fabricantes']} ORDER BY fab_nome ASC";
	$resultado = $dataBase->query($sql);
	$fabricantes = "<option value=\"-1\">Todos</option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$fabricantes .= "<option value=\"{$dados['fab_cod']}\"";
		$fabricantes .= ">{$dados['fab_nome']}</option>";
	}
	$template->setVariable("comboFabricanteOpcoes", $fabricantes);
$template->parseCurrentBlock("bloco_busca");

/* Bloco Categorias */
$template->setCurrentBlock("bloco_categorias");
	$sql = "SELECT cat_cod, cat_nome FROM {$tabela['categorias']} ORDER BY cat_nome";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_categorias_itens");
			$codigo    = $dados['cat_cod'];
			$categoria = $dados['cat_nome'];
			$link      = "<a href=\"busca.php?categoria=$codigo\" class=\"link_claro\">$categoria</a>";
			$template->setVariable("categoria", $link);
		$template->parseCurrentBlock("bloco_categorias_itens");
	}
$template->parseCurrentBlock("bloco_categorias");

/* Bloco Fabricantes */
$template->setCurrentBlock("bloco_fabricantes");
	$sql = "SELECT fab_cod, fab_nome FROM {$tabela['fabricantes']} ORDER BY fab_nome ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_fabricantes_itens");
			$codigo    = $dados['fab_cod'];
			$fabricante = $dados['fab_nome'];
			$link      = "<a href=\"busca.php?fabricante=$codigo\" class=\"link_claro\">$fabricante</a>";
			$template->setVariable("fabricantes", $link);
		$template->parseCurrentBlock("bloco_fabricantes_itens");
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

/* Bloco Conte�do */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo_interno", $show);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("linkPrincipal", "index.php");
	$template->setVariable("altPrincipal", "ShowRoom Kompre");
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>