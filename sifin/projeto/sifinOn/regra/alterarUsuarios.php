<?
	require ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");

		/*GERAR SQL*/
		require ("../includes/conexao.php");
		$sql = "SELECT IDUSUARIO, NOME FROM USUARIO WHERE ";
		$sqlClone = $sql;
		$flag = false;
		if ( $_POST['nome'] != NULL ) {
			$sql = $sql." NOME LIKE '%".$_POST['nome']."%'";
			$flag = true;
		}
		if ( $_POST['login'] != NULL ) {
			if ( $flag ){
				$sql = $sql." AND LOGIN LIKE '%".$_POST['login']."%'";
			} else {
				$sql = $sql." LOGIN LIKE '%".$_POST['login']."%'";
				$flag = true;
			}
		}
		if ( $_POST['nivel'] != NULL ) {
			if ( $flag ){
				$sql = $sql." AND IDNIVEL LIKE '%".$_POST['nivel']."%'";
			} else {
				$sql = $sql." IDNIVEL LIKE '%".$_POST['nivel']."%'";
			}
		}
		/*FIM GERAR SQL*/
		$pagina = get_include_contents('../includes/caminho.php');

		/*CONSULTAR DADOS*/
		if ( $sqlClone != $sql ){
			$sql = $sql." ORDER BY NOME";
			$sql = caixaAlta( $sql );
			if ( conectNumberLines( &$sql ) == 0 ){
				retorna( $pagina."regra/alterarUsuario.php" , " NENHUM USU&Aacute;RIO LOCALIZADO NA BASE DE DADOS!", NULL, NULL );
			}else{
				$resp = executa( $sql );
				$_SESSION['retorno'] = $resp;
				header ( "Location: ".$pagina."regra/alterarUsuarioRetorno.php" );
			}
		} else {
			retorna( $pagina."regra/alterarUsuario.php" , " PREENCHER ALGUM CAMPO PARA EFETUAR A PESQUISA!", NULL, NULL );
		}
		/*FIM CONSULTAR DADOS*/
	} else {
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>