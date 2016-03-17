<?php
/**
* Se não existe o cerebro, inclue.
*/
if(empty($controlador)){
	include('../cerebro/includeCerebro.php');
	/* Iniciando sessão */
	session_start();
}

    // Recupera valores
    $nota = $_POST['dado0'];
    $pg   = rawurldecode($_POST['dado1']);
	
	// Verificando se a página já foi votada
	$arrayPaginasVisitadas = $_SESSION[SESSION_PAGINAS];
	if(!empty($arrayPaginasVisitadas)){
		foreach($arrayPaginasVisitadas as $pagina){
			if($pagina == $pg){
				$existe = true;
			}
		}
	}
	
	if(!empty($nota) && !empty($pg) && !$existe){
	
		$avaliacao = $controlador['avaliacao']->__get_db($pg);
		
		$pagina    = $controlador['avaliacao']->getPg();
		
		if(!empty($pagina)){
			$controlador['avaliacao']->setTotal($controlador['avaliacao']->getTotal()+$nota);
			$controlador['avaliacao']->setVotantes($controlador['avaliacao']->getVotantes()+1);
			$controlador['avaliacao']->update();
		}
		else{
			$controlador['avaliacao']->setPg($pg);
			$controlador['avaliacao']->setTotal($nota);
			$controlador['avaliacao']->setVotantes(1);
			$controlador['avaliacao']->save();
		}
	}
?>