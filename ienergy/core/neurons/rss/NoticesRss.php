<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por extrair elementos rss
* This neuron is responsible to extract rss elements
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class NoticesRss{
	/** 
	* Variável que recebe o endereço das Noticias Rss. 
	* @access public  
	* @name $endereco 
	*/ 
    var $endereco;
    
    /** 
    * Variável que recebe o aquivo das Noticias Rss. 
    * @access public  
    * @name $xml 
    */ 
    var $xml;
    
    /** 
    * Variável do indice da Noticias Rss. 
    * @access public
    * @name $indice
    */ 
	var $indice = 0;
	
	/**
	* Construtor
	* __construct_NoticiasRss()
	*/
	public function __construct_NoticiasRss(){}

    
    /** 
    * Função para manipular NoticasRSS. 
    * @access public 
    * @param String[] $endereco Endereço da Noticia Rss. 
    * @return void 
    */ 
	function __go_NoticiasRss($endereco){
		$this->endereco = $endereco;
		@ini_set('allow_url_fopen', true);
		if ($fp = @fopen($endereco, 'r')){
			while (!@feof($fp)) {
				$this->xml .= @fread($fp, 128);
			}
			@fclose($fp);
		}else{
			$this->xml = false;
		}
	}//__go_NoticiasRss
	
	/** 
    * Função para obter os dados da tag. 
    * @access public 
    * @param Array[] $tag O nome das tags que deseja obter os dados.
    * @return Array[] Os dados do nome da tag
    */ 
	function getTag($tag){
		if ($this->indice >= $this->getQuantidade()){
			return null;
		}elseif (!$this->xml){
			return null;
		}else{
			for ($i = 0; $i<count($tag); $i++){ 
				$preg = "|<$tag[$i]>(.*?)</$tag[$i]>|s";
				preg_match_all($preg, $this->xml, $tags);
				$c = 1;
				foreach ($tags[1] as $tmpcont){
					if ($c == $this->indice){
						break;
					}else{
						$c++;
					}
				}
				$tmpcont2[$tag[$i]] = $tmpcont;
				$tmpcont2[$tag[$i]] = ereg_replace("<!\[CDATA\[","",$tmpcont2[$tag[$i]]); 
				$tmpcont2[$tag[$i]] = ereg_replace("]]>","",$tmpcont2[$tag[$i]]); 
			}
			$this->indice++;
			return $tmpcont2;
		}
	}//getTag
	
	/** 
    * Função para descobrir a quantidade de noticias foram encontrado. 
    * @access public 
    * @return Int[] A quantida de Noticias Rss
    */ 
	function getQuantidade(){
		$preg = "|<item>(.*?)</item>|s";
		preg_match_all($preg, $this->xml, $tags);
		$quantidade = 0;
		foreach ($tags[1] as $tmpcont){
			$quantidade++;
		}
		return $quantidade;
	}//getQuantidade
	
	/** 
    * Função que retorna o endereco da Noticia Rss. 
    * @access public 
    * @return String[] O endereco do objeto.
    */ 
	function getEndereco(){
		return $this->endereco;
	}//getEndereco
	
	/** 
    * Função que retorna o aquivo das Noticias Rss. 
    * @access public 
    * @return string[] O aquivo das Noticias Rss
    */ 
	function getXml(){
		return $this->xml;
	}//getXml
	
	/** 
    * Função que retorna o indice das Noticias Rss. 
    * @access public 
    * @return Int[] O indice das Noticias Rss
    */ 
	function getIndice(){
		return $this->indice;
	}//getIndice
	
	/** 
    * Função que seta o indice das Noticias Rss. 
    * @param int[] $indice O numero do indice das Noticias Rss.
    * @access public 
    */ 
	function setIndice($indice){
		$this->indice = $indice;
	}//setIndice
	
	/** 
    * Função que reseta o indice das Noticias Rss. 
    * @access public 
    */ 
	function resetIndice(){
		$this->indice = 0;
	}//resetIndice
	
	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call ($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//NoticiasRss
?>