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

/* definições para página interna */
$pagina = getPaginaAtual();
$escopo = "Notícias";
$caminho = "Página Inicial";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'listar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "noticias");
define(TABELA, $tabelaMap['noticia']);

/* Contando registros */
$objeto = $controlador['noticia'];
$objeto->__toFillGeneric();
$qtd = $objeto->count_r(false);


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
define(SQL, "SELECT * FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
$resultado = $objeto->queryNotices(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	$template->setCurrentBlock("bloco_gerenciar_interno");
	
		/* Linha a ser impressa */
			
			$limiteNoticiasTitulo = 100;
			$limiteNoticiasResumo = 300;
		
			$linha = $dados['titulo'];
			$descricao = $dados['descricao'];
			$autor = $dados['autor'];
			$link  = "vejaNoticia.php?id={$dados['id']}";
			$template->setVariable("linha", limitaStr($linha, $limiteNoticiasTitulo));
			$template->setVariable("linkLinha", $link);
			$template->setVariable("descricao", limitaStr($descricao, $limiteNoticiasResumo));
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

$infos = '<br><span class="fonteData">';
									
$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.</span><br><br>";

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

$conteudo = $template->get();

include('includeInterna.php');
?>