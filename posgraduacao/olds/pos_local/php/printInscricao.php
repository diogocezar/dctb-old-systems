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

//$numInscri = sessionNum($_SESSION['numero_inscricao']);
$numInscri = $_GET['ni'];

if(empty($numInscri)){
	echo "<script language=javascript>alert('É necessário uma identificação para imprimir uma inscrição.');location.href='index.php'</script>";
}

$inscricao['action'] = "atualiza.php?tipo=inscricao&id=$id";
$inscricao['nome_botao'] = "btnAtualizar";
$inscricao['label_botao'] = "Atualizar Inscrição";
$inscricao['voltar'] = "javascript:location.href='administrar.php'";
$sql = "SELECT cur_cod, ins_nome, ins_cpf, ins_rg, ins_orgao_emissor, ins_graduacao, ins_data_nascimento, ins_estado_civil, ins_rua, ins_numero, ins_complemento, ins_bairro, ins_cidade, ins_estado, ins_cep, ins_telefone, ins_celular, ins_email, ins_quando 
FROM {$tabela['inscricoes']}
WHERE ins_cod = $numInscri";	
$resultado = $dataBase->query($sql);
$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
$inscricao['nome']          = strtoupper($dados['ins_nome']);
$inscricao['cpf']           = strtoupper($dados['ins_cpf']);
$inscricao['rg']            = strtoupper($dados['ins_rg']);
$inscricao['orgao_emissor'] = strtoupper($dados['ins_orgao_emissor']);
$inscricao['nascimento']    = strtoupper(converteData($dados['ins_data_nascimento']));
$inscricao['estado_civil']  = strtoupper($dados['ins_estado_civil']);
$inscricao['graduacao']     = strtoupper($dados['ins_graduacao']);
$inscricao['rua']           = strtoupper($dados['ins_rua']);
$inscricao['numero']        = strtoupper($dados['ins_numero']);
$inscricao['complemento']   = strtoupper($dados['ins_complemento']);
$inscricao['bairro']        = strtoupper($dados['ins_bairro']);
$inscricao['cidade']        = strtoupper($dados['ins_cidade']);
$inscricao['estado']        = strtoupper($dados['ins_estado']);
$inscricao['cep']           = strtoupper($dados['ins_cep']);
$inscricao['telefone']      = strtoupper($dados['ins_telefone']);
$inscricao['celular']       = strtoupper($dados['ins_celular']);
$inscricao['email']         = strtoupper($dados['ins_email']);
/* Recuperando curso do banco de dados */
$cursoSeleciona = $dados['cur_cod'];

$curso = strtoupper(retornaNomaCurso($dados['cur_cod']));


/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'printInscricao.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_inscricao");
	
	/* Valores dos Campos */
		$template->setVariable("valorCurso",$curso);
		$template->setVariable("valorNome", $inscricao['nome']);
		$template->setVariable("valorCpf", $inscricao['cpf']);
		$template->setVariable("valorRg", $inscricao['rg']);
		$template->setVariable("valorOrgaoEmissor", $inscricao['orgao_emissor']);
		$template->setVariable("valorDataNascimento", $inscricao['nascimento']);
		$template->setVariable("valorEstadoCivil", $inscricao['estado_civil']);
		$template->setVariable("valorGraduacao", $inscricao['graduacao']);
		$template->setVariable("valorRua", $inscricao['rua']);
		$template->setVariable("valorNumero", $inscricao['numero']);
		$template->setVariable("valorComplemento", $inscricao['complemento']);
		$template->setVariable("valorBairro", $inscricao['bairro']);
		$template->setVariable("valorCidade", $inscricao['cidade']);
		$template->setVariable("valorEstado", $inscricao['estado']);
		$template->setVariable("valorCep", $inscricao['cep']);
		$template->setVariable("valorTelefone", $inscricao['telefone']);
		$template->setVariable("valorCelular", $inscricao['celular']);
		$template->setVariable("valorEmail", $inscricao['email']);	
		
$template->parseCurrentBlock("bloco_inscricao");

$template->show();
?>