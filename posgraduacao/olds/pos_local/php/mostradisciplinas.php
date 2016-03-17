<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Identificação do curso */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

/* Extraindo o nome do curso */
$nomeCurso = retornaNomeCur($id);

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'detalhesPaginado.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "disciplinas");
define(TABELA, $tabela['disciplinas']);

$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA." WHERE cur_cod = $id");

if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, 'ASC');
define(ORDENADO, 'dic_nome');
define(ATUAL, $start);
define(POR_PAGINA, PP_DISCIPLINAS_GERAL);
define(TOTAL, ceil((QTD)/POR_PAGINA));

define(SQL, "SELECT cur_cod, pro_cod, dic_nome, dic_carga_horaria, dic_descricao FROM ".TABELA." WHERE cur_cod = $id ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
		
$resultado = $dataBase->query(SQL);
$contem_resultado = false;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_detalhes_item");
		$professor = "<a href =\"mostraprofessor?id={$dados['pro_cod']}\" class=\"link_cinza\"><b>".retornaNomePro($dados['pro_cod'])."</b></a>";
		$dicNome   = "<b>".$dados['dic_nome']."</b>";
		$dicCarga  = "<b>".$dados['dic_carga_horaria']."</b><br>";
		$dicDescri = "<b>".$dados['dic_descricao']."</b><br><br>";
		$titulo    = $dicNome; 
		$conteudo  = $dicDescri;
		$conteudo  .= "Carga Horária : ".$dicCarga;
		$conteudo  .= "Ministrante : ".$professor;
		
		$template->setVariable("item", $titulo);
		$template->setVariable("conteudo", $conteudo);
		$contem_resultado = true;
	$template->parseCurrentBlock("bloco_detalhes_item");
}

/* Caso não ache nenhum resultado escreve para o usuário */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_detalhes_erro");
			$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
	$template->parseCurrentBlock("bloco_detalhes_erro");
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
		
	$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0\"><img src=\"../icones/2leftarrow.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
	if($pag > 1){
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante\">";
	}		
	$paginacao .= "<img src=\"../icones/1leftarrow.jpg\" border=\"0\"></a>&nbsp;.<b>.</b>&nbsp;";		
	for($i=1; $i<=TOTAL ; $i++){
		if(POR_PAGINA*($i-1) == ATUAL){	
			$paginacao .= "<b> $i</b>";
		}
		else{
			$aevi = POR_PAGINA*($i-1);
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"link_escuro\">$i</a> ";
		}
		/* Guardando o Link para a Ultima Página */
		if($i == TOTAL){
			$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
		}
	}
	
	$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
	
	if($pag < TOTAL){						
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox\">";
	}
	
	$paginacao .= "<img src=\"../icones/1rightarrow.jpg\" border=\"0\"></a>&nbsp;";
	$paginacao .= "<a href=\"$link\"><img src=\"../icones/2rightarrow.jpg\" border=\"0\"></a>";									
}
$agora = ($start/POR_PAGINA)+1;
$todas = TOTAL;

$infos = '<br>';
									
$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";

if(!empty($paginacao)){
	$template->setCurrentBlock("bloco_detalhes_paginacao_controle");
				$template->setVariable("paginacao", $paginacao);
	$template->parseCurrentBlock("bloco_detalhes_paginacao_controle");
}

if($contem_resultado == true){
	$template->setCurrentBlock("bloco_detalhes_paginacao");
				$template->setVariable("infos", $infos);
	$template->parseCurrentBlock("bloco_detalhes_paginacao");
}

$template->setCurrentBlock("bloco_curso");
		$template->setVariable("detalhes", "Disciplinas do Curso");
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "« Voltar");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1)");
$template->parseCurrentBlock("bloco_curso");


$curso .= "<br>";
$curso .= $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$id]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", $nomeCurso);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $curso);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['interno'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$link = str_replace('#', "?id=$id", $link);
			$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>