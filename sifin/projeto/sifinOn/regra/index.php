<?
	include_once ("../includes/sessao.php");
	if ( $_SESSION['nivel'] != NULL ){
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
			<div id="pageServ">
				
			</div>
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