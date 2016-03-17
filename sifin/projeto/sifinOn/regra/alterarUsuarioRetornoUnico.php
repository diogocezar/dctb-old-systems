<?
	include_once ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");
		require ("../includes/conexao.php");
		$pagina = get_include_contents('../includes/caminho.php');
		if ( $_GET['id'] == NULL or $_GET['id'] == "" ){
			retorna( $pagina."regra/alterarUsuario.php" , " TENTATIVA INV&Aacute;LIDA DE BUSCA!", NULL, NULL );
		} else {
			$sql = "SELECT NOME, LOGIN, IDNIVEL FROM USUARIO WHERE IDUSUARIO = ".$_GET['id'];
			if ( @conectNumberLines( &$sql ) == 0 ){
				retorna( $pagina."regra/alterarUsuario.php" , " NENHUM USU&Aacute;RIO LOCALIZADO NA BASE DE DADOS!", NULL, NULL );
			}else{
				$resp = executa( $sql );
			}
		}
?>
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<link rel="stylesheet" href="../includes/menu.css">
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				<?
					require("../includes/title.php");
				?>
			<link href="../default.css" rel="stylesheet" type="text/css" />
		</head>
		<body>
			<?
				require("../includes/logado.php");
				if ( $_SESSION['aviso'] != NULL ){
					print '<div id="pageAlin"><font color="#FF0000">ALERTA:'.$_SESSION['aviso'].'</font></div>';
					$_SESSION['aviso'] = NULL;
				}
			?>
			<form name="alterarUsuarioRetornoUnico" method="post" action="atualizarUsuarios.php">
				<input type="hidden" name="id" value="<? print $_GET['id'] ?>">
				<div id="pageServ">
					<div id="pageAlin">
						Nome:
						<input name="nome" id="nome" type="text" maxlength="100" size="100" value="<? print $resp[0][0]; ?>">
					</div>
					<div id="pageAlin">
						Login:<br>
						<input name="login" id="login" type="text" maxlength="30" size="20" value="<? print $resp[0][1]; ?>">
					</div>
					<div id="pageAlin">
						Senha:<br>
						<input name="senha" id="senha" type="password" maxlength="50" size="20" title="Caso queira alterar a senha do usu&aacute;rio, favor preencher o campo.">
					</div>
					<div id="pageAlin">
						N&iacute;vel Usu&aacute;rio:<br>
						<select name="nivel" id="nivel">
							<?
								$sql = "SELECT IDNIVEL, DESCRICAO FROM NIVEL ORDER BY DESCRICAO";
								$rs = executa( $sql );
								for ( $i = 0 ; $i < count( $rs ) ; $i++ ) {
							?>
							<option value="<? print $rs[$i][0]; ?>" <? if ( $rs[$i][0] == $resp[0][2] ) print 'selected="selected"'; ?> >
								<?
									print $rs[$i][1];
								?> 
							</option>
							<?
								}
							?>
						</select>
					</div>
					<div align="center">
						<input name="Alterar" type="submit" value="Alterar">
						<input name="Limpar" type="reset" value="Limpar" onClick="document.alterarUsuarioRetornoUnico.nome.focus();">
					</div>
				</div>
			</form>
			<?
				require ('../includes/rodape.php');
			?>
			<script language="JavaScript" src="../includes/menu.js"></script>
			<script language="JavaScript" src="../includes/menu_items.js"></script>
			<script language="JavaScript" src="../includes/menu_tpl.js"></script>
			<script language="JavaScript">new menu (MENU_<? print $_SESSION['nivel']; ?>, MENU_TPL);</script>
			<script language="javascript">
				document.alterarUsuarioRetornoUnico.nome.focus();
			</script>
		</body>
	</html>
<?
	} else {
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>