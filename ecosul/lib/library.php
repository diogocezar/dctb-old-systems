<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
* Função para converter as datas
*/
function converteData($data){
	//01/01/2005 -> 2005-01-01
	$exp = explode('/', $data);
	$mes = $exp[1];
	$dia = $exp[0];
	$ano = $exp[2];
	
	return $ano.'-'.$mes.'-'.$dia;
}

/* 
* Função para desconverter as datas
*/
function desconverteData($data){
	//2005-02-19
	$exp = explode('-', $data);
	$mes = $exp[1];
	$dia = $exp[2];
	$ano = $exp[0];	
	return $dia.'/'.$mes.'/'.$ano;	
}

/* 
* Função para desconverter as datas
*/
function desconverteDataTiny($data){
	//2005-02-19
	$exp = explode('-', $data);
	$mes = $exp[1];
	$dia = $exp[2];
	$ano = $exp[0];	
	return $dia.'/'.$mes.'/'.$ano;	
}

/* 
* Função para desconverter as horas
*/
function desconverteHora($hora){
	//00:00:00
	$exp = explode(':', $hora);
	return $exp[0].':'.$exp[1];
}


/*
* Função que converte todas as quebras de linha \n em quebras de linha em html <br>
*/
function converteQuebra($str){
	return str_replace("\n", "<br>", $str);
}

/*
* Função que desconverte todas as quebras de linha \n em quebras de linha em html <br>
*/
function desconverteQuebra($str){
	return str_replace("<br>", "\n", $str);
}

/*
* Função que limita uma string para a quantidade de caracteres passada por parâmetro
*/
function limitaStr($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

/**
* Função que registra o login de um determinado administrador.
*/
function registraLogAdmin($file, $administrador, $login){
	if($login){
		$strPut = "[LOGIN]";
	}
	else{
		$strPut = "[LOGOUT]";
	}
	foreach($administrador as $indice => $valor){
		$strPut .= $indice.$valor.";";
	}
	$strPut .= "\n";
	$fp = fopen($file, "a+");
	fputs($fp, $strPut, 1024);	
}

/*
* Função que retorna apenas os dois primeiros nomes do administrador
*/
function retorna2Nomes($nome){
	$exp = explode(" ", $nome);
	if(!empty($exp)){
		return $exp[0]." ".$exp[1];
	}
	else{
		return limitaStr($nome, 25);
	}
}

/*
* Função para retornar uma session numérica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/*
* Função que retorna o código do ultimo produto cadastrado
*/
function retornaCodProduto(){
	global $dataBase;
	global $tabela;
	$sql = "SELECT MAX(pro_cod) FROM {$tabela['produtos']}";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Função que cadastra uma foto no banco de dados e retorna seu código
*/
function cadastraFoto($urlFoto){
	global $dataBase;
	global $tabela;
	$sql = "INSERT INTO {$tabela['fotos']} (fot_url) VALUES ('$urlFoto')";
	$dataBase->Query($sql);
	$sql = "SELECT MAX(fot_cod) FROM {$tabela['fotos']}";
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Função para organizar o array com os arquivos
*/
function sortArquivos($arrayArquivos){
	$qtd = count($arrayArquivos['name']);
	for($i=0; $i<=$qtd; $i++){
		if(!empty($arrayArquivos)){
			foreach($arrayArquivos as $indice => $valor){
				if(empty($arrayArquivos[$indice][$i])){
					unset($arrayArquivos[$indice][$i]);
				}
				else{
					if($indice != 'error'){
						$novoArray[$i][$indice] = $arrayArquivos[$indice][$i];
					}
				}
			}
		}
	}
	return $novoArray;
}

/*
* Função para colocar variavel de get
*/
function toGet($palavra){
	$palavra = str_replace(" ", "_", strtolower($palavra));
	return $palavra;
}

/*
* Função para retornar variavel de get
*/
function noToGet($palavra){
	$palavra = str_replace("_", " ", strtolower($palavra));
	return $palavra;
}

/** 
* Método retorna o tamanho de um arquivo passado por parâmetro e retorna um array contendo :
* 0 -> Largura
* 1 -> Altura
* @access public 
* @param String $url Arquivo a ser examinado.
* @return Array
*/  
function getSize($url){
	$quantos = strlen($url);
	$ext     = strtoupper(substr($url, ($quantos-3), $quantos));

	if($ext == 'GIF'){
		@$img = imagecreatefromgif($url);
		$cria = 'gif';
	}
	if($ext == 'JPG' || $ext == 'JPEG'){
		@$img = imagecreatefromjpeg($url); 
		$cria = 'jpg';
	}
	if($ext == 'PNG'){
		@$img = imagecreatefrompng($url); 
		$cria = 'png';
	}

	if($img){		
		define(MAX_WIDTH, 1000); 
		define(MAX_HEIGHT, 800); 
		
		$width = imagesx($img); 
		$height = imagesy($img);
					
		$array = array($width, $height);
		return $array;
	}
}

/*
* Função que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}

/*
* Função que adiciona http:// num link caso ele não tenha
*/
function replaceLink($str){
	if(!eregi('http://', $str)){
		return "http://".$str;
	}
	else{
		return $str;
	}
}
?>