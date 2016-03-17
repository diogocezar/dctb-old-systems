<?
####################################################################
#                      CLASSE PADRAO XCLASSE                       #
####################################################################
#																   #
#	Essa classe tem como objetivo suprir todas as necessidades 	   #
#	básicas que uma página feita em Php que necessite de           #
#   ferramentas para gerenciamento de 3 bancos de dados são eles:  #
#   															   #
#   MySQL														   #
#   PostGre														   #
#   FireBird                                                       #
#																   #
#	Também apresenta as seguintes serramentas :					   #
#																   #
#		1. Uma classe de utilitários diversos*                     #
#		2. Sistema de envio de email							   #
#		3. Utilitários como : Data, Hora, Ip etc... *			   #
#		4. Calendário com Links     							   #
#		5. Sistema de Envio de Fotos              		           #	
#		6. Gerenciamento de SESSIONS                               #
#       7. Gerenciamento de COOKIES      						   #
#																   #
#		*Ver funções da classe Utilitarios						   #
#																   #
####################################################################

require('./includes/configuracao.php');

/* 

 Classe Fotos -> Essa classe possue funções para Gravar e Redimensionar Fotos

 >> Descrição das funções :
 
 1. EnviaFoto($ARQUIVO, $DIRETORIO, $QUALIDADE = 90, $MSG = "SIM")
 
	$ARQUIVO -> Arqvuivo a ser gravado.
	$DIRETORIO -> Diretório a ser gravado.
	$QUALIDADE -> Qualidade da foto a ser armazenada.
	$MSG -> Mensagem de gravação com sucesso.
	
 2. TamanhoFoto($ONDE, $TAM_LARGURA, $TAM_ALTURA, $MSG_ERRO = 'Erro ao carregar imagem.')
 
 	$ONDE -> Diretório do arquivo a ser modificado.
	$TAM_LARGURA -> Largura da Imagem.
	$TAM_ALTURA -> Altura da Imagem.
	$MSG_ERRO -> Mensagem de erro caso não seja possivel gerar a imagem
  
*/

class Fotos{
	
