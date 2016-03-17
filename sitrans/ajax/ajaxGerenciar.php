<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais", "getFiltredRegistersPessoa", "deleteRegisterPessoa", "registerDetaisPessoa", "getFiltredRegistersColeta", "deleteRegisterColeta", "registerDetaisColeta","getFiltredRegistersColetaCliente", "registerDetaisColetaCliente", "getFiltredRegistersContato", "getFiltredRegistersConhecimento", "deleteRegisterConhecimento", "registerDetaisConhecimento", "changeStatusConhecimento", "getFiltredRegistersManifesto", "deleteRegisterManifesto", "registerDetaisManifesto");
sajax_handle_client_request();

/**
* G E R A L
*/

/* @@ DEBUG SERVER ONLINE @@ */
function uc_latin1_ajax($str){
	$str = rawurldecode($str);
	$str = str_replace('à', 'À', $str);
	$str = str_replace('á', 'Á', $str);
	$str = str_replace('â', 'Â', $str);
	$str = str_replace('ã', 'Ã', $str);
	$str = str_replace('ç', 'Ç', $str);
	$str = str_replace('è', 'È', $str);
	$str = str_replace('é', 'É', $str);
	$str = str_replace('ê', 'Ê', $str);
	$str = str_replace('ì', 'Ì', $str);
	$str = str_replace('í', 'Í', $str);
	$str = str_replace('ò', 'Ò', $str);
	$str = str_replace('ó', 'Ó', $str);
	$str = str_replace('ô', 'Ô', $str);
	$str = str_replace('ú', 'Ú', $str);
    return strtoupper($str);
}
/* FIM */

/* @@ FUNÇÕES AUXILIARES PARA O AJAX @@ */
/*
* Função para converter data do formato do banco para o formato utilizado
* Converte de YYYY-MM-DD para DD/MM/YYYY
*/
function desconverteDataAjax($data){
	$exp = explode("-", $data);
	$ano = $exp[0];
	$mes = $exp[1];
	$dia = $exp[2];
	return $dia.'/'.$mes.'/'.$ano;	
}
/*
* Função para converter data do utilizado para o formato do banco
* Converte de DD/MM/YYYY para YYYY-MM-DD
*/
function converteDataAjax($data){
	if(eregi('/',$data)){
		$exp = explode("/", $data);
		$ano = $exp[2];
		$mes = $exp[1];
		$dia = $exp[0];
		return $ano.'-'.$mes.'-'.$dia;
	}
	else{
		return $data;
	}
}
/* FIM */


/*
 * A J A X
 */
 
function registerDetais($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){			
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1_ajax($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegister($tabela, $key){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now() WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);	
	
	return rawurlencode($key);
}

function getFiltredRegisters($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;	
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 12;
	
	$sql  = "";
	$sql .= "SELECT $campoPK, $campo";
	$sql .= " FROM $tabela";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= ") AND situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
		
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk   = $dados[$campoPK];
				
				$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])."</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				if($tabela == "saidamanifesto"){
					$template->setVariable("cmp_imprimir", "<a href=\"report.php?id=$pk\" class=\"link_gen\">Imprimir</a>");
				}
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
 * P E S S O A
 */

