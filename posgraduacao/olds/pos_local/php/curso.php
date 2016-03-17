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

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

/* Fazendo a verificação no banco de dados se o usuário e/ou senha são válidos */

$permitido = false;

@$session = new Session();

if($_SESSION['permitido'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('cod'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nome');
	$login = $session->retornaSession('login');
	$curso = sessionNum($session->retornaSession('curso_adm'));
	$curso = (int)$curso;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
}



if($id != $curso && $curso != 1){
	echo "<script language=javascript>alert('Você não tem permissão para alterar outros cursos');location.href='administrar.php'</script>";
}

else{
	
	switch($acao){
		case 'adicionar' :
			$cursoCad['action'] = "adiciona.php?tipo=curso";
			$cursoCad['nome_botao'] = "btnInserir";
			$cursoCad['label_botao'] = "Adicionar Curso";
			break;
		
		case 'atualizar' :
			$cursoCad['action'] = "atualiza.php?tipo=curso&id=$id";
			$cursoCad['nome_botao'] = "btnAtualizar";
			$cursoCad['label_botao'] = "Atualizar Curso";
			$sql = "SELECT cur_nome, cur_apresentacao, cur_objetivos, cur_certificado, cur_inicio, cur_termino, cur_periodo_inscricao, cur_periodo_matricula, cur_turno_funcionamento, cur_vagas, cur_complementar, cur_tx_inscricao, cur_matricula, cur_mensalidades, cur_resumo
			FROM {$tabela['cursos']}
			WHERE cur_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$cursoCad['nome']          = $dados['cur_nome'];
			$cursoCad['apresentacao']  = desconverteQuebra($dados['cur_apresentacao']);
			$cursoCad['objetivos']     = desconverteQuebra($dados['cur_objetivos']);
			$cursoCad['certificado']   = desconverteQuebra($dados['cur_certificado']);
			$cursoCad['inicio']        = converteData($dados['cur_inicio']);
			$cursoCad['termino']       = converteData($dados['cur_termino']);
			$cursoCad['periodo_insc']  = $dados['cur_periodo_inscricao'];
			$cursoCad['periodo_matr']  = $dados['cur_periodo_matricula'];
			$cursoCad['turno']         = $dados['cur_turno_funcionamento'];
			$cursoCad['vagas']         = $dados['cur_vagas'];
			$cursoCad['complementar']  = desconverteQuebra($dados['cur_complementar']);
			$cursoCad['tx_inscricao']  = $dados['cur_tx_inscricao'];
			$cursoCad['matricula']     = $dados['cur_matricula'];
			$cursoCad['mensalidade']   = $dados['cur_mensalidades'];
			$cursoCad['resumo']        = desconverteQuebra($dados['cur_resumo']);
			break;
	}

	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'formCurso.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_form_curso");
	
		/* Formulario */
			$template->setVariable("form_curso", "formCurso");
			$template->setVariable("action", $cursoCad['action']);
		
		/* Titulos */
			$template->setVariable("curso", "Curso");
	
		/* Titulos dos Campos */	
			$template->setVariable("nome", "Nome");
			$template->setVariable("inicioCurso", "Início do curso");
			$template->setVariable("terminoCurso", "Término do curso");
			$template->setVariable("periodoInscricao", "Período de inscrição");
			$template->setVariable("periodoMatricula", "Período de matrícula");
			$template->setVariable("turnoFuncionamento", "Turno de funcionamento");
			$template->setVariable("vagas", "Vagas");
			$template->setVariable("txInscricao", "Taxa de inscrição");
			$template->setVariable("matricula", "Matrícula");
			$template->setVariable("mensalidades", "Mensalidades");
			$template->setVariable("apresentacao", "Apresentação");
			$template->setVariable("objetivos", "Objetivos");
			$template->setVariable("certificado", "Certificado");
			$template->setVariable("complementar", "Complementar");
			$template->setVariable("resumo", "Resumo");
			
		/* Nomes dos Campos */
			$template->setVariable("campoNome", "nome");
			$template->setVariable("campoInicioCurso", "inicio");
			$template->setVariable("campoTerminoCurso", "termino");
			$template->setVariable("campoPeriodoInscricao", "periodo_insc");
			$template->setVariable("campoPeriodoMatricula", "periodo_matr");
			$template->setVariable("campoTurnoFuncionamento", "turno");
			$template->setVariable("campoVagas", "vagas");
			$template->setVariable("campoTxInscricao", "taxa");
			$template->setVariable("campoMatricula", "matricula");
			$template->setVariable("campoMensalidades", "mensalidade");
			$template->setVariable("campoApresentacao", "apresentacao");
			$template->setVariable("campoObjetivos", "objetivos");
			$template->setVariable("campoCertificado", "certificado");
			$template->setVariable("campoComplementar", "complementar");
			$template->setVariable("campoResumo", "resumo");
		
		/* Valores dos Campos */
			$template->setVariable("valorNome", $cursoCad['nome']);
			$template->setVariable("valorInicioCurso", $cursoCad['inicio']);
			$template->setVariable("valorTerminoCurso", $cursoCad['termino']);
			$template->setVariable("valorPeriodoInscricao", $cursoCad['periodo_insc']);
			$template->setVariable("valorPeriodoMatricula", $cursoCad['periodo_matr']);
			$template->setVariable("valorTurnoFuncionamento", $cursoCad['turno']);
			$template->setVariable("valorVagas", $cursoCad['vagas']);
			$template->setVariable("valorTxInscricao", $cursoCad['tx_inscricao']);
			$template->setVariable("valorMatricula", $cursoCad['matricula']);
			$template->setVariable("valorMensalidades", $cursoCad['mensalidade']);
			$template->setVariable("valorApresentacao", $cursoCad['apresentacao']);
			$template->setVariable("valorObjetivos", $cursoCad['objetivos']);
			$template->setVariable("valorCertificado", $cursoCad['certificado']);
			$template->setVariable("valorComplementar", $cursoCad['complementar']);
			$template->setVariable("valorResumo", $cursoCad['resumo']);
		
		/* Botão */
			$template->setVariable("nomeBotao", $cursoCad['nome_botao']);
			$template->setVariable("enviar", $cursoCad['label_botao']);
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "« Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaCurso(formCurso.nome, formCurso.inicio, formCurso.termino, formCurso.periodo_insc, formCurso.periodo_matr, formCurso.turno, formCurso.vagas, formCurso.taxa, formCurso.matricula, formCurso.mensalidade, formCurso.apresentacao, formCurso.objetivos, formCurso.certificado, formCurso.resumo, formCurso)");
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
			
	$template->parseCurrentBlock("bloco_form_curso");
	
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
		$template->setVariable('contatos', $contato[1]);
	$template->parseCurrentBlock("bloco_contatos");
	
	/* Bloco Saiba Mais */
	$template->setCurrentBlock("bloco_saiba_mais");
		$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
		$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");
	
	/* Bloco do Titulo da Página Interna */
	$template->setCurrentBlock("bloco_titulo_interna");
		$template->setVariable("titulo", "Área Restrita");
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
		foreach($menu['principal'] as $menu => $cont){
			foreach($cont as $link => $titulo){
				$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
			}
		}
	$template->parseCurrentBlock("bloco_geral");
	
	/* Bloco do Título */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
	$template->show();
}//Else
?>