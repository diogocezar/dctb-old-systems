<?
/**
* A seguir sуo colocados os arquivos incluidos e suas respectivas descriчѕes.
*/

/**
* Incluindo arquivo de configuraчуo com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo impressуo de erros.
*/
require_once("Errors.php");
	  /** 
	  * Esta classe щ responsavel inserir e extrair variaveis de um arquivo ini.
	  *
	  * @author xg0rd0 <xgordo@kakitus.com> 
	  * @version 1.0
	  * @copyright Copyright Љ 2005, Kakirus.com LTDA. 
	  * @access public
	  * @package Frete
	  */
	  
class IniFile{

	  /** 
      * Atributo que irс armazenar a localizaчуo do arquivo.
      * @access private  
      * @name $urlIni
	  * @var String
      */
	  var $urlIni;
	  
	  /** 
	  * Mщtodo CONSTRUTOR que adiciona seta a localizaчуo do arquivo ini.
	  * @access public 
	  * @param String $urlIni
	  * @return void
	  */
	function IniFile($urlIni){
		$this->urlIni = $urlIni;
	}
	
	  /** 
	  * Mщtodo que salva um arquivo ini
	  * @access public 
	  * @param Array $assoc_array
	  * @return boolean
	  */ 
	function setIni($assoc_array){
		$content = '';
		$sections = '';
		$path = $this->urlIni;
		
		echo $path;
				
		foreach ($assoc_array as $key => $item){
			if (is_array($item)){
				$sections .= "\n[{$key}]\n";
				foreach ($item as $key2 => $item2){
					if (is_numeric($item2) || is_bool($item2)){
						$sections .= "{$key2} = {$item2}\n";
					}
					else{
						$sections .= "{$key2} = \"{$item2}\"\n";
					}
				}      
			} 
			else{
				if(is_numeric($item) || is_bool($item)){
					$content .= "{$key} = {$item}\n";
				}
				else{
					$content .= "{$key} = \"{$item}\"\n";
				}
			}
		}
			  
		$content .= $sections;
		
		if(!$handle = fopen($path, 'w')){
			return false;
		}
		   
		if(!fwrite($handle, $content)){
			return false;
		}
		
		fclose($handle);
		return true;
	}
	
	/** 
	  * Mщtodo que retorna um array a partir de um arquivo ini
	  * @access public 
	  * @return Array
	  */ 
	function getIni($comSessao = true){
		global $erro; // Reconhecendo variavel global para os erros.
		if($comSessao){
			$retorno = parse_ini_file($this->urlIni, true);
		}
		else{
			$retorno = parse_ini_file($this->urlIni, false);
		}
		if($retorno != false){
			return $retorno;
		}
		else{
			$erroArquivoIni = new Errors($erro['INI_FILE_NOT_FI']);
		}		
	}
}
?>