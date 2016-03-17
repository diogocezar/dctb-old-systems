<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'gerenciar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "atividades");
define(TABELA, $tabela['atividades']);

/* Contando registros */
$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA);

/* Vari�veis de Get para pagina��o */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, 'ASC');
define(ORDENADO, 'nomeAtividade');
define(ATUAL, $start);
define(POR_PAGINA, PP_GERENCIAR);
define(TOTAL, ceil((QTD)/POR_PAGINA));
define(SQL, "SELECT idAtividades, nomeAtividade FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
$resultado = $dataBase->query(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	$template->setCurrentBlock("bloco_gerenciar_interno");
	
		/* Nomes das Imagens */	
			$template->setVariable("editar", "Editar");
			$template->setVariable("excluir", "Excluir");
		
		/* Links da imagens dos Campos */
			$template->setVariable("linkEditar", "atividade.php?acao=atualizar&id={$dados['idAtividades']}");
			$template->setVariable("linkExcluir", "exclui.php?tipo=atividade&id={$dados['idAtividades']}");
		
		/* Linha a ser impressa */
			$linha = limitaStr($dados['nomeAtividade'], LIMITE_GENRENCIAR);
			$template->setVariable("linha", $linha);
			
	$template->parseCurrentBlock("bloco_gerenciar_interno");
	$contem_resultado = true;

}
/* Caso n�o ache nenhum resultado escreve para o usu�rio */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_gerenciar_erro");
			$template->setVariable("erro", "N�o foi encontrado nenhum registro em '".ASSUNTO."'.");
	$template->parseCurrentBlock("bloco_gerenciar_erro");
}

/* Controle da Pagina��o */
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
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"linkPaginacao\">$i</a> ";
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
									
$infos .= "Exibindo p�gina : <b>$agora</b> de <b>$todas</b> p�ginas<br>";
$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por p�gina.<br><br>";

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
		$template->setVariable("tituloGerenciar", "Gerenciar ".ASSUNTO);

	/* Bot�o */
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  � Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");

$template->parseCurrentBlock("bloco_gerenciar");

$conteudo = $template->get();
$tituloInterna = "�rea Restrita";

include("includeInterna.php");
?>