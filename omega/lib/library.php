<?php
/**
* Conjunto de fun��es espec�ficas para o site :
*/

/**
* I N � C I O  F U  N � � E S 
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

    Esta fun��o recebe um valor num�rico e retorna uma string contendo o
    valor de entrada por extenso.
    entrada: $valor (use ponto para centavos.)
    Ex.:

    echo extenso("12428.12"); //retorna: doze mil, quatrocentos e vinte e oito reais e doze centavos

    ou use:
    echo extenso("12428.12", true); //esta linha retorna: Doze Mil, Quatrocentos E Vinte E Oito Reais E Doze Centavos

    sa�da..: string com $valor por extenso em reais e pode ser com iniciais em mai�sculas (true) ou n�o.


Changelog: Author: Rodrigo (rodrigo.bc@uol.com.br) Um pequeno detalhe nessa excelente fun��o...
Em vez de imprimir no caso: Doze Mil, Quatrocentos E Vinte E Oito Reais E Doze Centavos.
              esta imprimi: Doze Mil, Quatrocentos e Vinte e Oito Reais e Doze Centavos.

          � Muito Mais Bonito, N�o?

Rodrigo (rodrigo.bc@uol.com.br)


Changelog: Author: Alessandro Lima (mutana3@yahoo.com.br)

Acrecentei e modifiquei a fun��o para que a mesma imprima em caixa alta e baixa eliminando o problema do strtolower e strtoupper que n�o funcionam em caracteres com acento .

O c�digo original (1.0) j� era muito bom .

Alessandro
*/

