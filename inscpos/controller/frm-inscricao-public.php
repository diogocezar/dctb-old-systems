<?php
include("start-brain.php");

/* extraindo variaveis do navegador */
$id_curso = (int)$_GET['curso'];

$contexto      = "inscricao";
$contextoArray = array();

$objRec = $brain_controller[$contexto];
$objRec->__toFillGeneric();

$contextoArray['action'] = "register-public.php?tipo=$contexto";
$contextoArray['titulo'] = "Inserir um Cadastro";

$estados = array("AC" => "Acre",
				 "AL" => "Alagoas",
				 "AM" => "Amazonas",
				 "AP" => "Amap&aacute;",
				 "BA" => "Bahia",
				 "CE" => "Cear&aacute;",
				 "DF" => "Distrito Federal",
				 "ES" => "Espirito Santo",
				 "GO" => "Goi&aacute;s",
				 "MA" => "Maranh&atilde;o",
				 "MG" => "Minas Gerais",
				 "MS" => "Mato Grosso do Sul",
				 "MT" => "Mato Grosso",
				 "PA" => "Par&aacute;",
				 "PB" => "Paraiba",
				 "PE" => "Pernambuco",
				 "PI" => "Piaui",
				 "PR" => "Paran&aacute;",
				 "RJ" => "Rio de Janeiro",
				 "RN" => "Rio Grande do Norte",
				 "RO" => "Rond&ocirc;nia",
				 "RR" => "Roraima",
				 "RS" => "Rio Grande do Sul",
				 "SC" => "Santa Catarina",
				 "SE" => "Sergipe",
				 "SP" => "S&atilde;o Paulo",
				 "TO" => "Tocantins"
				 );

$estadosPadrao = "PR";

/* gerando combo dos estados brasileiros */
foreach($estados as $valor => $estado){
	$estados .= "<option value=\"$valor\"";
	if(empty($seleciona)){
		$seleciona = $estadosPadrao;
	}
	if($valor == $seleciona){
		$estados .= "selected";
	}
	$estados .= ">$estado</option>";
}

/* gerando combo de cursos */
$curso = $brain_controller['curso'];
$curso->__toFillGeneric();
$resultado = $curso->rows(false, false, 1, 'ASC', 'idcurso <> 1 AND ativo = 1');
$cursoCombo .= "<option value=\"NULL\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$cursoCombo .= "<option value=\"".$dados[$curso->campos[0]]."\"";
	if(!empty($id_curso) && $id_curso == $dados[$curso->campos[0]]){
		$cursoCombo .= "selected";
	}
	$cursoCombo .= ">".$dados[$curso->campos[1]]."</option>";
}

/* gerando situação */
if($objRec->getSituacao() == '1'){
	$textoSituacao = 'Ativo';
}
else{
	$textoSituacao = 'Inativo';
}

/* diretório dos templates */
$templateHtmlDir = '../view/html';

$templateHtmlName = "frm-".$contexto.".html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_".$contexto;
		$template->setVariable("form".ucfirst($contexto), $form);
		$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
	
	/* titulos */
		$template->setVariable("titulo".ucfirst($contexto), $contextoArray['titulo']);

	/* nomes dos campos */
		$template->setVariable("campoNome",           "nome_ins");
		$template->setVariable("campoDataNascimento", "data_nascimento_ins");
		$template->setVariable("campoProfissao",      "profissao_ins");
		$template->setVariable("campoCidade",         "cidade_ins");
		$template->setVariable("campoEstado",         "estado_ins");
		$template->setVariable("campoEmail",          "email_ins");
		$template->setVariable("campoTelefone",       "telefone_ins");
		$template->setVariable("campoCelular",        "celular_ins");
		$template->setVariable("campoCursoGrad",      "curso_grag_ins");
		$template->setVariable("campoInstituicao",    "instituicao_ins");
		$template->setVariable("campoAno",            "ano_ins");
		$template->setVariable("campoCurso",          "curso_ins");
		//$template->setVariable("campoDataBaixa",      "data_baixa_ins");
		//$template->setVariable("campoSituacao",       "situacao_ins");
				
	/* preenchendo combo estados */
		$template->setVariable("campoOpcoesCurso", $cursoCombo);
		$template->setVariable("campoOpcoesEstado", $estados);
		
	/* preenchendo data baixa e dada cadastro se existir
		$dataBaixa    = $objRec->getDataBaixa();
		if(!empty($dataBaixa)){
			$template->setCurrentBlock("bloco_formulario_data_baixa");
				$template->setVariable("campoDataBaixa", "data_baixa");
				$template->setVariable("valorDataBaixa",  desconverteData($dataBaixa));
			$template->parseCurrentBlock("bloco_formulario_data_baixa");
		}
	*/
		
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.nome.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$content = $template->get();

$title   = $contextoArray['titulo'];

/* incluindo conteudo na página interna */
$instrucoes = "Atenção: o cadastro será enviado para a secretaria do curso e consiste em um registro dos interessados no curso; a inscrição somente será efetivada com o pagamento da taxa de inscrição e o envio dos documentos para a secretaria.";
include('inside-include-public.php');
?>