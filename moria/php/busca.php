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

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'busca.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "produtos");
define(TABELA_PRODUTO,        $tabela['produtos']);
define(TABELA_CATEGORIAS,     $tabela['categorias']);
define(TABELA_FABRICANTES,    $tabela['fabricantes']);
define(TABELA_FOTOS,          $tabela['fotos']);
define(TABELA_PRODUTOS_FOTOS, $tabela['produtos_fotos']);

/* Variáveis de Get para paginação */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

/* Resgatando a opção para ordenação */
$ordem = $_GET['ordem'];

if(empty($ordem)){
	$ordem = 'pro_nome';
}

$tipo = $_GET['tipo'];

if(empty($tipo)){
	$tipo = 'ASC';
}

define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, $tipo);
define(ORDENADO, $ordem);
define(ATUAL, $start);

$ini = new IniFile($diretorio['opcoes']);
$arrayOpcoes = $ini->getIni(true);

$qtdProdutos = $arrayOpcoes['configuraçõesGerais']['numPorPag'];


define(POR_PAGINA, $qtdProdutos);

/* Resgatando informacões para Gerar o SQL */
$fabricante    = $_GET['fabricante'];
$categoria     = $_GET['categoria'];
$nome          = noToGet($_GET['nome']);

if(empty($fabricante)){
	$fabricante = -1; 
}
if(empty($categoria)){
	$categoria  = -1; 
}

$exite_nome        = false;
$existe_fabricante = false;
$existe_categoria  = false;

if(!empty($nome)){
	$exite_nome = true;
	$where .= " AND p.pro_nome LIKE '%$nome%' ";
}

if($fabricante != -1){
	$existe_fabricante = true;
	$where .= " AND p.fab_cod = fa.fab_cod AND fa.fab_cod = $fabricante ";
}

if($categoria != -1){
	$existe_categoria = true;
	$where .= " AND p.cat_cod = c.cat_cod AND c.cat_cod = $categoria ";
}

if(empty($fabricante) && empty($categoria) && empty($nome)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

$sql = "SELECT DISTINCT p.pro_cod, p.pro_nome, p.pro_preco, p.pro_descricao, f.fot_url
	    FROM ".TABELA_PRODUTO." p, ".TABELA_PRODUTOS_FOTOS." pf, ".TABELA_FOTOS." f ";
		
$sqlCount = "SELECT count(distinct(p.pro_nome)) as qtd
	         FROM ".TABELA_PRODUTO." p, ".TABELA_PRODUTOS_FOTOS." pf, ".TABELA_FOTOS." f ";
			 
if($existe_fabricante){
	$sql .= ", ".TABELA_FABRICANTES." fa ";
	$sqlCount .= ", ".TABELA_FABRICANTES." fa ";
}

if($existe_categoria){
	$sql .= ", ".TABELA_CATEGORIAS." c ";
	$sqlCount .= ", ".TABELA_CATEGORIAS." c ";
}

$sql      .= "WHERE (p.pro_cod = pf.pro_cod AND f.fot_cod = pf.fot_cod AND pf.pro_fot_principal = 'S') ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA;
$sqlCount .= "WHERE (p.pro_cod = pf.pro_cod AND f.fot_cod = pf.fot_cod AND pf.pro_fot_principal = 'S') ".$where;

$resultado = $dataBase->query($sqlCount);
if(!DB::isError($resultado)){	
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
}
$qtd = $dados['qtd'];

define(QTD, $qtd);
define(TOTAL, ceil((QTD)/POR_PAGINA));

$resultado = $dataBase->query($sql);
$contem_resultado = false;
if(!DB::isError($resultado)){	
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_busca_interno");	
			$template->setVariable("produto"  , limitaStr($dados['pro_nome'], 35));
			$template->setVariable("descricao", limitaStr(limpaQuebra($dados['pro_descricao']), 50));
			$template->setVariable("img"      , "<a href =\"mostraProduto.php?id={$dados['pro_cod']}\"><img src=\"img.php?loc={$dados['fot_url']}&a=45&l=45\" border=\"0\"></a>");
			$template->setVariable("valor"    , number_format($dados['pro_preco'], 2, ',','.'));	
			$template->setVariable("linkInfo" , "mostraProduto.php?id={$dados['pro_cod']}");
			$template->setVariable("altInfo"  , "Detalhes : {$dados['pro_nome']}");		
		$template->parseCurrentBlock("bloco_busca_interno");
		$contem_resultado = true;
	}
}

