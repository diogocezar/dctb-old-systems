<?
	session_start();
	if ( isset( $_SESSION['id'] ) ) {
		if ( isset( $_SESSION['nivel'] ) ) {
		}	
	} else {
		$_SESSION = array();
		session_destroy();
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>