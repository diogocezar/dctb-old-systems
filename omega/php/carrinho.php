<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Adicionando ítens na $_SESSION */

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Você prescisa estar logado para ter acesso à suas compras.');location.href='index.php'</script>";
	exit();
}
else{
	$cod = $session->retornaSession('codSession');
}

/* Resgatando variaveis de $_GET */

$id   = $_GET['id'];
$tipo = $_GET['tipo'];
$acao = $_GET['acao'];


/* Verificando se há algo para excluir/alterar */

switch($acao){
	case 'excluir':
	
		$excluirProd = $_POST['checkProd'];
		$excluirFilm = $_POST['checkFilm'];
		
		if(!empty($excluirProd)){
			for($i=0; $i<sizeof($excluirProd); $i++) {
				$indice = $excluirProd[$i];
				unset($_SESSION['produtos'][$indice]);
			}
		}
		
		if(!empty($excluirFilm)){
			for($i=0; $i<sizeof($excluirFilm); $i++) {
				$indice = $excluirFilm[$i];
				unset($_SESSION['filmes'][$indice]);
			}
		}
		
	 	break;
	case 'atualizar':
	
		$atualizarProdutos = $_POST['aProd'];
		$atualizarFilmes = $_POST['aFilm'];
		
		if(!empty($atualizarProdutos)){		
			$chaveProdutos = array_keys($atualizarProdutos);
			
			for($i=0; $i<sizeof($chaveProdutos); $i++) {
			   $indice = $chaveProdutos[$i];
			   $_SESSION['produtos'][$indice]['qtd'] =  $atualizarProdutos[$indice]['qtd'];
			}
		}
		
		if(!empty($atualizarFilmes)){
			$chaveFilmes = array_keys($atualizarFilmes);
			
			for($i=0; $i<sizeof($chaveFilmes); $i++) {
			   $indice = $chaveFilmes[$i];
			   $_SESSION['filmes'][$indice]['qtd']   =  $atualizarFilmes[$indice]['qtd'];
			   
			}
		}

		break;
}

$keyProd = $_SESSION['key_pro'];

$keyFilm = $_SESSION['key_fil'];

