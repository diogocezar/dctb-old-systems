<?php
/**
* Se não existe o cerebro, inclue.
*/
if(empty($controlador)){
	include('../cerebro/includeCerebro.php');
}

if(!function_exists('timestamp2str')){
	include('../lib/library.php');
}

function callback_listar_comentario($buffer) {
    if($_POST['dado0']){ // Enviado pelo Ajax
        return rawurlencode($buffer);
    } else {
        return $buffer;
    }
}

ob_start("callback_listar_comentario");

    $buffer = '';

    if($_POST['dado0']){
         $pg = rawurldecode($_POST['dado0']);
    } else {
         $pg = $_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
		 $pg = rawurldecode($pg);
    }
    $acao = rawurldecode($_POST['dado1']);

    if($acao == 'adicionado'){
        $color=1;
    }

    // Busca comentarios
	
	$pg = rawurldecode($pg);
	
	$condicao  = $camposMap['comentarios'][1]." = '".$pg."'";
	$resultado = $controlador['comentarios']->rows(false, false, 5, 'DESC', $condicao);
	$total     = $controlador['comentarios']->count_r($condicao);
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'comentarios.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
					
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("cmp_qtd_comentarios", $total." comentário(s)");
        $i=$total;
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			// Recebe valores
			if(get_magic_quotes_gpc() == 1){
				$nome       = stripslashes($dados['nome']);
				$email      = stripslashes($dados['email']);
				$url        = stripslashes($dados['url']);
				$comentario = stripslashes($dados['comentario']);
			}
			else{
				$nome       = $dados['nome'];
				$email      = $dados['email'];
				$url        = $dados['url'];
				$comentario = $dados['comentario'];
			}
			
			$timestamp = timestamp2str($dados['timestamp'], ":", "/");

			$template->setCurrentBlock("bloco_comentarios");
			
				$template->setVariable("cmp_num_coment", $i);
				$template->setVariable("cmp_nome", $nome);
				$template->setVariable("cmp_quando", $timestamp);
				$template->setVariable("cmp_email", "<a href=mailto:".$email." class=estilo1>E-mail</a>");
				$template->setVariable("cmp_site", "<a href=".$url." target=_blank class=estilo1>Site</a>");
				$template->setVariable("cmp_coment", $comentario);
				$i--;
				
			$template->parseCurrentBlock("bloco_comentarios");
		}

	$template->parseCurrentBlock("bloco_html");
	
	$listarComentario = $template->get();
	
	if($_GET['mostra'] == "ok"){
		$template->show();
	}

ob_end_flush();
?>