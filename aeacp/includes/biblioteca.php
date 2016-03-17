<?php
/*
	# BIBLIOTECA.PHP
	
	[ Arquivo de configuração do site da informática CEFET-PR CP ]
	
	O arquivo biblioteca.php tem como objetivo armazenar as funções comuns
	a mais de uma sessão do site.
*/

/* Função para limpar os códigos BBCODE [B][/B] */

function limpaBbCode($str){

	$str = str_replace("[B]", "",$str);
	$str = str_replace("[/B]", "",$str);
	
	$str = str_replace("[I]", "",$str);
	$str = str_replace("[/I]", "",$str);
	
	$str = str_replace("[U]", "",$str);
	$str = str_replace("[/U]", "",$str);
	
	$exp = explode("[URL=", $str);
	$expFecha = explode(":FECHA]",$exp[1]);
	
	$str = str_replace($expFecha[0], "",$str);
	
	$str = str_replace("[URL=", "",$str);
	
	$str = str_replace(":FECHA]", "",$str);	
			
	$str = str_replace("[/URL]", "", $str);
	
	$exp = explode("[IMG]", $str);
	$expFecha = explode("[/IMG]", $exp[1]);
	
	$str = str_replace($expFecha[0], "",$str); 
	
	$str = str_replace("[IMG]", "",$str);
	
	$str = str_replace("[/IMG]", "",$str);
	
	return $str;
}

/* Função para desconverter os códigos em BBCODE [B][/B] */
function bbCode($str){
	
	$str = str_replace("[B]", "<b>",$str);
	$str = str_replace("[/B]", "</b>",$str);
	
	$str = str_replace("[I]", "<i>",$str);
	$str = str_replace("[/I]", "</i>",$str);
	
	$str = str_replace("[U]", "<u>",$str);
	$str = str_replace("[/U]", "</U>",$str);
	
	
	$str = str_replace("[URL=", "<a href=\"",$str);
	
	$str = str_replace(":FECHA]", "\" target=\"_blank\">",$str);			
	$str = str_replace("[/URL]", "</a>", $str);
	
	$str = str_replace("[IMG]", "<img src=\"",$str);
	$str = str_replace("[/IMG]", "\" border=\"0\">",$str);
	
	return $str;
	
}

/* Função para abreviar os nomes das disciplinas */
function abreviaDisci($nome){
	################
	$qtd = strlen($nome);
	
	if($qtd >= 16 && $qtd <= 24){
		$casas = 4;
	}
		else if($qtd >= 24 && $qtd <= 32){
			$casas = 3;
		}
			else{
				$casas = 2;
			}
				
	$exp = explode(' ',$nome);
	$str = '';
	for($i=0; $i<count($exp); $i++){
		if(strlen($exp[$i]) > $casas){
			$str .= substr($exp[$i], 0, $casas);
			$str .= '. ';
		}
		else{
			$str .= $exp[$i];
			$str .= ' ';
		}
	}
	return $str;
}

/* Função para retornar strings formatadas a partir de um timestamp */
function formataStamp($STR,$DIV,$OP=0){ // 0 - Data / 1 - Hora //
	switch($OP){			
		case 0 : return $STR[6].$STR[7].$DIV.$STR[4].$STR[5].$DIV.$STR[0].$STR[1].$STR[2].$STR[3]; break;
		case 1 : return $STR[8].$STR[9].$DIV.$STR[10].$STR[11].$DIV.$STR[12].$STR[13];             break;
		case 2 : return $STR[6].$STR[7].$DIV.$STR[4].$STR[5];                                      break;
	}
}

/* Função para modificar conteúdo a ser exibido, formatando de acordo com o HTML */
function limpaDescricao($val, $inverte=false){
	if($inverte == false){
	/* Subistituindo \n por <BR> */		
	$val = str_replace("\n","<br>",$val);
	/* Subistituindo tab por esçoes */
	$val = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $val);
	}
	else{	
	/* Subistituindo \n por <BR> */		
	$val = str_replace("<br>","\n",$val);
	/* Subistituindo tab por esçoes */
	$val = str_replace("&nbsp;&nbsp;&nbsp;&nbsp;", "	", $val);
	}
	return $val;
}

/* Função para retornar o ID apartir da Session */
function retornaIdSess($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/* Função para converter as datas no formato do PostGres */
function converteData($data){
	//10/12/2005
	$exp = explode('/', $data);
	$mes = $exp[0];
	$dia = $exp[1];
	$ano = $exp[2];
	
	return $dia.'/'.$mes.'/'.$ano;
}

/* Função para desconverter as datas no formato do PostGres */
function desconverteData($data){
	//2005-02-19
	$exp = explode('-', $data);
	$mes = $exp[1];
	$dia = $exp[2];
	$ano = $exp[0];	
	return $dia.'/'.$mes.'/'.$ano;	
}

/* Função que retorna o nome do administrador */
function retornaAdmin($id){
	global $tabela;
	global $camposTab2;
	$MySQL = new MySQL;
	
	$query = $MySQL->Query("SELECT {$camposTab2[1]} FROM {$tabela['admin']} WHERE {$camposTab2[0]} = $id");
	$data = mysql_fetch_array($query);
	return $data[$camposTab2[1]];	
}

function retornaAdminLogin($id){
	global $tabela;
	global $camposTab2;
	$MySQL = new MySQL;
	
	$query = $MySQL->Query("SELECT {$camposTab2[3]} FROM {$tabela['admin']} WHERE {$camposTab2[0]} = $id");
	$data = mysql_fetch_array($query);
	return $data[$camposTab2[3]];	
}

/* Função para checar se um email é valido */
function checkMail($email){
	if(eregi('@', $email) && eregi('.', $email)){
		return true;
	}
	return false;
}
?>