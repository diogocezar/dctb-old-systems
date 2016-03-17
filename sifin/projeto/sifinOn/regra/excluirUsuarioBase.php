<?
	require ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");
		
		//VARIAVEL
		$pagina = get_include_contents('../includes/caminho.php');
		$pagina = $pagina."regra/excluirUsuario.php";

		//CAPTURAR IDS A SEREM BAIXADOS
		$ids = $_POST['id'];
		$qtdade = 0;
		
		//OBTEM AS CHAVES E NAVEGA PELOS CAMPOS
		if ( $ids != NULL or $idDel != "" ){
			foreach ($ids as $chave => $valor) {
				if ( $valor == "on" ){
					$idDel = $idDel.",".$chave;
					$qtdade++;
				}
			}
		}
		if( $qtdade >= 1 ){
			$idDel = substr( $idDel, 1, strlen( $idDel )-1 );
		} else {
			retorna( $pagina , " NENHUM USU&Aacute;RIO FOI SELECIONADO!", NULL, NULL );	
		}

		/*CADASTRAR DADOS*/
		require ("../includes/conexao.php");
		$sql = "UPDATE USUARIO SET SITUACAO = FALSE, DATABAIXA = NOW() WHERE IDUSUARIO IN ( ".$idDel." ) RETURNING TRUE";
		if ( @update( $sql ) != 0 ){
			retorna( $pagina , " USU&Aacute;RIO(OS) BAIXADO(S) COM SUCESSO!", NULL, NULL );
		} else {
			retorna( $pagina , " ERRO AO EXCLUIR USU&Aacute;RIO(OS)!", NULL, NULL );
		}
	} else {
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>