function registerDetaisPessoa($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela       = $tabelaMap[$tabela];
	$tabelaPessoa = $tabelaMap['pessoa'];
	$campoPK      = $camposMap['pessoa'][0];
	$campoPKF     = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabelaPessoa p, $tabela po";
	$sql .= " WHERE p.$campoPK = po.$campoPK AND po.$campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}

	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){
				if(!in_array($i, $hideMap[$tabela], true)){			
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1_ajax($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}			
			}
			
			$qtdCampos = count($camposMap['pessoa']);
			
			for($i=0; $i<$qtdCampos; $i++){
				if(!in_array($i, $hideMap['pessoa'], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap['pessoa'][$i]).':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1_ajax($dados[$camposMap['pessoa'][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegisterPessoa($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela         = $tabelaMap[$tabela];
	$campo          = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	$tabelaContatos = $tabelaMap['contato'];
	$campoContato   = $camposMap['contato'][1];
	
	$objRec = $controlador[$tabela];
	$objRec->__toFillGeneric();
	$objRec->__get_db($key);
	
	$idPessoa = $objRec->getIdpessoa();
	
	$db = $controlador['database'];
	
	/* Desativando Contatos */
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabelaContatos ;
	$sql .= " SET situacao = 'FALSE', databaixa = now() WHERE ";
	$sql .= $campoContato;
	$sql .= " = ";
	$sql .= $idPessoa;
	
	$db->query($sql);
	
	/* Desativando Pessoa */
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now() WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db->query($sql);
	
	return rawurlencode($key);
}

function getFiltredRegistersPessoa($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = substr($campos[0],1,2);
	}
	else{
		$campoIndex  = substr($campos, 1,2);
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela       = $tabelaMap[$tabela];
	$tabelaPessoa = $tabelaMap['pessoa'];
	$campo        = $camposMap[$tabela][$campoIndex];
	$campoPK      = $camposMap['pessoa'][0];
	$campoPKT     = $camposMap[$tabela][0];
	$limite       = 12;
	
	$sql  = "";
	$sql .= "SELECT po.$campoPKT, p.$campoPK, $campo";
	$sql .= " FROM $tabelaPessoa p, $tabela po";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$prefixoTabela = substr($campoAtual,0,1);
				$campoAtual    = substr($campoAtual,1,2);
				if($prefixoTabela == "g"){
					$tabelaCampo = $tabela;
				}
				else{
					$tabelaCampo = $tabelaPessoa;
				}
				$nomeCampo = $camposMap[$tabelaCampo][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= ") AND p.$campoPK = po.$campoPK AND situacao = 'TRUE'"; 
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE p.$campoPK = po.$campoPK AND situacao = 'TRUE'"; 
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	
	//return rawurlencode($sql);
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pkt   = $dados[$campoPKT];
				
				$pk    = $dados[$campoPK];
				
				$item = "<span onclick=\"call_registerDetaisPessoa('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])."</span>";
				
				$template->setVariable("cmp_id", $pkt);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegisterPessoa('$pkt', '$tabela');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pkt\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
 * C O L E T A
 */
function registerDetaisColeta($key, $versao, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$sql .= " AND versao = ";
	
	if(is_numeric($versao)){
		$sql .= $versao;
	}
	else{
		$sql .= "'".$versao."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){			
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$campoAtual = $camposMap[$tabela][$i];
						switch($campoAtual){
							case 'data':
								$valor = uc_latin1_ajax(desconverteDataAjax($dados[$campoAtual]));
							break;							
							default:
								$valor = uc_latin1_ajax($dados[$campoAtual]);
							break;
						}
						$template->setVariable("cmp_detalhe_valor",$valor);
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegisterColeta($tabela, $key){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET idstatus = 3, databaixa = now() WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);	
	
	return rawurlencode($key);
}

function getFiltredRegistersColeta($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$nivel = $_SESSION['sessNivel'];
	$opcao = $_GET['opcao'];
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 30;
	
	$sql  = "";
	$sql .= "SELECT c.$campoPK, c.$campo, c.versao, c.hora, c.data, c.idstatus, c.idveiculo, k.nome, p.cidade";
	$sql .= " FROM $tabela c, cliente k, pessoa p";
	if(!empty($digitado)){
		if($opcao == 'roteirizar'){
			$sql .= ", veiculo v";
		}
		$digitado = converteDataAjax($digitado);
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($nomeCampo == 'data' && !eregi('-', $digitado)){
					continue;
				}
				if($nomeCampo == 'hora' && !eregi(':', $digitado)){
					continue;
				}
				if($i==0){
					if($nomeCampo == 'data' || $nomeCampo == 'hora'){
						$sql .= " WHERE ($nomeCampo = '$digitado'";
					}
					else{
						$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					}
					$i++;
				}
				else{
					if($nomeCampo == 'data' || $nomeCampo == 'hora'){
						$sql .= " OR $nomeCampo = '$digitado'";
					}
					else{
						$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
					}					
				}
			}
		}
		$sql .= " OR k.nome iLIKE  '%$digitado%'";
		if($opcao == 'roteirizar'){
			$sql .= " OR v.placa iLIKE  '%$digitado%'";
		}
		$sql .= " OR p.cidade iLIKE  '%".strtoupper($digitado)."%'";
		$sql .= ") AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
		/* se for atendente só mostra os cadastrados */
		if($nivel == 4){
			$sql .= " AND c.idstatus = 1";
		}
		/* para gateway poder roteirizar */
		if($opcao == 'roteirizar'){
			$sql .= " AND c.idstatus NOT IN (2,3)";
			$sql .= " AND c.data <= NOW()";
			$sql .= " AND c.idveiculo = v.idveiculo";
		}
		$sql .= " AND k.idcliente = c.idcliente";
		$sql .= " AND k.idpessoa = p.idpessoa";
		$sql .= " ORDER BY c.idstatus ASC, c.hora, c.data DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
		/* se for atendente só mostra os cadastrados */
		if($nivel == 4){
			$sql .= " AND c.idstatus = 1";
		}
		/* para gateway poder roteirizar */
		if($opcao == 'roteirizar'){
			$sql .= " AND c.idstatus NOT IN (2,3)";
			$sql .= " AND c.data <= NOW()";
		}
		$sql .= " AND k.idcliente = c.idcliente";
		$sql .= " AND k.idpessoa = p.idpessoa";
		$sql .= " ORDER BY c.idstatus ASC, c.hora, c.data DESC";
		if($opcao != 'roteirizar'){
			$sql .= " LIMIT 0";
		}
	}
	
	//return rawurlencode($sql);
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk     = $dados[$campoPK];
				
				$versao = $dados['versao'];
				
				$status = $controlador['status'];
				$status->__toFillGeneric();
				$status->__get_db($dados['idstatus']);
				$nomeStatus = $status->getDescricao();
				
				$classeCss = 'coleta_'.strtolower(str_replace(' ', '_',$nomeStatus));
				
				//return $classeCss;
				
				$item = "<span onclick=\"call_registerDetaisColeta('$pk', '$versao')\" class=\"$classeCss\">".uc_latin1_ajax(desconverteDataAjax($dados['data']).' - '.$dados['hora']).' - Situação: '.$nomeStatus." - Cliente: ".$dados['nome']."</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				//if($nivel != 4){
					$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"tb_show('Detalhe o motivo do cancelamento da coleta:', 'frmMotivo.php?idcoleta=$pk&versao=$versao&idstatus=3&acao=adicionar&height=170&width=695;form_motivo.descricao.focus();', '');\" class=\"link_gen\">Cancelar</a>");
				//}
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk&versao=$versao\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
* C L I E N T E
*/

function registerDetaisColetaCliente($key, $versao, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$sql .= " AND versao = ";
	
	if(is_numeric($versao)){
		$sql .= $versao;
	}
	else{
		$sql .= "'".$versao."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html/cliente';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){			
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$campoAtual = $camposMap[$tabela][$i];
						switch($campoAtual){
							case 'data':
								$valor = uc_latin1_ajax(desconverteDataAjax($dados[$campoAtual]));
							break;							
							default:
								$valor = uc_latin1_ajax($dados[$campoAtual]);
							break;
						}
						$template->setVariable("cmp_detalhe_valor",$valor);
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function getFiltredRegistersColetaCliente($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$idCliente = $_SESSION['sessIdCliente'];
	$idContato = $_SESSION['sessIdContato'];
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 30;
	
	$sql  = "";
	$sql .= "SELECT c.$campoPK, c.$campo, c.versao, c.hora, c.data, c.idstatus";
	$sql .= " FROM $tabela c";
			
	if(!empty($digitado)){
		$digitado = converteDataAjax($digitado);
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($nomeCampo == 'data' && !eregi('-', $digitado)){
					continue;
				}
				if($nomeCampo == 'hora' && !eregi(':', $digitado)){
					continue;
				}
				if($i==0){
					if($nomeCampo == 'data' || $nomeCampo == 'hora'){
						$sql .= " WHERE ($nomeCampo = '$digitado'";
					}
					else{
						$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					}
					$i++;
				}
				else{
					if($nomeCampo == 'data' || $nomeCampo == 'hora'){
						$sql .= " OR $nomeCampo = '$digitado'";
					}
					else{
						$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
					}					
				}
			}
		}
		$sql .= ") AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
		$sql .= " AND idcontato = ".$_SESSION['sessIdContato']." AND idcliente = ".$_SESSION['sessIdEmpresa'];
		/* se for atendente só mostra os cadastrados */
		$sql .= " ORDER BY c.idstatus ASC, c.hora, c.data DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
		$sql .= " AND idcontato = ".$_SESSION['sessIdContato']." AND idcliente = ".$_SESSION['sessIdEmpresa'];
		$sql .= " ORDER BY c.idstatus ASC, c.hora, c.data DESC";
	}
	
	//return rawurlencode($sql);
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html/cliente/';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk     = $dados[$campoPK];
				
				$versao = $dados['versao'];
				
				$status = $controlador['status'];
				$status->__toFillGeneric();
				$status->__get_db($dados['idstatus']);
				$nomeStatus = $status->getDescricao();
				$idStatus   = $status->getId();
				
				$item = "<span onclick=\"call_registerDetaisColetaCliente('$pk', '$versao')\" class=\"cursorLink\">".uc_latin1_ajax(desconverteDataAjax($dados['data']).' - '.$dados['hora']).' - Situação: '.$nomeStatus."</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				if($idStatus == 1){
					$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"tb_show('Detalhe o motivo do cancelamento da coleta:', 'frmMotivo.php?idcoleta=$pk&versao=$versao&idstatus=3&acao=adicionar&height=130&width=544&tcliente=sim', '');\" class=\"link_gen\">Cancelar</a>");
				
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk&versao=$versao&tcliente=sim\" class=\"link_gen\">Atualizar</a>");
				}
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
* C O N T A T O
*/

function getFiltredRegistersContato($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;	
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 12;
	
	$sql  = "";
	$sql .= "SELECT c.$campoPK, c.$campo, k.nome as nomeEmp";
	$sql .= " FROM $tabela c, pessoa p, cliente k";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE (c.$campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE (c.$nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR c.$nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= " OR k.nome iLIKE  '%$digitado%'";
		$sql .= ") AND c.situacao = 'TRUE'";
		$sql .= " AND c.idpessoa = p.idpessoa AND p.idpessoa = k.idpessoa";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE c.situacao = 'TRUE' AND c.idpessoa = p.idpessoa AND p.idpessoa = k.idpessoa";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	
	//return rawurlencode($sql);
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk   = $dados[$campoPK];
				
				$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])."</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/*
* C O N H E C I M E N T O
*/

function registerDetaisConhecimento($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){			
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1_ajax($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegisterConhecimento($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now(), idstatusconhecimento = 3 WHERE "; // seta o status para CANCELADO
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);
	
	return rawurlencode($key);
}

function getFiltredRegistersConhecimento($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;	
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 12;
	
	$sql  = "";
	$sql .= "SELECT $campoPK, $campo, idstatusconhecimento";
	$sql .= " FROM $tabela";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= ") AND situacao = 'TRUE'";
		$sql .= " ORDER BY idstatusconhecimento ASC";
	}
	else{
		$sql .= " WHERE situacao = 'TRUE'";
		$sql .= " ORDER BY idstatusconhecimento ASC";
	}
		
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		$objStatusConhecimento = $controlador['statusconhecimento'];
		$objStatusConhecimento->__toFillGeneric();
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk   = $dados[$campoPK];
				
				/* Resgatando nome do Status */
				$objStatusConhecimento->__get_db($dados['idstatusconhecimento']);
				$nomeConhecimento = $objStatusConhecimento->getDescricao();
				/* FIM */
				
				$item = "<span onclick=\"call_registerDetaisConhecimento('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])." - Status: $nomeConhecimento</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegisterConhecimento('$pk');\" class=\"link_gen\">Cancelar</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				if($dados['idstatusconhecimento'] == 2){
					$template->setVariable("cmp_estornar", "<a href=\"javascript:;\" onclick=\"StatusConhecimento.changeStatusConhecimento($pk, 1);\" class=\"link_gen\">Estornar</a>");
				}
				if($dados['idstatusconhecimento'] != 5){
					$template->setVariable("cmp_devolver", "<a href=\"javascript:;\" onclick=\"StatusConhecimento.changeStatusConhecimento($pk, 5);\" class=\"link_gen\">Devolver</a>");
				}
				if($tabela == "saidamanifesto"){
					$template->setVariable("cmp_imprimir", "<a href=\"report.php?id=$pk\" class=\"link_gen\">Imprimir</a>");
				}
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
 * Função que altera o status de um conhecimento, Utilizado em gerenciarConhecimento.php
 */
function changeStatusConhecimento($id, $status){
	global $controlador;
	$objConhecimento = $controlador['conhecimento'];
	$objConhecimento->__toFillGeneric();
	$objConhecimento->chanceStatusCon($id, $status);
	if($status == 1){
		$objEntregas = $controlador['entregas'];
		$objEntregas->__toFillGeneric();
		$objEntregas->deleteConById($id);
	}
}

/*
* M A N I F E S T O
*/

function registerDetaisManifesto($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){			
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1_ajax($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegisterManifesto($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now(), idstatusconhecimento = 3 WHERE "; // seta o status para CANCELADO
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);
	
	return rawurlencode($key);
}

function getFiltredRegistersManifesto($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;	
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	$digitado = converteDataAjax($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql  = "";
	$sql .= "SELECT k.$campoPK, k.$campo, s.descricao, f.razaosocial, k.datacadastro";
	$sql .= " FROM $tabela k, fornecedor f, statusmanifesto s";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= " OR s.descricao iLIKE  '%$digitado%'";
		$sql .= " OR f.razaosocial iLIKE  '%$digitado%'";
		$sql .= " OR k.datacadastro::date = '$digitado'";
		
		$sql .= ") AND k.situacao = 'TRUE'";
		$sql .= " AND k.idstatusmanifesto = s.idstatusmanifesto";
		$sql .= " AND k.idfornecedor = f.idfornecedor";
		$sql .= " ORDER BY k.idstatusmanifesto ASC";
	}
	else{
		$sql .= " WHERE k.situacao = 'TRUE'";
		$sql .= " AND k.idstatusmanifesto = s.idstatusmanifesto";
		$sql .= " AND k.idfornecedor = f.idfornecedor";
		$sql .= " ORDER BY k.idstatusmanifesto ASC";
	}
	
	//return rawurlencode($sql);
		
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk   = $dados[$campoPK];
				
				/* Resgatando nome do Status */
				/* FIM */
				
				$item = "<span onclick=\"call_registerDetaisConhecimento('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])." - Status: ".$dados['descricao']."</span>";
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegisterManifesto('$pk');\" class=\"link_gen\">Cancelar</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}
?>