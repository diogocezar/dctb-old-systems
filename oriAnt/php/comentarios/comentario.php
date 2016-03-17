<?php
/**
* Se não existe o cerebro, inclue.
*/
if(empty($controlador)){
	include('../cerebro/includeCerebro.php');
}

rawurldecode(include("listarComentario.php"));

	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formComentarios.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	 $pg = $_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
	 $pg = rawurldecode($pg);
	
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("cmp_form_nome", "nome");
		$template->setVariable("cmp_form_email", "email");
		$template->setVariable("cmp_form_url", "url");
		$template->setVariable("cmp_form_comentario", "comentario");
		$template->setVariable("cmp_form_pg", "pg");
		$template->setVariable("cmp_titulo", "Comente essa página");
		$template->setVariable("cmp_nome", "Nome:");
		$template->setVariable("cmp_email", "Email:");
		$template->setVariable("cmp_url", "Web site:");
		$template->setVariable("cmp_comentario", "Comentário:");
		$template->setVariable("cmp_botao", "Enviar Comentário");
		$template->setVariable("java_onclick", "javascript:InserirComentario(nome.value,email.value,url.value,comentario.value, '".$pg."')");
	$template->parseCurrentBlock("bloco_html");
	
	$comentarios = $template->get();
?>