/* Caso não ache nenhum resultado escreve para o usuário */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_busca_erro");
			$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
	$template->parseCurrentBlock("bloco_busca_erro");
}

/* Controle da Paginação */
$paginacao = '';
if(TOTAL > 1){	
	$pag = $_GET['pag'];
	if(empty($pag)){
		$pag = 1;
	}										
	$mostra_prox = POR_PAGINA*(($pag+1)-1);
	$mostra_ante = POR_PAGINA*(($pag-1)-1);
	$mostra_essa = POR_PAGINA*(($pag)-1);		
	$pag_prox = $pag+1;		
	$pag_ante = $pag-1;		
	$pag_atua = $pag;
	
	/* Transformando o nome */
	$nome = toGet($nome);
		
	$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0&nome=$nome&fabricante=$fabricante&categoria=$categoria\"><img src=\"../images/bot_primeiro.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
	if($pag > 1){
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante&nome=$nome&fabricante=$fabricante&categoria=$categoria\">";
	}		
	$paginacao .= "<img src=\"../images/bot_anteriror.jpg\" border=\"0\"></a>&nbsp;.<b>.</b>&nbsp;";		
	
	$inicioMostra = $pag_atua - (QTD_PAGINAS_SHOW/2);
	$fimMostra    = $pag_atua + (QTD_PAGINAS_SHOW/2);

	if($inicioMostra <= 0){
		$inicioMostra = 1;
	}
	
	if($fimMostra > TOTAL){
		$fimMostra = TOTAL;
	}
	
	for($i=$inicioMostra; $i<=$fimMostra ; $i++){

		if(POR_PAGINA*($i-1) == ATUAL){	
			$paginacao .= "<b> $i</b>";
		}
		else{
			$aevi = POR_PAGINA*($i-1);
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i&nome=$nome&fabricante=$fabricante&categoria=$categoria\" class=\"link_claro\">$i</a> ";
		}
	}
	
	$aevi = POR_PAGINA*(TOTAL-1);
	$i    = TOTAL;
	$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
	
	$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
	
	if($pag < TOTAL){						
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox&nome=$nome&fabricante=$fabricante&categoria=$categoria\">";
	}
	
	$paginacao .= "<img src=\"../images/bot_proximo.jpg\" border=\"0\"></a>&nbsp;";
	$paginacao .= "<a href=\"$link\"><img src=\"../images/bot_ultimo.jpg\" border=\"0\"></a>";									
}
$agora = ($start/POR_PAGINA)+1;
$todas = TOTAL;

$infos = '<br>';
									
$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
$infos .= "Foram encontrados <b>".QTD."</b> ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";

if(!empty($paginacao)){
	$template->setCurrentBlock("bloco_busca_paginacao_controle");
				$template->setVariable("paginacao", $paginacao);
	$template->parseCurrentBlock("bloco_busca_paginacao_controle");
}

if($contem_resultado == true){
	$template->setCurrentBlock("bloco_busca_paginacao");
				$template->setVariable("infos", $infos);
	$template->parseCurrentBlock("bloco_busca_paginacao");
}

$template->setCurrentBlock("bloco_busca");

	/* Titulos */
		$template->setVariable("tituloBusca", "Busca por produtos:");

	/* Botão */
		$template->setVariable("btnVoltar", "Voltar");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='index.php'");

$template->parseCurrentBlock("bloco_busca");

$show  = $template->get();
$show .= "<br>";

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
	if(!empty($nome)){
			$template->setVariable("valorNome", $nome);
	}
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
			if($dados['cat_cod'] == $categoria){
				$categorias .= "selected";
			}
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
			if($dados['fab_cod'] == $fabricante){
				$fabricantes .= "selected";
			}
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

/* Bloco Conteúdo */
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