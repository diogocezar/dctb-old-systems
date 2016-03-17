<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getParcelas", "getParcelasFromDB", "getParcelasFromDBByDate", "pagarParcela");
sajax_handle_client_request();

/*
* Função que troca a , por . de um valor
*/
function trocaVirgulaAjax($valor){
	$valor = rawurldecode($valor);
	if(eregi(',', $valor)){
		$qtd     = strlen($valor);
		$inteiro = substr($valor, 0,      $qtd-3);
		$decimal = substr($valor, $qtd-2, $qtd);
		$inteiro = str_replace(".", "", $inteiro);
		return (float)$inteiro.'.'.$decimal;
	}
	else{
		return $valor;
	}
}

/*
* Função que formata dinheiro
*/
function formataDinheiroAjax($valor){
	$valor = rawurldecode($valor);
	return number_format($valor, 2, ',','.');
}

/**
* Função que retorna dia, mes e ano
*/
function retornaDateAjax($data){
	$retorno = array();
	$data = rawurldecode($data);
	$exp = explode('/', $data);
	$retorno['dia'] = $exp[0];
	$retorno['mes'] = $exp[1];
	$retorno['ano'] = $exp[2];
	return $retorno;
}

function getParcelas($numeroparcelas, $valortotal, $periodicidade, $primeirovencimento){

	global $controlador;

	/* Quantidade de dias */
	$objPeriodicidade = $controlador['periodicidade'];
	$objPeriodicidade->__toFillGeneric();
	
	$periodo = $objPeriodicidade->getQtdNumericoAndTipoPeriodo($periodicidade);
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Nome da Página */
	$templateHtmlName = 'parcelas.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	$valortotal = trocaVirgulaAjax($valortotal);
	$valor      = formataDinheiroAjax($valortotal/$numeroparcelas);
	
	for($i=0; $i<$numeroparcelas; $i++){
	
		$dataPrimeiro = retornaDateAjax($primeirovencimento);
		
		$hoje = mktime(0, 0, 0, $dataPrimeiro['mes'], $dataPrimeiro['dia'], $dataPrimeiro['ano']);
		
		$strtime = ($i*$periodo['qtdnumerico'])." ".$periodo['tipoperiodo'];
		
		$parcela = strtotime($strtime, $hoje);
	
		$template->setCurrentBlock("bloco_parcela");
		
			$template->setVariable("campoData", "data_parcela_$i");
			$template->setVariable("valorData", date("d/m/Y", $parcela));
			
			$template->setVariable("campoValor", "valor_parcela_$i");
			$template->setVariable("valorValor", $valor);
			
			$template->setVariable("disabled", "disabled");
			$template->setVariable("labelPagar", "Pagar");
			
		$template->parseCurrentBlock("bloco_parcela");
	
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function getParcelasFromDB($conta){

	global $controlador;
	global $camposMap;

	$objConta = $controlador['conta'];
	$objConta->__toFillGeneric();
	$resultado = $objConta->getAllParcelas($conta);
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Nome da Página */
	$templateHtmlName = 'parcelas.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setCurrentBlock("bloco_parcela");
			
				$template->setVariable("campoData", "data_parcela_$i");
				$template->setVariable("valorData", $dados[$camposMap['parcela'][3]]);
				
				$template->setVariable("campoValor", "valor_parcela_$i");
				//$template->setVariable("valorValor", number_format($dados[$camposMap['parcela'][2]], 2, ',','.'));
				$template->setVariable("valorValor", formataDinheiroAjax($dados[$camposMap['parcela'][2]]));
				
				if($dados[$camposMap['parcela'][5]] == 'f'){
					$template->setVariable("disabled",        "disabled");
					$template->setVariable("disabled_campos", "disabled");
					$template->setVariable("labelPagar",      "Pago");
				}
				else{
					$template->setVariable("labelPagar", "Pagar");
				}
				
				$template->setVariable("onClickPagar", "call_pagarParcela('".$dados[$camposMap['parcela'][0]]."', '$conta')");
				
			$template->parseCurrentBlock("bloco_parcela");
		}
	}	
	
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function getParcelasFromDBByDate($data){

	global $controlador;
	global $camposMap;

	$objConta = $controlador['conta'];
	$objConta->__toFillGeneric();
	$resultado = $objConta->getAllParcelasByDate($data);
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Nome da Página */
	$templateHtmlName = 'parcelasVencimento.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	$passouResultado = false;
	
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		
			$passouResultado = true;
			
			$template->setCurrentBlock("bloco_parcela");
			
				$template->setVariable("campoConta", "conta_$i");
				$template->setVariable("valorConta", $dados[$camposMap['conta'][7]]);
			
				$template->setVariable("campoData", "data_parcela_$i");
				$template->setVariable("valorData", $dados[$camposMap['parcela'][3]]);
				
				$template->setVariable("campoValor", "valor_parcela_$i");
				$template->setVariable("valorValor", number_format($dados[$camposMap['parcela'][2]], 2, ',','.'));
				
				$template->setVariable("disabled_campos", "disabled");
				$template->setVariable("labelPagar",      "Pagar");
				
				$template->setVariable("onClickPagar", "call_pagarParcelaByDate('".$dados[$camposMap['parcela'][0]]."', '$data')");
				
			$template->parseCurrentBlock("bloco_parcela");
		}
	}	
	
	$retorno = $template->get();
	
	if($passouResultado){
		return rawurlencode($retorno);
	}
	else{
		return rawurlencode('Não exite nenhum vencimento diário.');
	}
}


function pagarParcela($parcela, $complemento){
	global $controlador;
	global $camposMap;

	$objParcela = $controlador['parcela'];
	$objParcela->__toFillGeneric();
	$objParcela->__get_db($parcela);
	
	$objParcela->setDatapagamento('NOW()');
	$objParcela->setDatabaixa    ('NULL');
	$objParcela->setSituacao     ('FALSE');
	
	$objParcela->update();
	
	return $complemento;
}
?>