function extenso($valor=0, $tipo=0, $caixa="alta") {
    
    $valor = strval($valor);
    $valor = str_replace(",",".",$valor);

    
	switch($tipo){
		case 0:
			$singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
			$plural = array("centavos", "reais", "mil", "milh�es", "bilh�es", "trilh�es", "quatrilh�es");
			$u = array("", "um", "dois", "tr�s", "quatro", "cinco", "seis", "sete", "oito", "nove");
			break;
		case 1:
			$pos   = strpos($valor,".");
			$valor = substr($valor,0,$pos);			
			$singular = array("", "", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
			$plural = array("", "", "mil", "milh�es", "bilh�es", "trilh�es", "quatrilh�es");
			$u = array("", "um", "dois", "tr�s", "quatro", "cinco", "seis", "sete", "oito", "nove");
			break;
		case 2:
			$singular = array("", "", "", "", "", "", "");
			$plural = array("", "", "", "", "", "", "");
			$u = array("", "uma", "duas", "tr�s", "quatro", "cinco", "seis", "sete", "oito", "nove");
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
    $maiusculas = array("�","�","�","�","�","�","�","�","�","�","�","�");
    $minusculas = array("�","�","�","�","�","�","�","�","�","�","�","�");
    
    
    for($i=0;$i<count($maiusculas);$i++){
    
        $rt = ereg_replace($minusculas[$i],$maiusculas[$i],$rt);	
    }     
    $rt[0] = "";

	if($tipo == 2){
		$rt[strlen($rt)-1] = "";
	}
	return $rt;                      
        
}

/** 
 *	Este script valida cpf, o n�mero inserido pode conter a formata��o que for, a fun��o retirar qualquer formata��o antes de iniciar os c�lculos. 
 *	Para usar chame a fun��o com o CPF dentro	
 *  CPF( n�mero do CPF ); 	
 *	O retorno ser� V(�lido) ou I(nv�lido).	
 *	Script By Spiderpoison	
 */ 
function validaCPF($cpf){ 
    $cpf=ereg_replace("[^0-9]","",$cpf); 
    $c=substr($cpf, 0,9); 
    $v=substr($cpf, 9,2); 
    $d=0; 
    $val=true; 
    for ($i=0;$i<9;$i++){ 
        $d+=$c[$i]*(10-$i); 
    } 
    $d==0 ? $val=false:null; 
    $d= (11-($d%11))>9 ? 0:11-($d%11); 
    $v[0]!=$d ? $val=false:null; 
    $d *=2; 
    for ($i=0;$i<9;$i++){ 
        $d+=$c[$i]*(11-$i); 
    } 
    $d= (11-($d%11))>9 ? 0:11-($d%11); 
    $v[1]!=$d ? $val=false:null; 
    ereg("0{11}|1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}",$cpf) ? $val=false : null; 
    return $val ? true : false; 
} 
/*
* Fun��o que retira os . do n�mero e conv , para .
*/
function converteMoeda($moeda){
	$moeda = str_replace(".", "", $moeda);
	$moeda = str_replace(",", ".", $moeda);
	return $moeda;
}

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
* Fun��o que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}

/*
* Fun��o para uma session num�rica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/*
* Fun��o para converter data do formato do banco para o formato utilizado
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
* Fun��o que extrai a data de um time stamp 
*/
function extraiData($stamp){
	$stamp = str_replace(" ", "", $stamp);
	$stamp = str_replace("-", "", $stamp);
	$stamp = str_replace(":", "", $stamp);
	return $stamp[6].$stamp[7].'/'.$stamp[4].$stamp[5].'/'.$stamp[0].$stamp[1].$stamp[2].$stamp[3];
}

/*
* Fun��o que extrai a hora de um time stamp
* MySQL 5.0 : "2005-12-03 08:49:37"
*/
function extraiHora($stamp){
	$stamp = str_replace(" ", "", $stamp);
	$stamp = str_replace("-", "", $stamp);
	$stamp = str_replace(":", "", $stamp);
	return $stamp[8].$stamp[9].':'.$stamp[10].$stamp[11];
}
/*
* Fun��o para desconverter data do formato do banco para o formato utilizado
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
* Fun��o que limita uma string para a quantidade de caracteres passada por par�metro
*/
function limitaStr($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

/*
* Fun��o que separa um titulo caso n�o tenha espa�o por n caracteres
*/
function quebraStr($str, $n){
	$exp = explode(" ", $str);
	for($i=0; $i<count($exp); $i++){
		$qtdParte = strlen($exp[$i]);
		$parte = $exp[$i];
		if($qtdParte > $n){
			$count = 0;
			$inicio = 0;
			$strExp = "";
			for($j=0; $j<$qtdParte; $j++){
				$incrementa = true;
				if($parte[$j] == " "){
					$inicio = $i+1;
					$count = 0;
					$incrementa = false;
				}
				if($count == $n){
					$strExp .= substr($parte, $inicio, $count)."@";
					$inicio = $j;
					$count = 0;
					$incrementa = false;
				}
				if($incrementa){
					$count++;
				}
			}
			$strExp .= substr($parte, $inicio, strlen($parte));
			$exp[$i] = $strExp;
		}
	}
	$strFinal = implode(" ", $exp);
	$strFinal  = str_replace("@ - ", " @", $strFinal);
	$strFinal  = str_replace("@-", " @", $strFinal);
	$strFinal  = str_replace("@", "- ", $strFinal);
	return $strFinal;
}

/*
* Fun��o que retorna o o nome do tipo a partir de seu id
*/
function retornaNomeTipo($idTipo){
	global $dataBase;
	global $tabela;
	$sql = "SELECT tip_tipo FROM {$tabela['tipo_user']} WHERE tip_id_user = $idTipo";	
	return $dataBase->getOne($sql);
}
/*
* Fun��o para retornar se o email est� ou n�o no newsletter
*/
function retornaNews($idEmail){
	global $dataBase;
	global $tabela;
	$sql = "SELECT ema_send_news FROM {$tabela['email']} WHERE ema_id = $idEmail";	
	return $dataBase->getOne($sql);
}
/*
* Fun��o para retornar o email a partir de seu id
*/
function retornaEmail($idEmail){
	global $dataBase;
	global $tabela;
	$sql = "SELECT ema_email FROM {$tabela['email']} WHERE ema_id = $idEmail";	
	return $dataBase->getOne($sql);
}
/*
* Fun��o para inserir um novo email e retornar seu id
*/
function insereEmail($email, $news){
	global $dataBase;
	global $tabela;
	if($news == "Sim"){ $news = "Sim"; } else { $news = "N�o"; }
	$query = new DataBase();	
	$query->Query("INSERT INTO {$tabela['email']} (ema_id, ema_email, ema_send_news) VALUES ('', '$email', '$news')");
	$sql = "SELECT MAX(ema_id) FROM {$tabela['email']}";	
	return $dataBase->getOne($sql);
}
/*
* Fun��o para atualizar um email
*/
function atualizaEmail($email, $id, $news){
	global $dataBase;
	global $tabela;
	if($news == "Sim"){ $news = "Sim"; } else { $news = "N�o"; }
	$query = new DataBase();
	$query->Query("UPDATE {$tabela['email']} SET ema_email = '$email', ema_send_news = '$news' WHERE ema_id = $id");
}
/*
* Fun��o para retornar o nome de um ator a partir de seu id
*/
function retornaNomeAtor($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT ato_nome FROM {$tabela['ator']} WHERE ato_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Fun��o para retornar o nome de um diretor a partir de seu id
*/
function retornaNomeDiretor($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT dir_nome FROM {$tabela['diretor']} WHERE dir_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}

/*
* Fun��o para retornar o nome de um g�nero a partir de seu id
*/
function retornaNomeGenero($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT gen_nome FROM {$tabela['genero']} WHERE gen_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar o nome de um filme a partir de seu id
*/
function retornaNomeFilme($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT fil_titulo FROM {$tabela['filme']} WHERE fil_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar o pre�o de um filme a partir de seu id
*/
function retornaPrecoFilme($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT cat.cat_preco FROM {$tabela['filme']} fil, {$tabela['categoria']} cat WHERE fil.cat_cod = cat.cat_cod AND fil.fil_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retirar . -
*/
function retiraSeparadores($str){
	$str = str_replace(".", "", $str);
	$str = str_replace("-", "", $str);
	return $str;
}
/*
* Fun��o para retornar o nome de uma categoria a partir de seu id
*/
function retornaNomeCategoria($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT cat_nome FROM {$tabela['categoria']} WHERE cat_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar o nome de um produto a partir de seu id
*/
function retornaNomeProduto($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT pro_nome FROM {$tabela['produtos']} WHERE pro_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar o pre�o de um produto a partir de seu id
*/
function retornaPrecoProduto($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT pro_preco FROM {$tabela['produtos']} WHERE pro_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar o nome de uma categoria a partir de seu id
*/
function retornaNomeClassificacao($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT cla_classificacao FROM {$tabela['classificacao']} WHERE cla_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o para retornar um array com o nome e link dos atores de determinado filme.
*/
function retornaAtores($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT ato_cod FROM {$tabela['ator_filme']} WHERE fil_cod = $id";	
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$atores[$dados['ato_cod']] = retornaNomeAtor($dados['ato_cod']);
	}
	return $atores;
}
/*
* Fun��o para retornar um array com o nome e link dos diretores de determinado filme.
*/
function retornaDiretores($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT dir_cod FROM {$tabela['diretor_filme']} WHERE fil_cod = $id";	
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$diretores[$dados['dir_cod']] = retornaNomeDiretor($dados['dir_cod']);
	}
	return $diretores;
}
/*
* Fun��o para retornar um array com o nome e link dos g6eneros de determinado filme.
*/
function retornaGeneros($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT gen_cod FROM {$tabela['genero_filme']} WHERE fil_cod = $id";	
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$generos[$dados['gen_cod']] = retornaNomeGenero($dados['gen_cod']);
	}
	return $generos;
}
/*
* Fun��o para retornar a avalia��o de um filme
*/
function retornaAvaliacao($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT AVG(ava_nota) FROM {$tabela['avaliacao']} WHERE fil_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return round($resultado[0]);
}
/*
* Fun��es para convers�o bbcode
*/
function bbcode($str){
	$str = str_replace("[B]", "<b>",$str);
	$str = str_replace("[/B]", "</b>",$str);
	
	$str = str_replace("[I]", "<i>",$str);
	$str = str_replace("[/I]", "</i>",$str);
	
	$str = str_replace("[U]", "<u>",$str);
	$str = str_replace("[/U]", "</U>",$str);
	
	$str = str_replace("[IMG]", "<img src=\"", $str);
	$str = str_replace("[/IMG]", "\" border=\"0\">", $str);
	
	return $str;
}
/*
* Fun��o para verificar se um filme tem pelo menos uma m�dia cadastrada
*/
function filmeComMidia($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) FROM {$tabela['midia']} WHERE fil_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	if(empty($resultado[0])){
		return false;
	}
	else{
		return true;
	}
}
/*
* Fun��o para verificar se um filme est� ou n�o locado
*/
function locado($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['filme']} fil, {$tabela['midia']} midi
			WHERE fil.fil_cod = midi.fil_cod AND fil.fil_cod = $id AND midi.mid_status = 'N�o'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return false;
	}
	else{
		return true;
	}
}
/*
* Fun��o para retornar uma m�dia disponivel para um filme
*/
function midiaDisponivel($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT midi.mid_cod
			FROM {$tabela['filme']} fil, {$tabela['midia']} midi
			WHERE fil.fil_cod = midi.fil_cod AND fil.fil_cod = $id AND midi.mid_status = 'N�o'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	return $dados['mid_cod'];
}
/*
* Fun��o para retornar local e valor da tava de entrega a partir do c�digo de um usu�rio
*/
function retornaTx($cod){
	global $dataBase;
	global $tabela;
	$sql = "SELECT tx.txe_localizacao, tx.txe_valor
			FROM {$tabela['cliente']} cli, {$tabela['taxa_entrega']} tx
			WHERE tx.txe_cod = cli.txe_cod
			AND   cli.cli_cpf = '$cod'";
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	$taxa[0] = $dados['txe_localizacao'];
	$taxa[1] = $dados['txe_valor'];
	return $taxa;
}
/*
* Fun��o para verificar se um filme � ou n�o lan�amento
*/
function lancamento($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['filme']} fil, {$tabela['categoria']} cat
			WHERE cat.cat_cod = fil.cat_cod AND fil.fil_cod = $id AND cat.cat_nome = 'Lan�amento'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o para elminiar os horarios que j� passaram
*/
function eliminaHorarios($horarios){
	$hora     = date("H");
	$minuto   = date("i");
	foreach($horarios as $indice => $valor){
		$exp = explode(" � ", $valor);
		$tempo = explode(":", $exp[0]);
		
		$horaValor     = $tempo[0];
		$minutoValor   = $tempo[1];
		
		if($horaValor <= $hora){
			unset($horarios[$indice]);
		}
	}
	return $horarios;
}
/*
* Fun��o para alterar o status de uma m�dia
*/
function alteraStatus($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT mid_status
			FROM {$tabela['midia']}
			WHERE mid_cod = $id";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['mid_status'] == "Sim"){
		$dataBase->Query("UPDATE {$tabela['midia']} SET mid_status = 'N�o' WHERE mid_cod = $id");
	}
	else{
		$dataBase->Query("UPDATE {$tabela['midia']} SET mid_status = 'Sim' WHERE mid_cod = $id");
	}
}
/*
* Fun��o alterara quantidade em estoque de um produto.
*/
function alteraQtd($id, $qtd){
	global $dataBase;
	global $tabela;
	$dataBase->Query("UPDATE {$tabela['produtos']} SET pro_qtd = pro_qtd-$qtd WHERE pro_cod = $id");
}
/*
* Fun��o que verifica se o usu�rio j� locou ou n�o um filme
*/
function qtdLocouFilme($userCpf, $codFilme){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as locacao
			FROM {$tabela['filme']} fil, {$tabela['midia']} midi, {$tabela['midia_locacao']} midi_loc, {$tabela['locacao']} loc
			WHERE loc.cli_cpf = '$userCpf' AND fil.fil_cod = $codFilme AND midi_loc.loc_cod = loc.loc_cod AND midi.mid_cod = midi_loc.mid_cod AND midi.fil_cod = fil.fil_cod
			GROUP BY fil.fil_cod";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	return $dados['locacao'];
}
/*
* Fun��o que verifica se o dia passado como par�metro � feriado
*/
function feriado($data){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['feriados']}
			WHERE fer_data = '$data'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o que retorna o nome de um usu�rio a partir de seu id
*/
function retornaNomeUsu($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT usu_nome FROM {$tabela['usuario']} WHERE usu_cod = $id";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o que retorna se o filme j� foi avaliado por um cliente
*/
function avaliado($cpf, $id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['avaliacao']}
			WHERE fil_cod = $id AND cli_cpf = '$cpf'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o que retorna se o filme est� ou n�o no favoritos
*/
function favorito($cpf, $id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['favoritos']}
			WHERE fil_cod = $id AND cli_cpf = '$cpf'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o para criar a barra de procentagem das enquetes
*/
function criaBarra($tamanho){
	$imagem = imagecreate($tamanho, 10);
	$cor    = imagecolorallocate($imagem, 82,91,104);
	header("Content-type: image/jpeg");
	imagejpeg($imagem);
}
/*
* Fun��o para retornar se um login existe
*/
function existeLogin($login){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['usuario']}
			WHERE usu_login = '$login'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o que retorna o nome do filme de uma m�dia a partir do id da m�dia
*/
function retornaFilmeMidia($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT fil_cod
			FROM {$tabela['midia']}
			WHERE mid_cod = $id";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	return retornaNomeFilme($dados['fil_cod']);
}
/*
* Fun��o que retorna o id do filme de uma m�dia a partir do id da m�dia
*/
function retornaIdFilmeMidia($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT fil_cod
			FROM {$tabela['midia']}
			WHERE mid_cod = $id";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	return $dados['fil_cod'];
}
/*
* Fun��o que retorna se um email existe
*/
function existeEmail($email){
	global $dataBase;
	global $tabela;
	$sql = "SELECT count(*) as qtd
			FROM {$tabela['email']}
			WHERE ema_email = '$email'";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if($dados['qtd'] > 0){
		return true;
	}
	else{
		return false;
	}
}
/*
* Fun��o que retorna as chaves de um cliente a partir de seu cpf
*/
function retornaChavesCliente($cpf){
	global $dataBase;
	global $tabela;
	$sql = "SELECT u.usu_cod, e.ema_id 
	        FROM cliente c, usuario u, email e 
			WHERE c.cli_cpf = '$cpf' AND c.usu_cod = u.usu_cod AND u.ema_id = e.ema_id";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	return $dados;
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
/*
* Fun��o para retornar um array com os filmes de uma loca��o
*/
function retornaFilmesLoc($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT ml.mid_cod, m.mid_cod_controle FROM {$tabela['midia_locacao']} ml, {$tabela['midia']} m WHERE loc_cod = $id AND ml.mid_cod = m.mid_cod";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$filmes[retornaIdFilmeMidia($dados['mid_cod'])] = retornaFilmeMidia($dados['mid_cod'])." (".$dados['mid_cod_controle'].") ";
	}
	return $filmes;
}
/*
* Fun��o para retornar um array com os os codigos da midia de uma locacao
*/
function retornaMidiasLoc($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT mid_cod FROM {$tabela['midia_locacao']} WHERE loc_cod = $id";	
	$resultado = $dataBase->query($sql);
	$i = 0;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$filmes[$i] = $dados['mid_cod'];
		$i++;
	}
	return $filmes;
}
/*
* Fun��o para retornar um array com os produtos de uma loca��o
*/
function retornaProdsLoc($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT pro_cod, pro_loc_qtd FROM {$tabela['produtos_locacao']} WHERE loc_cod = $id";
	$resultado = $dataBase->query($sql);
	$i = 0;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$produtos[$i]['cod'] = $dados['pro_cod'];
		$produtos[$i]['qtd'] = $dados['pro_loc_qtd'];
		$produtos[$i]['nom'] = retornaNomeProduto($dados['pro_cod']);
		$i++;
	}
	return $produtos;
}
/*
* Fun��o para retornar o nome de um usuario a partir de um cpf de cliente
*/
function retornaNomeCliente($cpf){
	global $dataBase;
	global $tabela;
	$sql = "SELECT usu.usu_nome
			FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli
			WHERE cli.cli_cpf = '$cpf' AND cli.usu_cod = usu.usu_cod";	
	$resultado = $dataBase->getRow($sql);
	return $resultado[0];
}
/*
* Fun��o que verifica se uma string � data e a transforma no padr�o mysql MM-DD-AAAA
*/
function isDate($data){
	$dataSep = str_replace("-", "#", $data);
	$dataSep = str_replace("/", "#", $data);
	$dataExp = explode("#", $dataSep);
	if(strlen($dataExp[0]) == 2 && strlen($dataExp[1]) == 2 && strlen($dataExp[2]) == 4){
		$data = str_replace("#", "/", $dataSep);
		return desconverteData($data);
	}
	else{
		return $data;
	}
}
/*
* Fun��o que retorna um array com todas as midias de um filme
*/
function retornaMidiasFilme($id){
	global $dataBase;
	global $tabela;
	$sql = "SELECT m.mid_cod, m.mid_cod_controle
	        FROM {$tabela['midia']} m, {$tabela['filme']} f WHERE f.fil_cod = $id AND m.fil_cod = f.fil_cod";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$midias[$dados['mid_cod']] = $dados['mid_cod_controle'];
	}
	return $midias;
}
?>