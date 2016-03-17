<?
	include_once ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
		require ("../includes/funcao.php");
		require ("../includes/conexao.php");
		$pagina = get_include_contents('../includes/caminho.php');
		if ( $_GET['id'] == NULL or $_GET['id'] == "" ){
			retorna( $pagina."regra/consultarUsuario.php" , " TENTATIVA INV&Aacute;LIDA DE BUSCA!", NULL, NULL );
		} else {
			$sql = "SELECT NOME, LOGIN, IDNIVEL, SITUACAO, DATABAIXA FROM USUARIO WHERE IDUSUARIO = ".limpaNumero($_GET['id']);
			if ( conectNumberLines( &$sql ) == 0 ){
				retorna( $pagina."regra/consultarUsuario.php" , " NENHUM USU&Aacute;RIO LOCALIZADO NA BASE DE DADOS!", NULL, NULL );
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
			?>
			<form name="consultarUsuarioRetornoUnico">
				<div align="center">
					<?
						if ( $resp[0][3] == "t" ){
							print '<font color="#00CC00">USU&Aacute;RIO ATIVO NA BASE DE DADOS</font>';
						} else {
							print '<font color="#FF0000">USU&Aacute;RIO INATIVADO EM '.dataBr($resp[0][4]).'</font>';
						}
					?>
				</div>
				<div id="pageServ">
					<div id="pageAlin">
						Nome:
						<input name="nome" id="nome" type="text" maxlength="100" size="100" value="<? print $resp[0][0]; ?>" disabled="disabled">
					</div>
					<div id="pageAlin">
						Login:<br>
						<input name="login" id="login" type="text" maxlength="30" size="20" value="<? print $resp[0][1]; ?>" disabled="disabled">
					</div>
					<div id="pageAlin">
						N&iacute;vel Usu&aacute;rio:<br>
						<?
							$sql = "SELECT DESCRICAO FROM NIVEL WHERE IDNIVEL = ".$resp[0][2];
							$resp = executa( $sql );
						?>
						<input name="nivel" id="nivel" type="text" maxlength="30" size="20" value="<? print $resp[0][0]; ?>" disabled="disabled">
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
		</body>
	</html>
<?
	}
?>