switch($tipo){
	case 'produto' :
	
		$nome  = retornaNomeProduto($id);
		$preco = retornaPrecoProduto($id);
		$qtd   = $_GET['qtd'];
		
		/* Procura para verificar se o produto já está inserido */
		
		$trava_inclusao = false;
		
		if(!empty($_SESSION['produtos'])){
			foreach($_SESSION['produtos'] as $indice => $valor){
				if($id == $valor['cod']){
					$trava_inclusao = true;
				}
			}
		}
		
		if(!$trava_inclusao){
		
			if(empty($qtd)){
				$qtd = 1;
			}
			
			if(empty($keyProd)){
				$keyProd = 1;
				$_SESSION['key_pro'] = 1;
			}
			else{
				$keyProd++;
				$_SESSION['key_pro']++;
			}
			
			$_SESSION['produtos'][$keyProd]['cod']   = $id;
			$_SESSION['produtos'][$keyProd]['nome']  = $nome;
			$_SESSION['produtos'][$keyProd]['preco'] = $preco;
			$_SESSION['produtos'][$keyProd]['qtd']   = $qtd;
			
		}
		
		break;
		
	case 'filme' :
	
		/* Verificando se o usuário já locou determinado filme */

		$qtdLocou = qtdLocouFilme($cod, $id);
		
		if($qtdLocou > 0){
			echo "<script language=javascript>
			      if(!confirm('ATENÇÃO : ".'\n\n'."Você já locou esse filme $qtdLocou veze(s), deseja loca-lo novamente ?')){
				  	location.href='index.php';
				  }
				  </script>";
		}
	
		$nome  = retornaNomeFilme($id);
		$preco = retornaPrecoFilme($id);
		$qtd   = 1;
		
		/* Procura para verificar se o filme já está inserido */
		
		$trava_inclusao = false;
		
		if(!empty($_SESSION['filmes'])){
			foreach($_SESSION['filmes'] as $indice => $valor){
				if($id == $valor['cod_filme']){
					$trava_inclusao = true;
				}
			}
		}
		
		if(!$trava_inclusao){
			if(empty($keyFilm)){
				$keyFilm = 1;
				$_SESSION['key_fil'] = 1;
			}
			else{
				$keyFilm++;
				$_SESSION['key_fil']++;
			}
			$_SESSION['filmes'][$keyFilm]['cod_filme']   = $id;
			$_SESSION['filmes'][$keyFilm]['cod_midia']   = midiaDisponivel($id);
			$_SESSION['filmes'][$keyFilm]['nome']        = $nome;
			$_SESSION['filmes'][$keyFilm]['preco']       = $preco;
			$_SESSION['filmes'][$keyFilm]['qtd']         = $qtd;
		}
			
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'pedido.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco dos Produtos */
$total = 0;
$qtdProdutos = 0;
$qtdFilmes   = 0;
if(!empty($_SESSION['produtos'])){
	foreach($_SESSION['produtos'] as $indice => $valor){
		$template->setCurrentBlock("bloco_pedido_prod");
			$preco = $valor['preco'];
			$qtd   = $valor['qtd'];
			$nome  = $valor['nome'];
			$subtotal = $qtd*$preco;
			$total += $subtotal;
			$qtdProdutos += $qtd;
			$template->setVariable("checkProdutos", "checkProd[]");
			$template->setVariable("valorProduto", $indice);
			$template->setVariable("qtdProdutos", "aProd[$indice][qtd]");
			$template->setVariable("valorQtd", $qtd);
			$template->setVariable("prod", $nome);
			$template->setVariable("valor", number_format($preco,2,',','.'));
			$template->setVariable("subtotal", number_format($subtotal,2,',','.'));
			$template->parseCurrentBlock("bloco_pedido_prod");
	}
}

/* Bloco dos Filmes */
if(!empty($_SESSION['filmes'])){
	foreach($_SESSION['filmes'] as $indice => $valor){
		$template->setCurrentBlock("bloco_pedido_filme");
			$preco = $valor['preco'];
			$qtd   = $valor['qtd'];
			$nome  = "<a href = \"mostraFilme.php?id={$valor['cod_filme']}\">".$valor['nome']."</a>";
			$subtotal = $qtd*$preco;
			$total += $subtotal;
			$qtdFilmes += $qtd;
			$template->setVariable("checkProdutos", "checkFilm[]");
			$template->setVariable("valorProduto", $indice);
			$template->setVariable("qtdProdutos", "aFilm[$indice][qtd]");
			$template->setVariable("valorQtd", $qtd);
			$template->setVariable("prod", $nome);
			$template->setVariable("valor", number_format($preco,2,',','.'));
			$template->setVariable("subtotal", number_format($subtotal,2,',','.'));
		$template->parseCurrentBlock("bloco_pedido_filme");
	}
}

$template->setCurrentBlock("bloco_pedido");
		$template->setVariable("linkContinuar", "index.php");
		$template->setVariable("linkEfetuar", "finalizar.php");
		$template->setVariable("formProdutos", "form_produtos");
		$template->setVariable("linkExcluir", "#");
		$template->setVariable("linkAtualizar", "#");
		$template->setVariable("altAtualizar", "Atualizar !");
		$template->setVariable("altExcluir", "Excluir !");
		$template->setVariable("onClickExcluir", "exclui(form_produtos)");
		$template->setVariable("onClickAtualizar", "atualiza(form_produtos)");
		$template->setVariable("total", number_format($total,2,',','.'));
		$template->setVariable("status_pendente", $situacao[3]);
$template->parseCurrentBlock("bloco_pedido");

$show = $template->get();
$show .= "<br>";

/* Adicionando na session para exibição no painel de compras */
$_SESSION['qtd_filmes'] = $qtdFilmes;
$_SESSION['qtd_conveniencia'] = $qtdProdutos;
$_SESSION['val_total'] = $total;

/* Título da Página Interna */
$tituloInterna = "Carrinho de Compras";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Login */
$template->setCurrentBlock("bloco_login");
	if($_SESSION['usuarioSession'] != 'sim'){
		/* Bloco Login Deslogado */
			$template->setVariable("abreForm", "<form action=\"loginUser.php\" method=\"post\" name=\"form_login\" id=\"form_login\">");
			$template->setVariable("conteudo", "Usuário <input name=\"usuario\" type=\"text\" class=\"form\" size=\"10\" onkeypress=\"pulaCampoNoEnter(senha)\"> Senha <input name=\"senha\" type=\"password\" class=\"form\" value=\"\" size=\"10\" onkeypress=\"enviaFormNoEnter(form_login)\">
												<a href=\"#\"><img src=\"../images/seta_go.jpg\" alt=\"Logar\" width=\"34\" height=\"24\" border=\"0\" align=\"absmiddle\" onClick=\"entrar(form_login.usuario, form_login.senha, form_login)\"></a>&nbsp;");
			$template->setVariable("fechaForm", "</form>");
	}
	else{
		/* Bloco Login Logado */
			$template->setVariable("conteudo", "Bem vindo(a), <span class=\"texto4\">".$_SESSION['nomeSession']."</span>&nbsp;&nbsp;&nbsp;<br><b><a href = \"minhaConta.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_minha','','../images/bot_minhaconta_rol.gif',1)\"><img src=\"../images/bot_minhaconta.gif\" name=\"img_minha\" border=\"0\" alt=\"Minha conta !\"/></a>
																																		  <a href = \"logout.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_sair_login','','../images/bot_logout_rol.gif',1)\"><img src=\"../images/bot_logout.gif\" name=\"img_sair_login\" border=\"0\"  alt=\"Sair !\"/></a>&nbsp;&nbsp;&nbsp;");
	}
$template->parseCurrentBlock("bloco_login");

/* Bloco Busca */
$template->setCurrentBlock("bloco_busca");
	$template->setVariable("actionBusca", "busca.php");
	$template->setVariable("formBusca", "form_busca");
	$template->setVariable("comboGenero", "genero");
	
	/* Recupera os gêneros cadastrados */
	$sql = "SELECT gen_cod, gen_nome FROM {$tabela['genero']} ORDER BY gen_nome";
	$resultado = $dataBase->query($sql);
	$generos = "<option value=\"-1\">Todos</option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$generos .= "<option value=\"{$dados['gen_cod']}\"";
		$generos .= ">{$dados['gen_nome']}</option>";
	}
	
	$template->setVariable("comboGeneroOpcoes", $generos);
	
	/* Pega do array o buscar por... */

	foreach($buscarPor as $indice => $valor){
		$por .= "<option value=\"$indice\"";
		$por .= ">$valor</option>";
	}
	
	$template->setVariable("comboPor", "por");
	$template->setVariable("comboPorOpcoes", $por);
	
	$template->setVariable("campoNome", "nome");
	$template->setVariable("altBusca", "Buscar !");
	$template->setVariable("linkVejaTodos", "listarTodos.php");
	$template->setVariable("onClickBusca", "buscar(form_busca.nome, form_busca)");
	$template->setVariable("linkBuscar", "#");
