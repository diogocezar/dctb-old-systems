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
		$inscricao['action'] = "adiciona.php?tipo=inscricao";
		$inscricao['nome_botao'] = "btnInserir";
		$inscricao['label_botao'] = "Adicionar Inscrição";
		$inscricao['voltar'] = "javascript:history.go(-1)";
		break;
	
	case 'atualizar' :
		if($_SESSION['permitido'] == 'sim'){
			$inscricao['action'] = "atualiza.php?tipo=inscricao&id=$id";
			$inscricao['nome_botao'] = "btnAtualizar";
			$inscricao['label_botao'] = "Atualizar Inscrição";
			$inscricao['voltar'] = "javascript:location.href='administrar.php'";
			$sql = "SELECT cur_cod, ins_nome, ins_cpf, ins_rg, ins_orgao_emissor, ins_data_nascimento, ins_estado_civil, ins_rua, ins_numero, ins_complemento, ins_bairro, ins_cidade, ins_estado, ins_cep, ins_telefone, ins_celular, ins_email, ins_quando 
			FROM {$tabela['inscricoes']}
			WHERE ins_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$inscricao['nome']          = $dados['ins_nome'];
			$inscricao['cpf']           = $dados['ins_cpf'];
			$inscricao['rg']            = $dados['ins_rg'];
			$inscricao['orgao_emissor'] = $dados['ins_orgao_emissor'];
			$inscricao['nascimento']    = converteData($dados['ins_data_nascimento']);
			$inscricao['estado_civil']  = $dados['ins_estado_civil'];
			$inscricao['rua']           = $dados['ins_rua'];
			$inscricao['numero']        = $dados['ins_numero'];
			$inscricao['complemento']   = $dados['ins_complemento'];
			$inscricao['bairro']        = $dados['ins_bairro'];
			$inscricao['cidade']        = $dados['ins_cidade'];
			$inscricao['estado']        = $dados['ins_estado'];
			$inscricao['cep']           = $dados['ins_cep'];
			$inscricao['telefone']      = $dados['ins_telefone'];
			$inscricao['celular']       = $dados['ins_celular'];
			$inscricao['email']         = $dados['ins_email'];
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

/* Gerando combo dos estados civis */
foreach($estadosCivis as $atual){
	$estadoCivil .= "<option value=\"$atual\"";
	if($atual == $inscricao['estado_civil']){
		$estadoCivil .= "selected";
	}
	$estadoCivil .= ">$atual</option>";
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

$templateHtmlName = 'formInscricao.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_form_inscricao");

	/* Formulario */
		$template->setVariable("form_inscricao", "formInscri");
		$template->setVariable("action", $inscricao['action']);
	
	/* Titulos */
		$template->setVariable("inscricao", "Faça sua Inscrição");
		$template->setVariable("informacoesPessoais", "Informações Pessoais");
		$template->setVariable("endereco", "Endereço");
		$template->setVariable("contato", "Contato");

	/* Titulos dos Campos */	
		$template->setVariable("curso", "Curso");
		$template->setVariable("nome", "Nome");
		$template->setVariable("cpf", "Cpf");
		$template->setVariable("rg", "Rg");
		$template->setVariable("orgaoEmissor", "Orgão Emissor");
		$template->setVariable("dataNascimento", "Data de nacimento");
		$template->setVariable("estadoCivil", "Estado civil");
		$template->setVariable("rua", "Rua");
		$template->setVariable("numero", "Numero");
		$template->setVariable("complemento", "Complemento");
		$template->setVariable("bairro", "Bairro");
		$template->setVariable("cidade", "Cidade");
		$template->setVariable("estado", "Estado");
		$template->setVariable("cep", "Cep");
		$template->setVariable("telefone", "Telefone");
		$template->setVariable("celular", "Celular");
		$template->setVariable("email", "E-mail");
	
	/* Nomes dos Campos */
		$template->setVariable("comboCurso", "curso");
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoCpf", "cpf");
		$template->setVariable("campoRg", "rg");
		$template->setVariable("campoOrgaoEmissor", "emissor");
		$template->setVariable("campoDataNascimento", "data_nascimento");
		$template->setVariable("comboEstadoCivil", "estado_civil");
		$template->setVariable("campoRua", "rua");
		$template->setVariable("campoNumero", "numero");
		$template->setVariable("campoComplemento", "complemento");
		$template->setVariable("campoBairro", "bairro");
		$template->setVariable("campoCidade", "cidade");
		$template->setVariable("comboEstado", "estado");
		$template->setVariable("campoCep", "cep");
		$template->setVariable("campoTelefone", "telefone");
		$template->setVariable("campoCelular", "celular");
		$template->setVariable("campoEmail", "email");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $inscricao['nome']);
		$template->setVariable("valorCpf", $inscricao['cpf']);
		$template->setVariable("valorRg", $inscricao['rg']);
		$template->setVariable("valorOrgaoEmissor", $inscricao['orgao_emissor']);
		$template->setVariable("valorDataNascimento", $inscricao['nascimento']);
		$template->setVariable("valorRua", $inscricao['rua']);
		$template->setVariable("valorNumero", $inscricao['numero']);
		$template->setVariable("valorComplemento", $inscricao['complemento']);
		$template->setVariable("valorBairro", $inscricao['bairro']);
		$template->setVariable("valorCidade", $inscricao['cidade']);
		$template->setVariable("valorCep", $inscricao['cep']);
		$template->setVariable("valorTelefone", $inscricao['telefone']);
		$template->setVariable("valorCelular", $inscricao['celular']);
		$template->setVariable("valorEmail", $inscricao['email']);	
	
	/* Preenchimento dos Combos */
		$template->setVariable("comboCursoOpcoes", $cursos);
		$template->setVariable("comboEstadoCivilOpcoes", $estadoCivil);
		$template->setVariable("comboEstadoOpcoes", $estadoCombo);
		
	/* Botão */
		$template->setVariable("nomeBotao", $inscricao['nome_botao']);
		$template->setVariable("enviar", $inscricao['label_botao']);
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "« Voltar");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "validaInscricao(formInscri.nome, formInscri.cpf, formInscri.rg, formInscri.emissor, formInscri.data_nascimento, formInscri.rua, formInscri.numero, formInscri.bairro, formInscri.cidade, formInscri.cep, formInscri.telefone, formInscri.email, formInscri)");
		$template->setVariable("onClickVoltar", $inscricao['voltar']);
		
$template->parseCurrentBlock("bloco_form_inscricao");

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
	$template->setVariable("titulo", "Inscrição");
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