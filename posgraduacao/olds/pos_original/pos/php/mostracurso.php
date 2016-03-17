<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Identifica��o do curso */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'detalhes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Convers�o das vari�veis dos blocos */
$sql = "SELECT cur_nome, cur_apresentacao, cur_objetivos, cur_certificado, cur_inicio, cur_termino, cur_periodo_inscricao, cur_periodo_matricula, cur_turno_funcionamento, cur_vagas, cur_complementar, cur_tx_inscricao, cur_matricula, cur_mensalidades, cur_resumo
        FROM {$tabela['cursos']}
		WHERE cur_cod = $id";
		
$resultado = $dataBase->query($sql);

$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

$imprime['Curso']                  = $dados["cur_nome"];
$imprime['Apresenta��o']           = $dados["cur_apresentacao"];
$imprime['Objetivos']              = $dados["cur_objetivos"];
$imprime['Certificado']            = $dados["cur_certificado"];
$imprime['In�cio do curso']        = converteData($dados["cur_inicio"]);
$imprime['T�rmino do curso']       = converteData($dados["cur_termino"]);
$imprime['Per�odo de inscri��o']   = $dados["cur_periodo_inscricao"];
$imprime['Per�odo de matr�cula']   = $dados["cur_periodo_matricula"];
$imprime['Turno de funcionamento'] = $dados["cur_turno_funcionamento"];
$imprime['Vagas']                  = $dados["cur_vagas"].' ('.extenso($dados["cur_vagas"], 2).')';
$imprime['Complementar']           = $dados["cur_complementar"];
$imprime['Taxa de inscri��o']      = $dados["cur_tx_inscricao"].' ('.extenso($dados["cur_tx_inscricao"], 0).')';;
$imprime['Matr�cula']              = $dados["cur_matricula"].' ('.extenso($dados["cur_matricula"], 0).')';;
$imprime['Mensalidades']           = $dados["cur_mensalidades"].' ('.extenso($dados["cur_mensalidades"], 0).')';;
$imprime['Resumo']                 = $dados["cur_resumo"];

foreach($imprime as $item => $conteudo){
	$template->setCurrentBlock("bloco_detalhes_item");
		if(!empty($item) && !empty($conteudo)){
			$template->setVariable("item", $item);
			$template->setVariable("conteudo", $conteudo);
		}
	$template->parseCurrentBlock("bloco_detalhes_item");
}

$template->setCurrentBlock("bloco_curso");
		$template->setVariable("detalhes", "<span class=\"curso_$id\">".$imprime['Curso']."</span>");
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "� Voltar");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1)");
$template->parseCurrentBlock("bloco_curso");

$curso  = "<br>";
$curso .= $template->get();

/* Diret�rio dos Templates */
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
	$template->setVariable("saibaMaisTitulo", "Maiores infroma��es ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da P�gina Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Informa��es sobre o curso");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conte�do da p�gina interna */
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

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>