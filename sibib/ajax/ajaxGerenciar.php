<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais", "devolverLoc");
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

function limitaStrAjax($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

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
	
	$tabelaP   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabelaP ";
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
			
			if($dados['status'] == "EM ABERTO"){
				
			}
			else{
				
			}
			
			for($i=0; $i<$qtdCampos; $i++){
				$campoAtual = $camposMap[$tabela][$i];
				if(!in_array($i, $hideMap[$tabela], true)){
						if($dados['status'] == "EM ABERTO"){
							if(empty($dados['data_devolvido'])){
								if($campoAtual == 'data_devolvido'){
									continue;	
								}
							}
							
						}
						$template->setCurrentBlock("bloco_detalhe");
							$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
							switch($campoAtual){
								case 'data_locacao':
								case 'data_devolucao':
								case 'data_devolvido':
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
			if($tabela == "acervo"){
				$idAutor = $dados['id_autor'];
				$autor = $controlador['autor'];
				$autor->__toFillGeneric();
				$autor->__get_db($idAutor);
				$nomeAutor = $autor->getNome();
				
				$idEditora = $dados['id_editora'];
				$editora = $controlador['editora'];
				$editora->__toFillGeneric();
				$editora->__get_db($idEditora);
				$nomeEditora = $editora->getNome();
				
				$idTipo = $dados['id_tipo_acervo'];
				$tipo = $controlador['tipoacervo'];
				$tipo->__toFillGeneric();
				$tipo->__get_db($idTipo);
				$nomeTipo = $tipo->getNome();
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "AUTOR:");
					$template->setVariable("cmp_detalhe_valor", $nomeAutor);
				$template->parseCurrentBlock("bloco_detalhe");
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "EDITORA:");
					$template->setVariable("cmp_detalhe_valor", $nomeEditora);
				$template->parseCurrentBlock("bloco_detalhe");
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "TIPO ACERVO:");
					$template->setVariable("cmp_detalhe_valor", $nomeTipo);
				$template->parseCurrentBlock("bloco_detalhe");
			}
			
			if($tabela == "acervo" && $dados['status'] == "LOCADO"){
				$objAcervoLocacao = $controlador['acervolocacao'];
				$objAcervoLocacao->__toFillGeneric();
				
				$idLocacao = $objAcervoLocacao->getLocByAcer($key);
				
				$objLocacao = $controlador['locacao'];
				$objLocacao->__toFillGeneric();
				$objLocacao->__get_db($idLocacao);
				$nome = strtoupper($objLocacao->getNomeUsuario());
				$dataLocacao = desconverteDataAjax($objLocacao->getDataLocacao());
				$dataDevolucao = desconverteDataAjax($objLocacao->getDataDevolucao());
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "NOME LOCADOR:");
					$template->setVariable("cmp_detalhe_valor", $nome);
				$template->parseCurrentBlock("bloco_detalhe");
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "DATA LOCAÇÃO:");
					$template->setVariable("cmp_detalhe_valor", $dataLocacao);
				$template->parseCurrentBlock("bloco_detalhe");
				
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", "DATA DEVOLUÇÃO:");
					$template->setVariable("cmp_detalhe_valor", $dataDevolucao);
				$template->parseCurrentBlock("bloco_detalhe");
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
		
	$tabelaP = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabelaP;
	$sql .= " SET situacao = '0', data_baixa = now() WHERE ";
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
	
	$digitado = converteDataAjax(rawurldecode($digitado));
	$tabelaP   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 20;
	$todas    = $_GET['todas'];	
	
	$sql  = "";
	$sql .= "SELECT k.$campoPK, k.$campo";
	if($tabela == 'acervo'){
		$sql .= ", k.status, a.nome, e.nome, t.nome";
	}
	if($tabela == 'locacao'){
		$sql .= ", u.nome, k.status, k.data_devolucao";
	}
	$sql .= " FROM $tabelaP k";
	if($tabela == 'acervo'){
		$sql .= ", autor a, editora e, tipo_acervo t";
	}
	if($tabela == 'locacao'){
		$sql .= ", usuario u";
	}
			  
	$qtdDigitado = strlen($digitado);
	
	if(!empty($digitado) && $qtdDigitado > 1){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo LIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo LIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo LIKE '%$digitado%'";
					if($tabela == 'locacao'){
						$sql .= " OR u.nome LIKE '%$digitado%'";
					}
					if($tabela == 'acervo'){
						$sql .= " OR a.nome LIKE '%$digitado%'";
						$sql .= " OR e.nome LIKE '%$digitado%'";
						$sql .= " OR t.nome LIKE '%$digitado%'";
					}
				}
			}
		}
		$sql .= ") AND k.situacao = '1'";
		if($tabela == 'locacao'){
			$sql .= " AND u.id_usuario = k.id_usuario";
			if(empty($todas)){
				$sql .= " AND k.status = 'EM ABERTO'";
			}
		}
		if($tabela == 'acervo'){
			$sql .= " AND k.id_autor = a.id_autor";
			$sql .= " AND k.id_editora = e.id_editora";
			$sql .= " AND k.id_tipo_acervo = t.id_tipo_acervo";
		}
		$sql .= " ORDER BY $campoPK DESC";
	}
	else{
		$sql .= " WHERE k.situacao = '1'";
		if($tabela == 'locacao'){
			$sql .= " AND u.id_usuario = k.id_usuario";
			if(empty($todas)){
				$sql .= " AND k.status = 'EM ABERTO'";
			}
		}
		if($tabela == 'acervo'){
			$sql .= " AND k.id_autor = a.id_autor";
			$sql .= " AND k.id_editora = e.id_editora";
			$sql .= " AND k.id_tipo_acervo = t.id_tipo_acervo";
		}
		if($tabela == "tipoacervo"){
			$sql .= " ORDER BY $campoPK DESC";
		}
		else{
			$sql .= " ORDER BY $campoPK DESC LIMIT 0,$limite";
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
				
				$pk   = $dados[$campoPK];
				
				$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])."</span>";
				
				if($dados['status'] == "LOCADO" || $dados['status'] == "FECHADO" ){
					$span = "red";	
				}
				else{
					$span = "blue";
				}
				
				if($tabela == 'acervo'){
					$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])." (<span class=\"$span\">".$dados['status']."</span>)</span>";
					if($dados['status'] == "LOCADO"){
						$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])." (<span class=\"$span\">".$dados['status']."</span>)</span>";
					}
				}
				
				if($tabela == 'locacao'){
					$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\"><span class=\"red\">".uc_latin1_ajax($dados['nome'])."</span><span class=\"small\"> (de ".desconverteDataAjax($dados['data_locacao'])." até ".desconverteDataAjax($dados['data_devolucao']).")</span>";
					if(!empty($todas)){
						$item = "<span onclick=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados['nome'])." <span class=\"small\"> (de ".desconverteDataAjax($dados['data_locacao'])." até ".desconverteDataAjax($dados['data_devolucao']).") <span class=\"$span\">".$dados['status']."</span></span></span>";
					}
				}
				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				if($tabela == 'locacao' && empty($todas)){
					$template->setVariable("cmp_devolver", "<a href=\"javascript:;\" onclick=\"call_devolverLoc('$pk');\" class=\"link_gen\">Devolver</a>");
				}
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

function devolverLoc($key){
	global $controlador;

	$objAcervoLocacao = $controlador['acervolocacao'];
	$objAcervoLocacao->__toFillGeneric();
	
	$objAcervo = $controlador['acervo'];
	$objAcervo->__toFillGeneric();
	
	$objLocacao = $controlador['locacao'];
	$objLocacao->__toFillGeneric();
	
	$arrayAcervos = $objAcervoLocacao->getAcer($key);
	
	foreach($arrayAcervos as $acervo){
		$objAcervo->chanceStatusAcer($acervo, 'DISPONÍVEL');		
	}
	
	$objLocacao->__get_db($key);
	$objLocacao->setStatus('FECHADO');
	$objLocacao->setDataBaixa('NULL');
	$objLocacao->setDataDevolvido(date("Y-m-d"));
	$objLocacao->update();
}