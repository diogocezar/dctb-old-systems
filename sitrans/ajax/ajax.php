<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getContacts", "alterarSenha", "alterarSenhaContato", "getCheckColeta", "getStatusManifesto", "sessionManifesto", "checkSession", "changeStatusConhecimento", "returnDataCnpf", "getCep");
sajax_handle_client_request();

/**
 * Função que retorna os contatos de um cliente, utilizado em: frmColeta.php
 */
function getContacts($id){

	global $controlador;
	global $camposMap;

	$objContato = $controlador['contato'];
	$objContato->__toFillGeneric();
	
	$objCliente = $controlador['cliente'];
	$objCliente->__toFillGeneric();
	$objCliente->__get_db($id);
	
	$idPessoa  = $objCliente->getIdpessoa();
	
	$acao = $_GET['acao'];
	if($acao == 'atualizar'){
		$idColeta = $_GET['id'];
		$objColeta = $controlador['coleta'];
		$objColeta->__toFillGeneric();
		$objColeta->__get_db($idColeta);
		$idContato = $objColeta->getIdcontato();
	}
		
	$resultado = $objContato->listPeoples($idPessoa);
	$retorno  .= '<select id="frm_obg_contato" name="contato" class="formDrop">';
	$retorno  .= '<option value=""></option>';
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$retorno  .= '<option value="'.$dados[$camposMap['contato'][0]].'"';
		if($idContato == $dados[$camposMap['contato'][0]]){
			$retorno  .= "selected=\"selected\"";
		}
		$retorno  .= '">'.$dados[$camposMap['contato'][2]].'</option>';
	}
	$retorno  .= '</select>';
	return rawurlencode($retorno);
}

/**
 * Função que que altera a senha de um usuário, utilizado em todas as páginas.
 */
function alterarSenha($senhaAntiga, $novaSenha){
	global $controlador;
	global $camposMap;
	
	$senhaAntiga = strtoupper($senhaAntiga);
	$novaSenha   = strtoupper($novaSenha);
	
	$idUsuarioLogado = $_SESSION['sessId'];

	$objUsuario = $controlador['usuario'];
	$objUsuario->__toFillGeneric();
	$objUsuario->__get_db($idUsuarioLogado);
	
	$senhaCadastrada = $objUsuario->getSenha();
	
	if($senhaAntiga != $senhaCadastrada){
		return rawurlencode("A senha digitada não confere com a cadastrada no banco de dados.");
		exit;
	}
	else{
		$objUsuario->setSenha($novaSenha);
		$objUsuario->setDatabaixa('NULL');
		$objUsuario->update();
		return rawurlencode("A senha foi alterada com sucesso!");
	}
}

/**
 * Função que altera a senha quando a opção de interface clientes está acionada. Utilizada em todas as páginas (cliente).
 */
function alterarSenhaContato($senhaAntiga, $novaSenha){
	global $controlador;
	global $camposMap;
	
	$senhaAntiga = strtoupper($senhaAntiga);
	$novaSenha   = strtoupper($novaSenha);
	
	$idContatoLogado = $_SESSION['sessIdContato'];

	$objContato = $controlador['contato'];
	$objContato->__toFillGeneric();
	$objContato->__get_db($idContatoLogado);
	
	$senhaCadastrada = $objContato->getSenha();
	
	if($senhaAntiga != $senhaCadastrada){
		return rawurlencode("A senha digitada não confere com a cadastrada no banco de dados.");
		exit;
	}
	else{
		$objContato->setSenha($novaSenha);
		$objContato->setDatabaixa('NULL');
		$objContato->update();
		return rawurlencode("A senha foi alterada com sucesso!");
	}
}

/**
 * Função que verifica se uma coleta já foi cadastrada para um cliente em uma data, usado em frmColeta.php
 */
function getCheckColeta($idCliente, $data){
	global $controlador;
	global $camposMap;
	
	$objColeta = $controlador['coleta'];
	$objColeta->__toFillGeneric();
	$retorno = $objColeta->checkClienteData($idCliente, $data);
	return ($retorno);
}

/**
 * Função que retorna a diferença entre: qtd de conhecimentos, peso, volumes, nota fical e frete dos conhecimentos para determinado manifesto. Utilizado em frmManifesto.php
 */
