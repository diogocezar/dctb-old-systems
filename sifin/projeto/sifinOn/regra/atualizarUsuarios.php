<?
	require ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");
		
		//VARIAVEL
		$pagina = get_include_contents('../includes/caminho.php');

		/*VALIDACAO NULL*/
		$vars = validaNulo( $vars, 'nome' );
		$vars = validaNulo( $vars, 'login' );
		if ( $_SESSION['erro'] ) {
			if ( $_POST[ 'nome' ] == null ) {
				$campo = "nome";
			} else {
				$campo = "login";
			}
			$_SESSION['erro'] = false;
			retornaId( 	$pagina."regra/alterarUsuarioRetornoUnico.php?id=".$_POST['id'],
						" OS CAMPOS NOME E LOGIN S&Atilde;O OBRIGAT&Oacute;RIOS!",
						$campo,
						NULL
			);
		}
		/*FIM VALIDACAO NULL*/

		/*CADASTRAR DADOS*/
		require ("../includes/conexao.php");
		$sql = "UPDATE USUARIO SET NOME = '".$_POST['nome']."', LOGIN = '".$_POST['login']."', IDNIVEL = '".$_POST['nivel']."', SITUACAO = TRUE, DATABAIXA = NULL";
		if ( $_POST['senha'] != NULL ){
			$sql = $sql.", SENHA = MD5('".$_POST['senha']."') ";
		}
		$sql = caixaAlta( $sql . " WHERE IDUSUARIO = ".$_POST['id']." RETURNING IDUSUARIO");
		if ( @update( $sql ) != 0 ){
			retorna( $pagina."regra/alterarUsuario.php" , " USU&Aacute;RIO ALTERADO COM SUCESSO!", "nome", NULL );					
		} else {
			retorna( $pagina."regra/alterarUsuario.php" , " ERRO AO ALTERAR USU&Aacute;RIO!", "nome", NULL );
		}
	} else {
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>