$template->parseCurrentBlock("bloco_busca");

/* Bloco Carrinho */
$template->setCurrentBlock("bloco_carrinho");
	$template->setVariable("qtdF", number_format($_SESSION['qtd_filmes'], 0));
	$template->setVariable("qtdC", number_format($_SESSION['qtd_conveniencia'], 0));
	$template->setVariable("valorTotal", "R$ ".number_format($_SESSION['val_total'], 2, ',','.'));
	$template->setVariable("linkFim", "#");
	$template->setVariable("onClickFim", "javascript:location.href='finalizar.php'");
	$template->setVariable("altFim", "Finalizar Pedido !");
$template->parseCurrentBlock("bloco_carrinho");

/* Bloco Parceiros */
$template->setCurrentBlock("bloco_parceiros");
	foreach($parceiros as $indice => $valor){
		$parc .= "<a href =\"{$valor[1]}\"><img src=\"{$valor[0]}\" width=\"213\" height=\"52\" alt=\"$indice\" border=\"0\"></a><br>";
	}
	$template->setVariable("parceiros", $parc);
$template->parseCurrentBlock("bloco_parceiros");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("titulo_interno", $tituloInterna);
	$template->setVariable("conteudo_interno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menu, $titulo);
			$lnk = strtoupper($menu[0]).substr($menu, 1, strlen($menu));
			$template->setVariable("link".$lnk, $link);
		}
	}
	
	/* Login */
	$template->setVariable("linkCadastreSe", "cadastrese.php");
	$template->setVariable("linkEsqueci", "esqueci.php");
	$template->setVariable("altCadastreSe", "Cadastre-se !");
	$template->setVariable("altEsqueci", "Esqueceu a senha ?");
	
	/* Kreea */
	$template->setVariable("linkKreea", "http://www.kreea.com.br");
	
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>