function getStatusManifesto($codigo, $op){
	global $controlador;
	global $camposMap;
	
	$objManifesto = $controlador['manifesto'];
	$objManifesto->__toFillGeneric();
	$id = str_replace("M", "", $codigo);
	$objManifesto->__get_db($id);
	
	$manifestoConhecimento = $objManifesto->getTotalctrc();
	$manifestoPeso         = $objManifesto->getTotalpeso();
	$manifestoVolumes      = $objManifesto->getTotalvolumes();
	$manifestoTotalNF      = $objManifesto->getValortotalnf();
	$manifestoTotalFrete   = $objManifesto->getValortotalfrete();

	
	$objConhecimento = $controlador['conhecimento'];
	$objConhecimento->__toFillGeneric();
	
	$totalConhecimento = $objConhecimento->getCountCtrcWithMan($id);
	$totalPeso         = $objConhecimento->getSumPesoWithMan($id);
	$totalVolumes      = $objConhecimento->getSumVolWithMan($id);
	$totalNotaFiscal   = $objConhecimento->getSumNfWithMan($id);
	$totalFrete        = $objConhecimento->getSumFreteWithMan($id);
	
	$resultado = "";
	
	switch($op){
		case 'ctrc':
			$resultadoTotalConhecimento = ($manifestoConhecimento - $totalConhecimento);
			if($resultadoTotalConhecimento > 0){
				$resultado .= "<p>Falta(am) <b>" . $resultadoTotalConhecimento . "</b> conhecimento(s) para completar esse manifesto.</p>";
			}
		break;
		
		case 'peso':
			$resultadoPesoConhecimento = ($manifestoPeso - $totalPeso);
			if($resultadoPesoConhecimento > 0){
				$resultado .= "<p>O peso está <b>" . $resultadoPesoConhecimento . "</b> kg abaixo do correto.</p>";
			}
			if($resultadoPesoConhecimento < 0){
				$resultado .= "<p>O peso está <b>" . $resultadoPesoConhecimento*(-1) . "</b> kg acima do correto.</p>";
			}
		break;
			
		case 'vol':
			$resultadoVolConhecimento = ($manifestoVolumes - $totalVolumes);
			if($resultadoVolConhecimento > 0){
				$resultado .= "<p>A qtde de volumes está <b>" . $resultadoVolConhecimento . "</b> abaixo do correto.</p>";
			}
			if($resultadoVolConhecimento < 0){
				$resultado .= "<p>A qtde de volumes está <b>" . $resultadoVolConhecimento*(-1) . "</b> acima do correto.</p>";
			}
		break;
		
		case 'nf':
			$resultadoNfConhecimento = ($manifestoTotalNF - $totalNotaFiscal);
			if($resultadoNfConhecimento > 0){
				$resultado .= "<p>O valor da nota fiscal está <b>" . $resultadoNfConhecimento . "</b> abaixo do correto.</p>";
			}
			if($resultadoNfConhecimento < 0){
				$resultado .= "<p>O valor da nota fiscal está <b>" . $resultadoNfConhecimento*(-1) . "</b> acima do correto.</p>";
			}
		break;
		
		case 'frete':
			$resultadoFreteConhecimento = ($manifestoTotalFrete - $totalFrete);
			if($resultadoFreteConhecimento > 0){
				$resultado .= "<p>O valor do frete está <b>" . $resultadoFreteConhecimento . "</b> abaixo do correto.</p>";
			}
			if($resultadoFreteConhecimento < 0){
				$resultado .= "<p>O valor do frete  está <b>" . $resultadoFreteConhecimento*(-1) . "</b> acima do correto.</p>";
			}	
		break;
		
	}
	return rawurlencode($resultado);
}

/**
 * Função que controla a sessão para cadastros dos conhecimentos de um manifesto. Utilizado em frmManifesto.php
 */
function sessionManifesto($codigo){
	$_SESSION['sessManifesto'] = '';
	
	if(getStatusManifesto($codigo, 'ctrc') != ""){
		$_SESSION['sessManifesto'] = $codigo;
		return "";
	}
	else{
		return rawurlencode("O manifesto selecionado está completo, não é possível cadastrar outros conhecimentos.");
	}
}

/**
 * Função verifica se há conhecimentos para um manifesto não fechado. Utilizado em frmConhecimento.php
 */
function checkSession($codigo){
	$codSessManifesto = $_SESSION['sessManifesto'];
	if(!empty($codSessManifesto)){
		if(getStatusManifesto($codSessManifesto, 'ctrc') == ""){
			$_SESSION['sessManifesto'] = 'NULL';
		}
		$retorno = $_SESSION['sessManifesto'];
	}
	else{
		$retorno = $codigo;
	}
	return rawurlencode($retorno);
}

/**
 * Função que retorna os dados de um determinado cnpf. Usado em frmConhecimento.php
 */
function returnDataCnpf($cnpf){
	global $controlador;
	$cliente = $controlador['cliente'];
	$resultado = $cliente->returnDataByCnpf($cnpf);
	return $resultado;
}

/**
 * Função que retorna os dados de um cep
 */
function getCep($cep){

	/* Gerando string de conexão */
	$dns = BASE_TYPE.'://'.USER.':'.PASS.'@'.HOST.'/'.CEP_BASE;
		
	/* Estabelecendo a conexão com o banco de dados */
	$db_cep = DB::connect($dns);
	
	/* Tratando caso o objeto retornado seja um objeto que trata erros */
	if(DB::isError($db_cep)){
		die($db_cep->getMessage());
	}
	
	/* Gerando SQL de consulta */
	$cep_consulta = str_replace('.', '', $cep);
	$cep_consulta = str_replace('-', '', $cep_consulta);
	$sql = "SELECT l.nome as nome_tip, l.cep, l.tipo, lo.nome as nome_loc, lo.uf, b.nome as nome_bai
			FROM logradouro l, localidade lo, bairro b  
			WHERE l.cep = '".$cep_consulta."' AND
			l.id_localidade = lo.id AND
			l.id_bairro = b.id
			LIMIT 1";

	/* Retornando a coleção de dados */
	$resultado = $db_cep->query($sql);
	
	if(!DB::isError($resultado)){
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$retorno['cep']        = rawurlencode($cep);
		$retorno['tipo']       = rawurlencode($dados['tipo']);
		$retorno['nome_tipo']  = rawurlencode($dados['nome_tip']);
		$retorno['bairro']     = rawurlencode($dados['nome_bai']);
		$retorno['localidade'] = rawurlencode($dados['nome_loc']);
		$retorno['uf']         = rawurlencode($dados['uf']);
		$resultado->free();
	}
	else{
		die($resultado->getMessage());
	}
	
	return $retorno;
}
?>