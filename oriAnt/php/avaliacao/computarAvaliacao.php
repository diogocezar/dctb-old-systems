<?php
/**
* Se não existe o cerebro, inclue.
*/
if(empty($controlador)){
	include('../cerebro/includeCerebro.php');
	/* Iniciando sessão */
	session_start();
}

function callback_computar_avaliacao($buffer) {
    if($_POST['dado0']){ // Enviado pelo Ajax
        return rawurlencode($buffer);
    } else {
        return $buffer;
    }
}

ob_start("callback_computar_avaliacao");
             
    if($_POST['dado0']){
         $pg = rawurldecode($_POST['dado0']);
    } else {
         $pg = $_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
		 $pg = rawurldecode($pg);
    }
    $acao = rawurldecode($_POST['dado1']);
	
	$existe = false;
	$arrayPaginasVisitadas = $_SESSION[SESSION_PAGINAS];
	if(!empty($arrayPaginasVisitadas)){
		foreach($arrayPaginasVisitadas as $pagina){
			if(rawurldecode($pagina) == rawurldecode($pg)){
				$existe = true;
				$acao = 'computado';
			}
		}
	}	
	
	if($acao == 'computado'){
		if(!$existe){
			$arrayPaginasVisitadas[count($arrayPaginasVisitadas)+1] = $pg;
			$_SESSION[SESSION_PAGINAS] = $arrayPaginasVisitadas;
		}
	}
	
	$pg = rawurldecode($pg);
	
	$controlador['avaliacao']->__get_db($pg);
	
	$total      = $controlador['avaliacao']->getTotal();
	
	$votantes   = $controlador['avaliacao']->getVotantes();

    if($votantes > 0){
        $media    = round($total/$votantes,2);
        $votantes = round($votantes);
    } 
	else{
        $votantes = 0;
    }
	
    $media = number_format($media,2);

    $imagem_on  = "<img src=\"../images/avaliacao/estrela_on.gif\" border=\"0\">";
    $imagem_off = "<img src=\"../images/avaliacao/estrela_off.gif\" border=\"0\">";
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'avaliacao.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("cmp_avaliacao", "Avaliação");
		$template->setVariable("cmp_vote", "Vote clicando");
		$template->setVariable("cmp_qtd_votos", $votantes." voto(s)");
		$template->setVariable("cmp_avaliacao", "Avaliação");
	
			
	for($cont=1; $cont<=10; $cont++){
		$template->setCurrentBlock("bloco_estrela");
			$template->setVariable("cmp_div_estrela", "estrela_$cont");
			if($acao != 'computado'){
				$replace = "<a href=\"javascript:;\" onclick=\"javascript:InserirAvaliacao(nota='".$cont."',pg='".$pg."');\" onmouseover=\"alteraImg(".$cont.", '".$pg."');\">";
			}
			else{
				$replace = "";
			}
			if($cont<=round($media)){
				$replace .= $imagem_on;
			}
			else{
				$replace .= $imagem_off;
			}
			if($acao != 'computado'){
				$replace .= "</a>";
			}
			$template->setVariable("cmp_estrela", $replace);
			$template->setVariable("cmp_nota", $cont);
		$template->parseCurrentBlock("bloco_estrela");
	}
	
	$template->setVariable("cmp_media", $media);
	if($acao == 'computado'){
        $template->setVariable("cmp_votado", "Seu voto foi computado, obrigado!");
    }
	
	$template->parseCurrentBlock("bloco_html");
	
	$avaliacao = $template->get();
	
	if($_GET['mostra'] == "ok"){
		$template->show();
	}

ob_end_flush();
?>