<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<?
			require("includes/title.php");
		?>
	<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
	<div id="logo">
		<h1>
			<a>
				SiFin
			</a>
		</h1>
	</div>
</div>
<div id="content">
	<div id="sidebar">
		<div id="login" class="boxed">
			<?
				$varFoco = 'user';
				if ( $_GET['erro'] != NULL  ){
					switch ($_GET['erro']) {
						case 1:
							print '<h2 class="title">Preencher todos os campos!</h2>';
							break;
						case 2:
							print '<h2 class="title">Preencher a senha!</h2>';
							$varFoco = 'pass'; 
							break;
						case 3:
							print '<h2 class="title">Usuário inválido!</h2>';
							$varFoco = 'user';
							break;
						case 4:
							print '<h2 class="title">Senha inválida!</h2>';
							$varFoco = 'pass';
							break;
						case 5:
							print '<h2 class="title">Usu&aacute;rio inativo!</h2>';
							$varFoco = 'user';
							break;
						default :
							print '<h2 class="title">Sua seção não é válida!</h2>';
							break;
					}
				} else {
					print '<h2 class="title">Acesso ao sistema</h2>';
				}
			?>
			<div class="content">
				<form name="index" id="index" method="post" action="validaLogin.php">
					<fieldset>
					<label for="inputtext1">USER:</label>
					<input type="text" name="user" value="<? print $_GET['user']; ?>" title="Digite o seu usuário do sistema."/>
					<br>
					<label for="inputtext2">PASS:</label>
					<input type="password" name="pass" title="Digite a senha para acesso ao sistema."/>
					<input id="inputsubmit1" type="submit" value="LOGIN" />
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<div id="main">
		<div id="welcome" class="post">
			<p><img src="images/img06.jpg" alt="" width="472" height="180" /></p>
			<div class="story">
				<p>Caro <strong>Colaborador</strong> seja bem vindo(a) !</p>
				<p>Visando uma melhoria no processo da empresa, estamos colocando no ar uma nova forma de controle, caso tenha alguma dúvida, por favor entre em contato conosco.</p>
				<br>
				Att.
				<br><br>
				<p><em>Gerência.</em></p>
			</div>
		</div>
	</div>
</div>
	<?
		require ('includes/rodape.php');
	?>
</body>
</html>
<script>
	document.index.<? print $varFoco; ?>.focus();
</script> 
