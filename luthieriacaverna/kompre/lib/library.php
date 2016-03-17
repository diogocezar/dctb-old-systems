<?php
/**
* Conjunto de fun��es espec�ficas para o site :
*/

/**
* I N � C I O  F U  N � � E S 
*/

/*
* Fun��o que converte todas as quebras de linha \n em quebras de linha em html <br>
*/
function converteQuebra($str){
	return str_replace("\n", "<br>", $str);
}

/*
* Fun��o que desconverte todas as quebras de linha \n em quebras de linha em html <br>
*/
function desconverteQuebra($str){
	return str_replace("<br>", "\n", $str);
}

/*
* Fun��o que limita uma string para a quantidade de caracteres passada por par�metro
*/
function limitaStr($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

/**
* Fun��o que registra o login de um determinado administrador.
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
* Fun��o que retorna apenas os dois primeiros nomes do administrador
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
* Fun��o para retornar uma session num�rica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/*
* Fun��o que retorna o c�digo do ultimo produto cadastrado
*/
function retornaCodProduto(){
	global $dataBase;
	global $tabela;
	$sql = "SELECT MAX(pro_cod) FROM {$tabela['produtos']}";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Fun��o que cadastra uma foto no banco de dados e retorna seu c�digo
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
* Fun��o para organizar o array com os arquivos
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
* Fun��o para colocar variavel de get
*/
function toGet($palavra){
	$palavra = str_replace(" ", "_", strtolower($palavra));
	return $palavra;
}

/*
* Fun��o para retornar variavel de get
*/
function noToGet($palavra){
	$palavra = str_replace("_", " ", strtolower($palavra));
	return $palavra;
}

/** 
* M�todo retorna o tamanho de um arquivo passado por par�metro e retorna um array contendo :
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
* Fun��o que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}
/*
* Fun��o que .
*/
function limpaPreco($preco){
	$retorno = str_replace(".", "", $preco);
	return $retorno;
}
?>