<?
	require ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");
	
		//VARIAVEL
		$pagina = get_include_contents('../includes/caminho.php');
		$pagina = $pagina."regra/cadastrarUsuario.php";

		/*VALIDACAO NULL*/
		$vars = validaNulo( $vars, 'nome' );
		$vars = validaNulo( $vars, 'login' );
		$vars = validaNulo( $vars, 'senha' );
		$vars = validaNulo( $vars, 'nivel' );
		if ( $_SESSION['erro'] ) {
			if ( $_POST[ 'nome' ] == null ) {
				$campo = "nome";
			} else {
				if ( $_POST[ 'login' ] == null ) {
					$campo = "login";
				} else {
					if ( $_POST[ 'senha' ] == null ) {
						$campo = "senha";
					} else {
						$campo = "nivel";
					}
				}
			}
			$_SESSION['erro'] = false;
			retorna( $pagina, " POR FAVOR PREENCHER TODOS OS CAMPOS!", $campo, $vars );
		}
		/*FIM VALIDACAO NULL*/

		/*CADASTRAR DADOS*/
		require ("../includes/conexao.php");
		$sql = "SELECT IDUSUARIO FROM USUARIO WHERE LOGIN = '".caixaAlta( $_POST['login'] )."'";
		if ( conectNumberLines( &$sql ) == 0 ){
			$sql = "SELECT IDUSUARIO FROM USUARIO WHERE NOME = '".caixaAlta( $_POST['nome'] )."'";
			if ( conectNumberLines( &$sql ) == 0 ){
				$sql = "INSERT INTO USUARIO ( NOME, LOGIN, SENHA, IDNIVEL ) VALUES ( '".$_POST['nome']."', '".$_POST['login']."', MD5('".$_POST['senha']."'), '".$_POST['nivel']."') RETURNING IDUSUARIO";
				$sql = caixaAlta( $sql );
				if ( @$retorno = executa( $sql ) ){
					retorna( $pagina , NULL, "nome&cadastro=true", NULL );					
				} else {
					retorna( $pagina , " ERRO AO CADASTRAR USU&Aacute;RIO!", NULL, $vars );
				}
			}else{
				retorna( $pagina , " NOME J&Aacute; CADASTRADO!", NULL, $vars );
			}
		}else{
			retorna( $pagina , " LOGIN J&Aacute; CADASTRADO!", "login", $vars );
		}
	}
?>
