<?php

	 /** 
	 * xC3 || xClasses 3.0 || 2005
	 * Esta classe � a respons�vel por ler Noticias Rss.
	 * @author Web�nica Inform�tica LTDA <contato@webunica.com.br> 
	 * @version 1.7
	 * @copyright Copyright � 2005, Web�nica Inform�tica LTDA. 
	 * @access public 
	 * @package Rss
	 */
	 
class NoticiasRss{
	/** 
    * Vari�vel que recebe o endere�o das Noticias Rss. 
    * @access public  
    * @name $endereco 
    */ 
    var $endereco;
    
    /** 
    * Vari�vel que recebe o aquivo das Noticias Rss. 
    * @access public  
    * @name $xml 
    */ 
    var $xml;
    
    /** 
    * Vari�vel do indice da Noticias Rss. 
    * @access public
    * @name $indice
    */ 
	var $indice = 0;
    
    
    
    /** 
    * Fun��o construtora para manipular NoticasRSS. 
    * @access public 
    * @param String[] $endereco Endere�o da Noticia Rss. 
    * @return void 
    */ 
	function NoticiasRss($endereco){
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
	}
	
	/** 
    * Fun��o para obter os dados da tag. 
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
	}
	
	/** 
    * Fun��o para descobrir a quantidade de noticias foram encontrado. 
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
	}
	
	/** 
    * Fun��o que retorna o endereco da Noticia Rss. 
    * @access public 
    * @return String[] O endereco do objeto.
    */ 
	function getEndereco(){
		return $this->endereco;
	}
	
	/** 
    * Fun��o que retorna o aquivo das Noticias Rss. 
    * @access public 
    * @return string[] O aquivo das Noticias Rss
    */ 
	function getXml(){
		return $this->xml;
	}
	
	/** 
    * Fun��o que retorna o indice das Noticias Rss. 
    * @access public 
    * @return Int[] O indice das Noticias Rss
    */ 
	function getIndice(){
		return $this->indice;
	}
	
	/** 
    * Fun��o que seta o indice das Noticias Rss. 
    * @param int[] $indice O numero do indice das Noticias Rss.
    * @access public 
    */ 
	function setIndice($indice){
		$this->indice = $indice;
	}
	
	/** 
    * Fun��o que reseta o indice das Noticias Rss. 
    * @access public 
    */ 
	function resetIndice(){
		$this->indice = 0;
	}
}
?>