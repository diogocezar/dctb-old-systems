<?
	include_once ("../includes/sessao.php");
	if ( $_SESSION['nivel'] == 1 ){
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
			<form name="alterarUsuario" method="post" action="alterarUsuarios.php">
				<div id="pageServ">
					<div id="pageAlin">
						Nome:
						<input name="nome" id="nome" type="text" maxlength="100" size="100" value="<? print $_GET['nome']; ?>">
					</div>
					<div id="pageAlin">
						Login:<br>
						<input name="login" id="login" type="text" maxlength="30" size="20" value="<? print $_GET['login']; ?>">
					</div>
					<div id="pageAlin">
						N&iacute;vel Usu&aacute;rio:<br>
						<select name="nivel" id="nivel">
							<option value="">
								>> N&Iacute;VEL DO USU&Aacute;RIO << 													
							</option>
							<?
								require ("../includes/conexao.php");
								$sql = "SELECT IDNIVEL, DESCRICAO FROM NIVEL ORDER BY DESCRICAO";
								$resp = executa( $sql );
								for ( $i = 0 ; $i < count( $resp ) ; $i++ ) {
							?>
							<option value="<? print $resp[$i][0]; ?>" <? if ( $_GET['nivel'] == $resp[$i][0] ) print 'selected="selected"'; ?> >
								<?
									print $resp[$i][1];
								?> 
							</option>
							<?
								}
							?>
						</select>
					</div>
					<div align="center">
						<input name="Consultar" type="submit" value="Consultar">
						<input name="Limpar" type="reset" value="Limpar" onClick="document.alterarUsuario.nome.focus();">
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
			<?
				if ( $_GET['foco'] == NULL ){
					$foco = "nome";
				} else {
					$foco = $_GET['foco'];
				}
			?>
			document.alterarUsuario.<? print $foco;?>.focus();
			</script>
		</body>
	</html>
<?
	} else {
		header ( "Location: http://sifin.xbrain.com.br?erro=default" );
	}
?>