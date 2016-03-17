<?php
/**
* Se não existe o cerebro, inclue.
*/
if(empty($controlador)){
	include('../cerebro/includeCerebro.php');
}

    // Recupera valores
    $nome       = addslashes(htmlentities($_POST['dado0']));
    $email      = addslashes(htmlentities($_POST['dado1']));
    $url        = addslashes(htmlentities($_POST['dado2']));
    $comentario = addslashes(nl2br(htmlentities($_POST['dado3'])));
    $pg         = $_POST['dado4'];
	
	$pg = rawurldecode($pg);
	
	$controlador['comentarios']->setPg($pg);
	$controlador['comentarios']->setNome($nome);
	$controlador['comentarios']->setEmail($email);
	$controlador['comentarios']->setUrl($url);
	$controlador['comentarios']->setComentario($comentario);
	$controlador['comentarios']->setTimestamp('now()');
	
	$controlador['comentarios']->save();
?>