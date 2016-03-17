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

if(empty($id) || $id == 1){
	echo "<script language=javascript>location.href='index.php'</script>";
}

/* Gravando o curso selecionado em uma session */
$sessions = array('curso' => '#'.$id);
$session = new Session($sessions);

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = $infoTemplate[$id];

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */

/* Bloco das Notícias [interno] */
$sql = "SELECT not_cod, not_titulo, not_conteudo FROM {$tabela['noticias']} WHERE cur_cod = $id ORDER BY not_cod DESC LIMIT 3";
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_noticias_interno");
		$titulo = "<a href = \"mostranoticia.php?id={$dados['not_cod']}\" class=\"link_escuro\">".limitaStr($dados['not_titulo'], 40)."</a>";
		$template->setVariable("tituloNoticia", $titulo);
		$template->setVariable("conteudoNoticia", limpaQuebra(limitaStr(strtolower($dados['not_conteudo']), 150)));
	$template->parseCurrentBlock("bloco_noticias_interno");
}	

/* Bloco das Notícias [geral] */
$template->setCurrentBlock("bloco_noticias");
	$template->setVariable("vejaMais", "<a href = \"mostratodas.php?id=$id\" class=\"link_escuro\">Veja Mais</a>");
	$template->setVariable("vejaGaleria", "<a href = \"galeria.php?id=$id\" class=\"link_escuro\">Galeria de Fotos</a>");
$template->parseCurrentBlock("bloco_noticias");

/* Bloco da Descrição Central */
$template->setCurrentBlock("bloco_descricao");
	$sql = "SELECT cur_resumo FROM {$tabela['cursos']} WHERE cur_cod = $id";
	$resultado = $dataBase->getRow($sql);
	$template->setVariable("descricao", limitaStr($resultado[0], 320));
	$template->setVariable("vejaMais", "<a href = \"mostracurso.php?id=$id\" class=\"link_escuro\">Veja Mais</a>");
$template->parseCurrentBlock("bloco_descricao");

/* Bloco do Título Central */
$template->setCurrentBlock("bloco_titulo_central");
	$template->setVariable("titulo", "Ultimas Notícias");
$template->parseCurrentBlock("bloco_titulo_central");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$id]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco dos Cursos */
$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']} LIMIT 7";
$resultado = $dataBase->query($sql);

$cursos  = '<b>Cursos :</b><br><br>';

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($dados['cur_cod'] != 1){
		if(file_exists("../images/seta_{$dados['cur_cod']}.gif")){
			$cursos .= "<img src=\"../images/seta_{$dados['cur_cod']}.gif\">&nbsp;";
		}
		$cursos .= "<a href = \"pagina.php?id={$dados['cur_cod']}\" class=\"link_curso_{$dados['cur_cod']}\">";
		if($id == $dados['cur_cod']){ $cursos .= "<b>"; $passou = true; }
		$cursos .= str_replace("Curso de Especialização em ", "", $dados['cur_nome']);
		if($passou == true){ $cursos .= "</b>"; }
		$cursos .= "</a><br><br>";
	}
}
$template->setCurrentBlock("bloco_cursos");
	$template->setVariable("cursos", $cursos);
$template->parseCurrentBlock("bloco_cursos");

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