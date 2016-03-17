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

@$session = new Session();

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_SESSION['codSession'];

$permitido = false;

if($_SESSION['usuarioSession'] == 'sim' || $_SESSION['permitido'] == 'sim'){
	$permitido = true;
}

switch($acao){
	default :
		$cliente['action'] = "adiciona.php?tipo=cliente";
		$cliente['titulo'] = "Novo cadastro";
		break;
	
	case 'atualizar' :
		if($permitido != true){
			echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
		}
		else{
			$cliente['action'] = "atualiza.php?tipo=cliente&id=$id";
			$cliente['titulo'] = "Atualizando cadastro";
			$sql = "SELECT cli.cli_cpf, cli.usu_cod, cli.cli_rg, cli.cli_rua, cli.cli_numero, cli.cli_bairro, cli.cli_complemento, cli.cli_telefone, cli.cli_celular, 
			               cli.cli_data_nascimento, cli.txe_cod, 
						   usu.usu_cod, usu.ema_id, usu.usu_nome, usu.usu_sobrenome, usu.usu_login, usu.usu_senha, usu.tip_id_user
			FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli
			WHERE cli.cli_cpf = '$id' AND cli.usu_cod = usu.usu_cod";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$cliente['nome']          = $dados['usu_nome'];
			$cliente['sobrenome']     = $dados['usu_sobrenome'];
			$cliente['email']         = retornaEmail($dados['ema_id']);
			$cliente['news']          = retornaNews($dados['ema_id']);
			$cliente['login']         = $dados['usu_login'];
			$cliente['senha']         = $dados['usu_senha'];
			$cliente['tip_id_user']   = $dados['tip_id_user'];
			
			$cliente['cpf']           = $dados['cli_cpf'];
			$cliente['rg']            = $dados['cli_rg'];
			$cliente['rua']           = $dados['cli_rua'];
			$cliente['numero']        = $dados['cli_numero'];
			$cliente['bairro']        = $dados['cli_bairro'];
			$cliente['complemento']   = $dados['cli_complemento'];
			
			$cliente['telefone']      = $dados['cli_telefone'];
			$cliente['telefone_cel']  = $dados['cli_celular'];
			$cliente['nascimento']    = converteData($dados['cli_data_nascimento']);
			$cliente['taxa']          = $dados['txe_cod'];
		}
		break;
}

/* Gerando combo das localizações */
$sql = "SELECT txe_cod, txe_localizacao, txe_valor FROM {$tabela['taxa_entrega']} ORDER BY txe_localizacao";
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$taxa .= "<option value=\"{$dados['txe_cod']}\"";
	if($dados['txe_cod'] == $cliente['taxa']){
		$taxa .= "selected";
	}
	$taxa .= ">{$dados['txe_localizacao']} (R$ ".number_format($dados['txe_valor'],2,',','.').")</option>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formCliente.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_cliente");

	/* Botões */
		$template->setVariable("linkEnviar",  "#");
		$template->setVariable("altEnviar", "Enviar !");
		$template->setVariable("linkVoltar", "#");
		$template->setVariable("altVoltar", "Voltar !");

	/* Titulos */
		$template->setVariable("tituloDadosPessoais", "Dados Pessoais");
		$template->setVariable("tituloCadastro", "Cadastro");

	/* Formulario */
		$template->setVariable("formCliente", "form_cliente");
		$template->setVariable("actionCliente", $cliente['action']);
	
	/* Nomes dos Campos */
		$template->setVariable("campoNome",  "nome");
		$template->setVariable("campoSobre", "sobrenome");
		$template->setVariable("campoEmail", "email");
		$template->setVariable("checkNovidades", "news");
		$template->setVariable("campoCpf", "cpf");
		$template->setVariable("campoRg", "rg");
		$template->setVariable("campoRua",  "rua");
		$template->setVariable("campoNumero", "numero");
		$template->setVariable("campoBairro", "bairro");
		$template->setVariable("campoComplemento", "complemento");
		$template->setVariable("campoTelefone", "telefone");
		$template->setVariable("campoCelular",  "celular");
		$template->setVariable("campoDataNasc", "data_nascimento");
		$template->setVariable("comboLoc", "localizacao");
		$template->setVariable("campoLogin", "login");
		$template->setVariable("campoSenha",  "senha");
		$template->setVariable("campoConfi",  "confi");
		
	/* Valores dos Campos */
		$template->setVariable("valorNome",  $cliente['nome']);
		$template->setVariable("valorSobre", $cliente['sobrenome']);
		$template->setVariable("valorEmail", $cliente['email']);
		$template->setVariable("valorLogin", $cliente['login']);
		$template->setVariable("valorSenha", $cliente['senha']);
		$template->setVariable("valorConfi", $cliente['senha']);
		$template->setVariable("valorCpf", $cliente['cpf']);
		$template->setVariable("valorRg", $cliente['rg']);
		$template->setVariable("valorRua",  $cliente['rua'] );
		$template->setVariable("valorNumero", $cliente['numero']);
		$template->setVariable("valorBairro", $cliente['bairro']);
		$template->setVariable("valorComplemento", $cliente['complemento']);
		$template->setVariable("valorTelefone", $cliente['telefone']);
		$template->setVariable("valorCelular",  $cliente['telefone_cel']);
		$template->setVariable("valorDataNasc", $cliente['nascimento']);
	
	/* Marcando ou não o checkbox das novidades */
		if($cliente['news'] == "Sim" || empty($cliente['news'])){
			$template->setVariable("opNovidades", "checked=\"checked\"");
		}
		
	/* Desabilitando CPF e RG caso de atualização */
		if($acao == "atualizar"){
			$template->setVariable("habilita", "disabled=\"disabled\"");
		}
	
	/* Preenchendo Combo */
		$template->setVariable("comboLocOpcoes", $taxa);
				
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "validaCadastro(form_cliente.nome, form_cliente.sobrenome, form_cliente.email, form_cliente.login, form_cliente.senha, form_cliente.confi, form_cliente.cpf, form_cliente.rg, form_cliente.rua, form_cliente.numero, form_cliente.bairro, form_cliente.telefone, form_cliente.data_nascimento, form_cliente)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");

$template->parseCurrentBlock("bloco_cliente");

$show = $template->get();

/* Título da Página Interna */
$tituloInterna = $cliente['titulo'];

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