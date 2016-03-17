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

$templateHtmlName = 'listar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "categorias");
define(TABELA, $tabela['categorias']);

/* Contando registros */
$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA);

/* Variáveis de Get para paginação */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, 'ASC');
define(ORDENADO, 'cat_nome');
define(ATUAL, $start);
define(POR_PAGINA, PP_CATEGORIAS);
define(TOTAL, ceil((QTD)/POR_PAGINA));
define(SQL, "SELECT cat_nome, cat_cod FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
$resultado = $dataBase->query(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	$template->setCurrentBlock("bloco_listar_interno");
		$largura = 272;
		$altura  = 325;
		$linha  = "<a href =\"busca.php?categoria={$dados['cat_cod']}\" class=\"link_claro\">";
		$linha .= $dados['cat_nome'];
		$linha .= "</a>";
		$linha .= " - <a href=\"#\" onClick=\"abrir('detalhes.php?tipo=categoria&id=".$dados['cat_cod']."', '".$largura."', '".$altura."', 'yes')\" class=\"link_claro\">Detalhes</a>";		
		$template->setVariable("item", $linha);		
			
	$template->parseCurrentBlock("bloco_listar_interno");
	$contem_resultado = true;

}
/* Caso não ache nenhum resultado escreve para o usuário */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_listar_erro");
			$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
	$template->parseCurrentBlock("bloco_listar_erro");
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
		
	$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0\"><img src=\"../images/bot_primeiro.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
	if($pag > 1){
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante\">";
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
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"link_claro\">$i</a> ";
		}
	}
	
	$aevi = POR_PAGINA*(TOTAL-1);
	$i    = TOTAL;
	$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
	
	$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
	
	if($pag < TOTAL){						
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox\">";
	}
	
	$paginacao .= "<img src=\"../images/bot_proximo.jpg\" border=\"0\"></a>&nbsp;";
	$paginacao .= "<a href=\"$link\"><img src=\"../images/bot_ultimo.jpg\" border=\"0\"></a>";									
}
$agora = ($start/POR_PAGINA)+1;
$todas = TOTAL;

$infos = '<br>';
									
$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
$infos .= "Existem <b>".QTD."</b> ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";

if(!empty($paginacao)){
	$template->setCurrentBlock("bloco_listar_paginacao_controle");
				$template->setVariable("paginacao", $paginacao);
	$template->parseCurrentBlock("bloco_listar_paginacao_controle");
}

if($contem_resultado == true){
	$template->setCurrentBlock("bloco_listar_paginacao");
				$template->setVariable("infos", $infos);
	$template->parseCurrentBlock("bloco_listar_paginacao");
}

$template->setCurrentBlock("bloco_listar");

	/* Titulos */
		$template->setVariable("tituloListar", "Listando as Categorias:");

	/* Botão */
		$template->setVariable("btnVoltar", "Voltar");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='index.php'");

$template->parseCurrentBlock("bloco_listar");

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