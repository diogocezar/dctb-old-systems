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

/* Extraindo id do curso atual */
$idCurso = sessionNum($_SESSION['curso']);

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'detalhes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */
$sql = "SELECT pro_nome, pro_atuacao, pro_titulacao, pro_formacao, pro_email, pro_pag_pessoal
        FROM {$tabela['professores']}
		WHERE pro_cod = $id";
		
$resultado = $dataBase->query($sql);

$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

$nome                      = $dados["pro_nome"];
$imprime['Atuação']        = $dados["pro_atuacao"];
$imprime['Titulação']      = $dados["pro_titulacao"];
$imprime['Formação']       = $dados["pro_formacao"];
$imprime['Email']          = "<a href = \"mailto:{$dados['pro_email']}\" class=\"link_escuro\">".$dados["pro_email"]."</a>";
$pagina                    = $dados["pro_pag_pessoal"];

if(!empty($pagina)){
	if(!eregi("http://", $pagina)){
		$pagina = "http://".$pagina;
	}
	$pagina = "<a href = \"$pagina\" class=\"link_escuro\">".$pagina."</a>";
	$imprime['Página Pessoal'] = $pagina;
}

foreach($imprime as $item => $conteudo){
	$template->setCurrentBlock("bloco_detalhes_item");
		if(!empty($item) && !empty($conteudo)){
			$template->setVariable("item", $item);
			$template->setVariable("conteudo", $conteudo);
		}
	$template->parseCurrentBlock("bloco_detalhes_item");
}

$template->setCurrentBlock("bloco_curso");
		$template->setVariable("detalhes", $nome);
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "« Voltar");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1)");
$template->parseCurrentBlock("bloco_curso");

$professor  = "<br>";
$professor .= $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$idCurso]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Informações sobre orientador");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $professor);
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
			$link = str_replace('#', "?id=$idCurso", $link);
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