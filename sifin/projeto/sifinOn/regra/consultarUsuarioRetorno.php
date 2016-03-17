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
			?>
			<form name="consultarUsuarioRetorno">
				<div id="pageServ">
					<hr color="#FF0000" />
					<? 
						for ( $i = 0 ; $i < count( $_SESSION['retorno'] ) ; $i++ ) {
					?>
					<div id="pageAlin">
						Usu&aacute;rio:
							<a href="consultarUsuarioRetornoUnico.php?id=<? print $_SESSION['retorno'][$i][0]; ?>">
								<?
									$nome = $_SESSION['retorno'][$i][1];
									if ( strlen( $nome) == 100 ){
										$nome = substr($nome,0,65)."..";
									} 
									print $nome;
								?>
							</a>
					</div>
					<hr color="#FF0000" />
					<?
						}
					?>
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