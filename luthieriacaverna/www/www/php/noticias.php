<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* biblioteca de funcoes
*/
include("../lib/library.php");
include("../lib/util.php");

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'listar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* tipo artigo */
$tipoArtigo = $_GET['tipoartigo'];

/* Definindo constantes */	
define(ASSUNTO, "artigos");
define(TABELA, $tabelaMap['artigo']);

/* Contando registros */
$artigo = $controlador['artigo'];
$artigo->__toFillGeneric();
if(!empty($tipoArtigo)){
	$qtd = $artigo->count_r("idTipoArtigo = $tipoArtigo");
}
else{
	$qtd = $artigo->count_r(false);
}


/* Variáveis de Get para paginação */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, 'DESC');
define(ORDENADO, 'titulo');
define(ATUAL, $start);
define(POR_PAGINA, PP_GERENCIAR);
define(TOTAL, ceil((QTD)/POR_PAGINA));
if(!empty($tipoArtigo)){
	define(SQL, "SELECT * FROM ".TABELA." WHERE idTipoArtigo = $tipoArtigo ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
}
else{
	define(SQL, "SELECT * FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
}
$resultado = $artigo->queryArtigo(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	$template->setCurrentBlock("bloco_gerenciar_interno");
	
		/* Linha a ser impressa */
			$linha = $dados['titulo'];
			$descricao = $dados['descricao'];
			$autor = $dados['autor'];
			$link  = "vejaArtigo.php?id={$dados['id']}";
			$template->setVariable("linha", limitaStr($linha, STR_LIMITE_TITULO_ARTIGO));
			$template->setVariable("linkLinha", $link);
			$template->setVariable("descricao", limitaStr($descricao, STR_LIMITE_DESCRICAO_ARTIGO));
			$template->setVariable("autor", $autor);
			
	$template->parseCurrentBlock("bloco_gerenciar_interno");
	$contem_resultado = true;

}
/* Caso não ache nenhum resultado escreve para o usuário */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_gerenciar_erro");
			if(!empty($tipoArtigo)){
				$template->setVariable("erro", "Não foi possível encontrar nenhum registro no tipo de artigo escolhido.");
			}
			else{
				$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
			}
	$template->parseCurrentBlock("bloco_gerenciar_erro");
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
		
	$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0\"><img src=\"../images/primeiro.jpg\" border=\"0\" align=\"absmiddle\" /><a>&nbsp;&nbsp;";
	if($pag > 1){
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante\">";
	}		
	$paginacao .= "<img src=\"../images/anterior.jpg\" border=\"0\" align=\"absmiddle\" /></a>&nbsp;.<b>.</b>&nbsp;";		
	
	$inicioMostra = $pag_atua - (QTD_PAGINAS_SHOW/2);
	$fimMostra    = $pag_atua + (QTD_PAGINAS_SHOW/2);

	if($inicioMostra <= 0){
		$inicioMostra = 1;
	}
	
	if($fimMostra > TOTAL){
		$fimMostra = TOTAL;
	}
	for($i=$inicioMostra; $i<=$fimMostra; $i++){

		if(POR_PAGINA*($i-1) == ATUAL){	
			$paginacao .= "<b> $i</b>";
		}
		else{
			$aevi = POR_PAGINA*($i-1);
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"link_preto\">$i</a> ";
		}
	}
	
	$aevi = POR_PAGINA*(TOTAL-1);
	$i    = TOTAL;
	$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
	
	$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
	
	if($pag < TOTAL){						
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox\">";
	}
	
	$paginacao .= "<img src=\"../images/proximo.jpg\" border=\"0\" align=\"absmiddle\" /></a>&nbsp;";
	$paginacao .= "<a href=\"$link\"><img src=\"../images/ultimo.jpg\" border=\"0\" align=\"absmiddle\" /></a>";									
}
$agora = ($start/POR_PAGINA)+1;
$todas = TOTAL;

$infos = '<br>';
									
$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";

if(!empty($paginacao)){
	$template->setCurrentBlock("bloco_gerenciar_paginacao_controle");
				$template->setVariable("paginacao", $paginacao);
	$template->parseCurrentBlock("bloco_gerenciar_paginacao_controle");
}

if($contem_resultado == true){
	$template->setCurrentBlock("bloco_gerenciar_paginacao");
				$template->setVariable("infos", $infos);
	$template->parseCurrentBlock("bloco_gerenciar_paginacao");
}

$template->setCurrentBlock("bloco_gerenciar");

	/* Titulos */
		$template->setVariable("tituloGerenciar", "Listando ".ASSUNTO);

$template->parseCurrentBlock("bloco_gerenciar");

$paginacao = $template->get();

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "artigos.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	

/* bloco ultimos artigos */
$template->setCurrentBlock("bloco_ultimosArtigos");
	$artigo = $controlador['artigo'];
	$artigo->__toFillGeneric();
	$resultado = $artigo->lastArticles(3);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_ultimosArtigosInterno");
			$link = "vejaArtigo.php?id=".$dados[$artigo->campos[0]];
			$template->setVariable("tituloArtigo", limitaStr($dados[$artigo->campos[2]], STR_LIMITE_TITULO_ARTIGO_RESUMO));
			$template->setVariable("linkArtigo", $link);
		$template->parseCurrentBlock("bloco_ultimosArtigosInterno");
	}	
$template->parseCurrentBlock("bloco_ultimosArtigos");

/* bloco sessoes */
	$tipo = $controlador['tipoartigo'];
	$tipo->__toFillGeneric();
	$resultado = $tipo->rows(false, false, 1, 'ASC', false);
	/* setando opção para visualização de todos */
	$template->setCurrentBlock("bloco_sessoes");
		$template->setVariable("sessao", "Todas as Sessões");
		$template->setVariable("linkSessao", "artigos.php");	
	$template->parseCurrentBlock("bloco_sessoes");
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_sessoes");
			$template->setVariable("sessao", $dados[$tipo->campos[1]]);
			$template->setVariable("linkSessao", "?tipoartigo=".$dados[$tipo->campos[0]]);	
		$template->parseCurrentBlock("bloco_sessoes");
	}

/* bloco artigos */
$template->setCurrentBlock("bloco_artigo");
	$informacoes = $controlador['informacoes'];
	$informacoes->__toFillGeneric();
	$informacoes->__get_db($id);	
	$atuacao = $informacoes->getAtuacao();	
	$template->setVariable("campoArtigos", $paginacao);		
$template->parseCurrentBlock("bloco_artigo");

$conteudo = $template->get();

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>