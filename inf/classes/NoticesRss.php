<?php

	 /** 
	 * xC3 || xClasses 3.0 || 2005
	 * Esta classe é a responsável por ler Noticias Rss.
	 * @author WebÚnica Informática LTDA <contato@webunica.com.br> 
	 * @version 1.7
	 * @copyright Copyright © 2005, WebÚnica Informática LTDA. 
	 * @access public 
	 * @package Rss
	 */
	 
class NoticiasRss{
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
    * Função construtora para manipular NoticasRSS. 
    * @access public 
    * @param String[] $endereco Endereço da Noticia Rss. 
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
	}
	
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
	}
	
	/** 
    * Função que retorna o endereco da Noticia Rss. 
    * @access public 
    * @return String[] O endereco do objeto.
    */ 
	function getEndereco(){
		return $this->endereco;
	}
	
	/** 
    * Função que retorna o aquivo das Noticias Rss. 
    * @access public 
    * @return string[] O aquivo das Noticias Rss
    */ 
	function getXml(){
		return $this->xml;
	}
	
	/** 
    * Função que retorna o indice das Noticias Rss. 
    * @access public 
    * @return Int[] O indice das Noticias Rss
    */ 
	function getIndice(){
		return $this->indice;
	}
	
	/** 
    * Função que seta o indice das Noticias Rss. 
    * @param int[] $indice O numero do indice das Noticias Rss.
    * @access public 
    */ 
	function setIndice($indice){
		$this->indice = $indice;
	}
	
	/** 
    * Função que reseta o indice das Noticias Rss. 
    * @access public 
    */ 
	function resetIndice(){
		$this->indice = 0;
	}
}
?>