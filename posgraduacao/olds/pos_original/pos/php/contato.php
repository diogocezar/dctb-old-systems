<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$acao  = $_GET['acao'];
$id    = $_GET['id'];

$cursoSeleciona = sessionNum($_SESSION['curso']);

switch($acao){
	case 'adicionar' :
		$contato['action'] = "adiciona.php?tipo=contato";
		$contato['nome_botao'] = "btnInserir";
		$contato['label_botao'] = "Adicionar Informações";
		$contato['voltar'] = "javascript:history.go(-1)";
		break;
	
	case 'atualizar' :
		if($_SESSION['permitido'] == 'sim'){
			$contato['action'] = "atualiza.php?tipo=inscricao&id=$id";
			$contato['nome_botao'] = "btnAtualizar";
			$contato['label_botao'] = "Atualizar Informações";
			$contato['voltar'] = "javascript:location.href='administrar.php'"; 
			$sql = "SELECT cur_cod, con_nome, con_telefone, con_celular, con_cidade, con_estado, con_email
			FROM {$tabela['contato']}
			WHERE con_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$contato['nome']          = $dados['con_nome'];
			$contato['telefone']      = $dados['con_telefone'];
			$contato['celular']       = $dados['con_celular'];
			$contato['cidade']        = $dados['con_cidade'];
			$contato['estado']        = $dados['con_estado'];
			$contato['email']         = $dados['con_email'];
			$contato['rua']           = $dados['ins_rua'];
			/* Recuperando curso do banco de dados */
			$cursoSeleciona = $dados['cur_cod'];
		}
		else{
			echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='index.php'</script>";
		}
		break;
}
/* Gerando combo dos cursos */
$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']}";	
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($dados['cur_cod'] != 1){ // 1 : é o curso Administração geral
		$cursos .= "<option value=\"{$dados['cur_cod']}\"";
		if($dados['cur_cod'] == $cursoSeleciona){
			$cursos .= "selected";
		}
		$cursos .= ">".limitaStr(str_replace("Curso de Especialização em ", "", $dados['cur_nome']), 38)."</option>";
	}
}

/* Gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estadoCombo .= "<option value=\"$valor\"";
	$seleciona = $inscricao['estado'];
	if(empty($inscricao['estado'])){
		$seleciona = $estadosPadrao;
	}
	if($valor == $seleciona){
		$estadoCombo .= "selected";
	}
	$estadoCombo .= ">$estado</option>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'formContato.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_form_contato");

	/* Formulario */
		$template->setVariable("form_contato", "formContato");
		$template->setVariable("action", $contato['action']);
	
	/* Titulo */
		$template->setVariable("contato", "Obtenha Maiores Informações");

	/* Titulos dos Campos */	
		$template->setVariable("nome", "Nome");
		$template->setVariable("telefone", "Telefone");
		$template->setVariable("celular", "Celular");
		$template->setVariable("cidade", "Cidade");
		$template->setVariable("estado", "Estado");
		$template->setVariable("email", "Email");
		$template->setVariable("curso", "Curso");
	
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoTelefone", "telefone");
		$template->setVariable("campoCelular", "celular");
		$template->setVariable("campoCidade", "cidade");
		$template->setVariable("comboEstado", "estado");
		$template->setVariable("campoEmail", "email");
		$template->setVariable("comboCurso", "curso");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $contato['nome']);
		$template->setVariable("valorTelefone", $contato['telefone']);
		$template->setVariable("valorCelular", $contato['celular']);
		$template->setVariable("valorCidade", $contato['cidade']);
		$template->setVariable("valorEmail", $contato['email']);
			
	/* Preenchimento dos Combos */
		$template->setVariable("comboCursoOpcoes", $cursos);
		$template->setVariable("comboEstadoOpcoes", $estadoCombo);
		
	/* Botão */
		$template->setVariable("nomeBotao", $contato['nome_botao']);
		$template->setVariable("enviar", $contato['label_botao']);
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "« Voltar");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "validaContato(formContato.nome, formContato.email, formContato)");
		$template->setVariable("onClickVoltar", $contato['voltar']);
		
$template->parseCurrentBlock("bloco_form_contato");

$formulario .= "<br>";
$formulario .= $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	if(empty($cursoSeleciona) || $acao == 'atualizar'){
		$template->setVariable('contatos', $contato[1]);
	}
	else{
		$template->setVariable('contatos', $contato[$cursoSeleciona]);
	}
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Cadastre-se");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $formulario);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	if(empty($cursoSeleciona) || $acao == 'atualizar'){
		foreach($menu['principal'] as $menu => $cont){
			foreach($cont as $link => $titulo){
				$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
			}
		}
	}
	else{
		foreach($menu['interno'] as $menu => $cont){
			foreach($cont as $titulo => $link){
				$link = str_replace('#', "?id=$cursoSeleciona", $link);
				$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
			}
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>