<?
	if ( $_POST['user'] == NULL || $_POST['user'] == '' ){
		header ( "Location: index.php?erro=1" );
	} elseif ( $_POST['pass'] == NULL || $_POST['pass'] == '' ){
		header ( "Location: index.php?erro=2&user=".$_POST['user'] );
	} else {
		require ("includes/funcao.php");
		require ("includes/conexao.php");
		$sql = "SELECT IDUSUARIO FROM USUARIO WHERE LOGIN = '".caixaAlta($_POST['user'])."'";
		if ( conectNumberLines( &$sql ) > 0 ){
			$sql = "SELECT IDUSUARIO, IDNIVEL, NOME FROM USUARIO WHERE LOGIN = '".$_POST['user']."' AND SENHA = MD5('".$_POST['pass']."')";
			$sql = caixaAlta( $sql );
			if ( conectNumberLines( &$sql ) > 0 ){
				$sql = $sql." AND SITUACAO = TRUE";
				if ( conectNumberLines( &$sql ) > 0 ){
					session_start();
					$array = conectArray( &$sql );
					$_SESSION['id']   	= $array['idusuario'];
					$_SESSION['nome']	= $array['nome'];
					$_SESSION['nivel']  = $array['idnivel'];
					header ( "Location: http://sifin.xbrain.com.br/regra/" );
				} else {
					header ( "Location: index.php?erro=5" );
				}
			}else{
				header ( "Location: index.php?erro=4&user=".$_POST['user'] );
			}
		}else{
			header ( "Location: index.php?erro=3" );
		}
	}
?>