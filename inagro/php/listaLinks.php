<?
/* Contando registros */
$contexto = 'link';
$objeto = $controlador[$contexto];
$objeto->__toFillGeneric();
$qtd = $objeto->count_r(false);
$campo = $objeto->campos[0];

/**
/* diretório dos templates 
*/
$templateHtmlDir = '../html';

$templateHtmlName = 'listarSemFoto.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Variáveis de Get para paginação */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];
define(ASSUNTO, $contexto.'(s)');
define(TABELA, $objeto->getTabela());
define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, 'DESC');
define(ORDENADO, $campo);
define(ATUAL, $start);
define(POR_PAGINA, 3);
define(TOTAL, ceil((QTD)/POR_PAGINA));
define(SQL, "SELECT * FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
$resultado = $objeto->query(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	$template->setCurrentBlock("bloco_gerenciar_interno");
			
			$limiteTitulo = 100;
			$limiteResumo = 230;
			
			$link = $dados[$objeto->campos[2]];
			
			if(!eregi($link, 'http://')) $link = 'http://'.$link;
			
			$titulo    = limitaStr($dados[$objeto->campos[1]], $limiteTitulo);
			$descricao = limitaStr($dados[$objeto->campos[2]], $limiteResumo);
			
			$template->setVariable("titulo", $titulo);
			$template->setVariable("descricao", "<a href=\"$link\" class=\"link_preto\">".$descricao."</a>");
			
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
echo $conteudo;
?>