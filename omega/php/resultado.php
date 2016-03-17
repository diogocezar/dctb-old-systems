<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Caputando código da enquete a ser mostrada */

$id = $_GET['enquete'];

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'enquete.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco do Login */
$template->setCurrentBlock("bloco_enquete");

	$sql = "SELECT res_resposta, res_votos
			FROM {$tabela['respostas']}
			WHERE enq_id = $id ORDER BY res_resposta";
	$resultado = $dataBase->query($sql);
	$total = 0;
	$i = 1;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$total += $dados['res_votos'];
		$resposta['titulo'][$i] = $dados['res_resposta'];
		$resposta['votos'][$i] = $dados['res_votos'];
		$i++;		
	}
	
	/* Calculando as Porcentagens */
	for($j=1; $j<5; $j++){
		$resposta['porcen'][$j] = number_format((100*$resposta['votos'][$j])/$total, 2, ',','.');
	}
	
	$sql = "SELECT enq_pergunta
			FROM {$tabela['enquete']}
			WHERE enq_id = $id LIMIT 1";
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	$pergunta = $dados['enq_pergunta'];

	/* Titulo */
		$template->setVariable("tituloEnquete", "Enquete :");
		$template->setVariable("pergunta", $pergunta);
		$template->setVariable("titulo", "Enquete");
		
	/* Titulos dos Campos */
		for($j=1; $j<5; $j++){
			$template->setVariable("r$j", $resposta['titulo'][$j]);
			$template->setVariable("p$j", $resposta['porcen'][$j]);
			$template->setVariable("v$j", $resposta['votos'][$j]);
			$tamanho = ($resposta['porcen'][$j]/100)*265;
			if($tamanho == 0){ $tamanho = 1; }
			$template->setVariable("faxa$j", "<img src=\"barra.php?t=$tamanho\" border = \"0\">");
		}	

		$template->setVariable("total", "Total de votos : <b>".$total."</b>");
		
	/* Informações sobre o filme */
	

	/* Botão */
		$template->setVariable("linkAvaliar", "#");
		$template->setVariable("altAvaliar", "Avaliar !");
	/* Java Script ao Enviar */
		$template->setVariable("onClickAvaliar", "enviaForm(form_avaliar)");
		
$template->parseCurrentBlock("bloco_enquete");

$template->show();
?>