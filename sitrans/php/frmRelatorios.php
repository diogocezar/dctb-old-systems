<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include funções ajax
*/
include("../ajax/ajax.php");

/**
* incluindo controle de sessão
*/
include("../php/controlaSession.php");

/* extraindo variaveis do navegador */
$id  = $_GET['id'];

$contexto = "relatorios";

/* gerando combo de tipos */
foreach($relTipos as $key => $tipo){
	$tiposCombo .= "<option value=\"".$key."\">".$tipo."</option>";
}

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frm".ucfirst($contexto).".html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	

$contextoArray['action'] = "frmGeraRelatorios.php";
$contextoArray['titulo'] = "Aplicativo para Geração de Relatórios";

/* gerando combo de fornecedores */
$fornecedor = $controlador['fornecedor'];
$fornecedor->__toFillGeneric();
$resultado = $fornecedor->_list('fornecedor');
$fornecedorCombo .= "<option value=\"\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$fornecedorCombo .= "<option value=\"".$dados[$fornecedor->campos[0]]."\"";
	$fornecedorCombo .= ">".$dados[$fornecedor->campos[4]]."</option>";
}

/* gerando combo de clientes */
$cliente = $controlador['cliente'];
$cliente->__toFillGeneric();
$resultado = $cliente->_list('cliente');
$clienteCombo .= "<option value=\"\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$clienteCombo .= "<option value=\"".$dados[$cliente->campos[0]]."\"";
	$clienteCombo .= ">".$dados[$cliente->campos[3]]." - ".$dados['telefone']."</option>";
}

/* gerando combo de veículos */
$veiculo = $controlador['veiculo'];
$veiculo->__toFillGeneric();
$resultado = $veiculo->_list();
$veiculoCombo .= "<option value=\"\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$veiculoCombo .= "<option value=\"".$dados[$veiculo->campos[0]]."\"";
	$veiculoCombo .= ">".$dados[$veiculo->campos[3]]." - ".$dados['nome']."</option>";
}

/* gerando combo de usuários */
$usuario = $controlador['usuario'];
$usuario->__toFillGeneric();
$resultado = $usuario->_list();
$usuarioCombo .= "<option value=\"\"></option>";
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$usuarioCombo .= "<option value=\"".$dados[$usuario->campos[0]]."\"";
	$usuarioCombo .= ">".$dados[$usuario->campos[2]]."</option>";
}
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_".$contexto;
		$template->setVariable("form".ucfirst($contexto), $form);
		$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
	
	/* titulos */
		$template->setVariable("titulo".ucfirst($contexto), $contextoArray['titulo']);

	/* nomes dos campos */	
		$template->setVariable("campoTipoRelatorio", "tipo");
		$template->setVariable("campoDataDe", "datade");
		$template->setVariable("campoDataAte", "dataate");
		
	/* label dos campos */
		$template->setVariable("campoDataDeName",  "data_de");
		$template->setVariable("campoDataAteName", "data_ate");
		$template->setVariable("campoCliente",     "cliente");
		$template->setVariable("campoVeiculo",     "veiculo");
		$template->setVariable("campoFornecedor",  "fornecedor");
		$template->setVariable("campoUsuario",     "usuario");
		
	/* radio buttons */
		$template->setVariable("opData", "tipo_data");
		
	/* preenchendo combos */
		$template->setVariable("campoOpcoesTipoRelatorio", $tiposCombo);
		$template->setVariable("valorOpCadastro", "datacadastro");
		$template->setVariable("valorOpColeta", "datacoleta");
		
	/* preenchendo combos dinâmicos */
		$template->setVariable("campoOpcoesVeiculo", $veiculoCombo);
		$template->setVariable("campoOpcoesFornecedor", $fornecedorCombo);
		$template->setVariable("campoOpcoesCliente",    $clienteCombo);
		$template->setVariable("campoOpcoesUsuario",    $usuarioCombo);
		
	/* javascripts */
		$template->setVariable("clickCadastro", "makeUnChecked('datacoleta');makeChecked('datacadastro')");
		$template->setVariable("clickColeta", "makeUnChecked('datacadastro');makeChecked('datacoleta')");
		
	/* Values */
		$template->setVariable("CampoDataDeValue", date("d/m/Y"));
		$template->setVariable("CampoDataAteValue", date("d/m/Y"));
						
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.tipo.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$carregaRelatorios = true;

$conteudo = $template->get();

$titulo   = $contextoArray['titulo'];

$exiteAjax = true;

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>