	function EnviaFoto($ARQUIVO, $DIRETORIO, $MSG = "SIM", $QUALIDADE = 70){
	
		global $ERRO, $STYLE, $EXT, $ENDERECO;
		
		$Util = new Util;
	
		$Nome = str_replace(" ", "_", $ARQUIVO['name']); 
		$Nome = strtolower($Nome); 
		$Quantos = strlen($Nome);
		$Tipo = substr($Nome, ($Quantos-3), $Quantos);
		$tipoExt = $Tipo;
		$Cont = count($EXT);
		
		if(strlen($Nome) > 50){
			return $ERRO[_ERR_MLETRA]; //Modificado
		}
		
		for($i=0; $i<$Cont; $i++){
			if($EXT[$i] == $Tipo){				
				$Permissao = OK;
				$Extensao = $Tipo;
			}
		}
				
		$Retorno = $Nome;
		$Nome = $DIRETORIO.'/'.$Nome;
	
			
		/* Verifica se existe o arquivo com alguma das extenções */
		for($i=0; $i<$Cont; $i++){
			$EXP_NOME = explode('.', $Nome);
			if (file_exists($DIRETORIO.'/'.$EXP_NOME[0].'.'.$EXT[$i])) { 
				return $ERRO[_ERR_FILEXI]; //Modificado
			}	
		}
				
		if($Permissao == OK){			
			if (move_uploaded_file($ARQUIVO['tmp_name'], $Nome)) {
				// Renomeando o arquivo para sua verdadeira extenção.
				$TIPOARQUIVO = $ARQUIVO['type'];
				$EXP = explode('/', $TIPOARQUIVO);
				$TIPOARQUIVO = $EXP[1];
						
				if($TIPOARQUIVO == 'pjpeg'){
					$TIPOARQUIVO = 'jpg';
				}
										
				if($Tipo != $TIPOARQUIVO){
					$NomeArquivo = $Retorno;
					$EXP_ARQUIV = explode('.',$NomeArquivo);
					rename($Nome, $DIRETORIO.'/'.$EXP_ARQUIV[0].'.'.$TIPOARQUIVO);
					$Tipo = $TIPOARQUIVO;
					$Retorno = $EXP_ARQUIV[0].'.'.$TIPOARQUIVO;
					$Nome = $DIRETORIO.'/'.$Retorno;		
				}			  
				switch($Tipo){					  
					case 'jpg':
						$IMAGEM = imagecreatefromjpeg($Nome);
						imagejpeg($IMAGEM, "./".$DIRETORIO."/".$Retorno, $QUALIDADE);
						$TAMANHO = filesize($Nome);
						$TAMANHOKB = ceil($TAMANHO/100);
						$TIPOARQUIVO = $ARQUIVO['type'];
						$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
						while(file_exists($NOVONOME)){
							$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
							sleep(1);
						} 
						rename($Nome, $NOVONOME);
						$Retorno = $NOVONOME;
						if($MSG == "SIM"){
							echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Arquivo : <b>$Retorno</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Diretório : <b>$DIRETORIO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tamanho : <b>".$TAMANHOKB."Kb</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tipo : <b>$TIPOARQUIVO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}<a href = \"".$ENDERECO['SITE'].$Nome."\"> Ver File </a>{$STYLE['FECHA']}";
							return $Retorno;
						}
						else{							
							$Retorno = $NOVONOME;
							//echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							return $Retorno;
						}
					break;
							
					case 'gif':
						$IMAGEM = imagecreatefromgif($Nome);
						imagegif($IMAGEM, "./".$DIRETORIO."/".$Retorno);
						$TAMANHO = filesize($Nome);
						$TAMANHOKB = ceil($TAMANHO/100);
						$TIPOARQUIVO = $ARQUIVO['type'];
						$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
						while(file_exists($NOVONOME)){
							$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
							sleep(1);
						} 
						rename($Nome, $NOVONOME);
						$Retorno = $NOVONOME;
						if($MSG == "SIM"){
							echo "{$STYLE['ENVIO']}Arquivo : <b>$Retorno</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Diretório : <b>$DIRETORIO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tamanho : <b>".$TAMANHOKB."Kb</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tipo : <b>$TIPOARQUIVO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}<a href = \"".$ENDERECO['SITE'].$Nome."\"> Ver File </a>{$STYLE['FECHA']}";
							return $Retorno;
						}
						else{
							$Retorno = $NOVONOME;
							//echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							return $Retorno;
						}
					break;
					
					case 'png':
						$IMAGEM = imagecreatefrompng($Nome);
						imagepng($IMAGEM, "./".$DIRETORIO."/".$Retorno);
						$TAMANHO = filesize($Nome);
						$TAMANHOKB = ceil($TAMANHO/100);
						$TIPOARQUIVO = $ARQUIVO['type'];
						$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
						while(file_exists($NOVONOME)){
							$NOVONOME = $DIRETORIO.'/'."foto_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$Tipo;
							sleep(1);
						} 
						rename($Nome, $NOVONOME);
						$Retorno = $NOVONOME;
						if($MSG == "SIM"){
							echo "{$STYLE['ENVIO']}Arquivo : <b>$Retorno</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Diretório : <b>$DIRETORIO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tamanho : <b>".$TAMANHOKB."Kb</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tipo : <b>$TIPOARQUIVO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}<a href = \"".$ENDERECO['SITE'].$Nome."\"> Ver File </a>{$STYLE['FECHA']}";
							return $Retorno;
						}
						else{
							$Retorno = $NOVONOME;
							//echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							return $Retorno;
						}
					break;
							
					case 'x-shockwave-flash':
						$TAMANHO = filesize($Nome);
						$TAMANHOKB = ceil($TAMANHO/100);
						$TIPOARQUIVO = $ARQUIVO['type'];
						$NOVONOME = $DIRETORIO.'/'."flash_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.swf';
						while(file_exists($NOVONOME)){
							$NOVONOME = $DIRETORIO.'/'."flash_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.swf';
							sleep(1);
						} 
						rename($Nome, $NOVONOME);
						$Retorno = $NOVONOME;
						if($MSG == "SIM"){
							echo "{$STYLE['ENVIO']}Arquivo : <b>$Retorno</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Diretório : <b>$DIRETORIO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tamanho : <b>".$TAMANHOKB."Kb</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tipo : <b>$TIPOARQUIVO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}<a href = \"".$ENDERECO['SITE'].$Nome."\"> Ver File </a>{$STYLE['FECHA']}";
							return $Retorno;
						}
						else{
							$Retorno = $NOVONOME;
							//echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							return $Retorno;
						}
					break;
					default:
						$TAMANHO = filesize($Nome);
						$TAMANHOKB = ceil($TAMANHO/100);
						$TIPOARQUIVO = $ARQUIVO['type'];
						$NOVONOME = $DIRETORIO.'/'."file_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$tipoExt;
						while(file_exists($NOVONOME)){
							$NOVONOME = $DIRETORIO.'/'."file_".substr(md5(date("s")+date("i")+date("h")+date("m")),0,10).'.'.$tipoExt;
							sleep(1);
						} 
						rename($Nome, $NOVONOME);
						$Retorno = $NOVONOME;
						if($MSG == "SIM"){
							echo "{$STYLE['ENVIO']}Arquivo : <b>$Retorno</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Diretório : <b>$DIRETORIO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tamanho : <b>".$TAMANHOKB."Kb</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}Tipo : <b>$TIPOARQUIVO</b>{$STYLE['FECHA']}";
							$Util->Br();
							echo "{$STYLE['ENVIO']}<a href = \"".$ENDERECO['SITE'].$Nome."\"> Ver File </a>{$STYLE['FECHA']}";
							return $Retorno;
						}
						else{
							$Retorno = $NOVONOME;
							//echo "{$STYLE['ENVIO']}Arquivo <b>$Retorno</b> Enviado com sucesso !{$STYLE['FECHA']}";
							return $Retorno;
						}
					break;
							
				}//Switch								  
			}//If 
			else{ 
				echo "<script language=javascript>alert('Falha ao enviar o arquivo $Retono');history.go(-1)</script>";
				exit();
			} 
		}		  
		else{
			echo "<script language=javascript>alert('A extensão do arquivo enviado não é permitida');history.go(-1)</script>";
			exit();
		}//Else
	}//EnviaFoto
	
	function TamanhoFoto($ONDE, $TAM_LARGURA, $TAM_ALTURA, $MSG_ERRO = 'Erro ao carregar imagem.'){
		
		define(MAX_WIDTH, $TAM_LARGURA); 
		define(MAX_HEIGHT, $TAM_ALTURA); 
		
		// Pegando o MIME do arquivo
		
		$Quantos = strlen($ONDE);
		$Ext = substr($ONDE, ($Quantos-3), $Quantos);
		
		if($Ext == 'gif'){
			// Carrega a imagem 
			$Img = imagecreatefromgif($ONDE);
			$Cria = 'gif';
		}
		if($Ext == 'jpg'){
			// Carrega a imagem 
			$Img = imagecreatefromjpeg($ONDE); 
			$Cria = 'jpg';
		}
		if($Ext == 'png'){
			// Carrega a imagem 
			$Img = imagecreatefrompng($ONDE); 
			$Cria = 'png';
		}
		
		// Se a imagem foi carregada com sucesso, testa o tamanho da mesma 
		if ($Img) { 
				
			// Pega o tamanho da imagem e proporção de resize 
			$Width = imagesx($Img); 
			$Height = imagesy($Img); 
			$Scale = min(MAX_WIDTH/$Width, MAX_HEIGHT/$Height); 
			
			// Se a imagem é maior que o permitido, encolhe ela! 
			if ($Scale < 1) {
			 
				$New_Width = floor($Scale*$Width); 
				$New_Height = floor($Scale*$Height); 
			
				// Cria uma imagem temporária 
				$Tmp_Img = imagecreatetruecolor($New_Width, $New_Height); 
				
				// Copia e resize a imagem velha na nova 
				imagecopyresampled($Tmp_Img, $Img, 0, 0, 0, 0, 
				$New_Width, $New_Height, $Width, $Height); 
				imagedestroy($Img); 
				$Img = $Tmp_Img; 
			} 
		} 
		// Cria uma imagem de erro se necessário
		if (!$Img) { 
			$Img = imagecreate(MAX_WIDTH, MAX_HEIGHT); 
			
			imagecolorallocate($Img,204,204,204); 
			
			$C = imagecolorallocate($Img,153,153,153); 
			$C1 = imagecolorallocate($Img,0,0,0); 
			
			imageline($Img,0,0,MAX_WIDTH,MAX_HEIGHT,$C); 
			imageline($Img,MAX_WIDTH,0,0,MAX_HEIGHT,$C); 
			imagestring($Img, 2, 12, 55, $MSG_ERRO,$C1 ); 
		} 		
		// Mostra a imagem 
		switch($Cria){
			case 'jpg':
				header("Content-type: image/jpeg");
				imagejpeg($Img);
			break;
			case 'gif':
				header("Content-type: image/gif");
				imagegif($Img);
			break;
			case 'png':
				header("Content-type: image/gif");
				imagegif($Img);
			break;
		}//Switch
	}//TamanhoFoto
	
}//Fotos

?>