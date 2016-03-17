<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
    extenso.php
    Copyright (C) 2002 Lyma

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

    Lyma (lyma@lymas.com)
    http://lymas.com

    Esta função recebe um valor numérico e retorna uma string contendo o
    valor de entrada por extenso.
    entrada: $valor (use ponto para centavos.)
    Ex.:

    echo extenso("12428.12"); //retorna: doze mil, quatrocentos e vinte e oito reais e doze centavos

    ou use:
    echo extenso("12428.12", true); //esta linha retorna: Doze Mil, Quatrocentos E Vinte E Oito Reais E Doze Centavos

    saída..: string com $valor por extenso em reais e pode ser com iniciais em maiúsculas (true) ou não.


Changelog: Author: Rodrigo (rodrigo.bc@uol.com.br) Um pequeno detalhe nessa excelente função...
Em vez de imprimir no caso: Doze Mil, Quatrocentos E Vinte E Oito Reais E Doze Centavos.
              esta imprimi: Doze Mil, Quatrocentos e Vinte e Oito Reais e Doze Centavos.

          É Muito Mais Bonito, Não?

Rodrigo (rodrigo.bc@uol.com.br)


Changelog: Author: Alessandro Lima (mutana3@yahoo.com.br)

Acrecentei e modifiquei a função para que a mesma imprima em caixa alta e baixa eliminando o problema do strtolower e strtoupper que não funcionam em caracteres com acento .

O código original (1.0) já era muito bom .

Alessandro
*/

function extenso($valor=0, $tipo=0, $caixa="alta") {
    
    $valor = strval($valor);
    $valor = str_replace(",",".",$valor);

    
	switch($tipo){
		case 0:
			$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
			$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
			$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
			break;
		case 1:
			$pos   = strpos($valor,".");
			$valor = substr($valor,0,$pos);			
			$singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
			$plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
			$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
			break;
		case 2:
			$singular = array("", "", "", "", "", "", "");
			$plural = array("", "", "", "", "", "", "");
			$u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
			break;
	}

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");

    $z=0;

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for($i=0;$i<count($inteiro);$i++)
        for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
            $inteiro[$i] = "0".$inteiro[$i];

    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
    for ($i=0;$i<count($inteiro);$i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
        $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
        $t = count($inteiro)-1-$i;
        $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")$z++; elseif ($z > 0) $z--;
        if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? " e " : " e ") : " ") . $r;
    }
    
    if($caixa=="alta"){
    $rt = strtoupper($rt);
    }
    $maiusculas = array("Á","À","Â","Ã","É","Ê","Í","Ó","Ô","Õ","Ú","Û");
    $minusculas = array("á","à","â","ã","é","ê","í","ó","ô","õ","ú","û");
    
    
    for($i=0;$i<count($maiusculas);$i++){
    
        $rt = ereg_replace($minusculas[$i],$maiusculas[$i],$rt);	
    }     
    $rt[0] = "";

	if($tipo == 2){
		$rt[strlen($rt)-1] = "";
	}
	return $rt;                      
        
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
* Função que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}

/*
* Função para uma session numérica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/*
* Função para converter data do formato do banco para o formato utilizado
* Converte de YYYY-MM-DD para DD/MM/YYYY
*/
function converteData($data){
	$exp = explode("-", $data);
	$ano = $exp[0];
	$mes = $exp[1];
	$dia = $exp[2];
	return $dia.'/'.$mes.'/'.$ano;	
}

/*
* Função que extrai a data de um time stamp 
*/
function extraiData($stamp){
	$stamp = str_replace(" ", "", $stamp);
	$stamp = str_replace("-", "", $stamp);
	$stamp = str_replace(":", "", $stamp);
	return $stamp[6].$stamp[7].'/'.$stamp[4].$stamp[5].'/'.$stamp[0].$stamp[1].$stamp[2].$stamp[3];
}

/*
* Função que extrai a hora de um time stamp
* MySQL 5.0 : "2005-12-03 08:49:37"
*/
function extraiHora($stamp){
	$stamp = str_replace(" ", "", $stamp);
	$stamp = str_replace("-", "", $stamp);
	$stamp = str_replace(":", "", $stamp);
	return $stamp[8].$stamp[9].':'.$stamp[10].$stamp[11];
}
/*
* Função para desconverter data do formato do banco para o formato utilizado
* Converte de DD/MM/YYYY para YYYY-MM-DD
*/
function desconverteData($data){
	$exp = explode("/", $data);
	$dia = $exp[0];
	$mes = $exp[1];
	$ano = $exp[2];
	return $ano.'-'.$mes.'-'.$dia;	
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

/*
* Função que retorna o nome do curso a partir de seu id
*/
function retornaNomaCurso($idCurso){
	global $dataBase;
	global $tabela;
	$sql = "SELECT cur_nome FROM {$tabela['cursos']} WHERE cur_cod = $idCurso";	
	return $dataBase->getOne($sql);
}
/*
* Função para retornar o id de uma administrador de curso a partir do id de seu curso
*/
function retornaIdAdm($idCurso){
	global $dataBase;
	global $tabela;
	$sql = "SELECT adm_cod FROM {$tabela['administradores']} WHERE cur_cod = $idCurso LIMIT 1";	
	return $dataBase->getOne($sql);
}
/*
* Função para retornar o email de um administrador de curso a partir de seu id
*/
function retornaEmailAdmin($idCurso){
	global $dataBase;
	global $tabela;
	$separacao = "";
	$i=0;
	
	$sqlCount = "SELECT count(*) FROM {$tabela['administradores']} WHERE cur_cod = $idCurso";
	$qtd = $dataBase->getOne($sqlCount);
	
	$sql = "SELECT adm_email FROM {$tabela['administradores']} WHERE cur_cod = $idCurso";
	$resultado = $dataBase->query($sql);
	
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		if($qtd > 1){
			$separacao = ", ";
		}
		if($i+1 == $qtd){
			$separacao = "";
		}
		$retorno .= $dados['adm_email'].$separacao;
		$i++;
	}
	return $retorno;
}
/*
* Função para retornar o nome de um administrador de curso a partir de seu id
*/
function retornaNomeAdm($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT adm_nome FROM {$tabela['administradores']} WHERE adm_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Função para retornar o nome de um curso a partir de seu id
*/
function retornaNomeCur($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT cur_nome FROM {$tabela['cursos']} WHERE cur_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Função para retornar o nome de um professor a partir de seu id
*/
function retornaNomePro($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT pro_nome FROM {$tabela['professores']} WHERE pro_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
?>