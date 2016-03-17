<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("agendaByDateHour");
sajax_handle_client_request();

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

/**
* Função que retorna dia, mes e ano
*/
function retornaDateAjax($data){
	$retorno = array();
	$exp = explode('-', $data);
	$retorno['dia'] = $exp[2];
	$retorno['mes'] = $exp[1];
	$retorno['ano'] = $exp[0];
	return $retorno;
}

function retornaDateTracoAjax($data){
	$retorno = array();
	$exp = explode('/', $data);
	$retorno['dia'] = $exp[0];
	$retorno['mes'] = $exp[1];
	$retorno['ano'] = $exp[2];
	return $retorno['ano'].'-'.$retorno['mes'].'-'.$retorno['dia'];
}

function limitaStrAjax($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

function agendaByDateHour($date){
	global $controlador;
	global $camposMap;
	
	$date = rawurldecode($date);
	
	if(eregi('/', $date)){
		$date = retornaDateTracoAjax($date);
	}
	
	if($date == date('Y-m-d')){
		$hour = date('G:i');
	}
	else{
		$hour = '00:00';
	}
	
	$agenda = $controlador['agenda'];
	$agenda->__toFillGeneric();
	
	$dataPrimeiro = retornaDateAjax($date);
	$hoje = mktime(0, 0, 0, $dataPrimeiro['mes'], $dataPrimeiro['dia'], $dataPrimeiro['ano']);
	$strtime = '+1 day';
	$dateTomorrow = date("Y-m-d", strtotime($strtime, $hoje));
	
	$resultado = $agenda->queryDateHour($date, $dateTomorrow, $hour);
		
	if(!DB::isError($resultado)){
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'listaAgenda.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	$passou = false;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$passou = true;
		$template->setVariable("valorDia", desconverteDataAjax($date));
		$template->setVariable("onChange", "Agenda.getAgendaByDateHour(false)");
		$template->setCurrentBlock("bloco_agenda");
			$template->setVariable("data", desconverteDataAjax($dados['dataagenda']));
			$template->setVariable("hora", $dados['horaagenda']);
			$template->setVariable("descricao", limitaStrAjax($dados['descricao'],90));
			$template->setVariable("link", '<a href="frmAgenda.php?acao=atualizar&id='.$dados['idagenda'].'"><img src="../images/month.png" border="0" /></a>');
		$template->parseCurrentBlock("bloco_agenda");
	}
	if(!$passou){
		$template->setVariable("valorDia", desconverteDataAjax($date));
		$template->setVariable("onChange", "Agenda.getAgendaByDateHour(false)");
		$template->setCurrentBlock("bloco_agenda");
			$template->setVariable("descricao", 'Não foram encontradoa agendamentos para esse dia.');
		$template->parseCurrentBlock("bloco_agenda");
	}
}

$retorno = $template->get();
return rawurlencode($retorno);
}

?>
