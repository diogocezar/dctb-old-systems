<?php
/** 
* SpeceBrain
*
* Esta classe � a respons�vel por ler Noticias Rss.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright � 2007
* @access public
* @package rss
*/

class NoticesRss{
	/** 
	* Vari�vel que recebe o endere�o das Noticias Rss. 
	* @access public  
	* @name $endereco 
	*/ 
    var $endereco;
	
	/** 
	* Vari�vel que recebe o endere�o a ser salvo das   Noticias Rss.
	* @access public  
	* @name $endereco 
	*/ 
    var $enderecoSalva;
    
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
    * Vari�vel que armazena se a base foi extraida localmente ou da web.
    * @access public
    * @name $indice
    */ 
	var $base;
	
    /** 
    * Vari�vel que armazena o tempo para que a proxima not�cia seja pega da web.
    * @access public
    * @name $indice
    */ 
	var $timeReload;
	
    /** 
    * Vari�vel que armazena o tempo restante para atualizar as not�cias.
    * @access public
    * @name $indice
    */ 
	var $remain;
	
	/**
	* Construtor
	* __construct_NoticiasRss()
	*/
	public function __construct_NoticiasRss(){}
	
    /** 
    * Fun��o para remover espa�os e retirar caracter : '
    * @access public 
    * @param String $xml 
    * @return void 
    */	
	public function limpaXml($xml){
		$xml = trim($xml);
		$xml = str_replace("'", "\'", $xml);
		return $xml;
	}
	
    /** 
    * Fun��o para setar as not�cias localmente.
    * @access public 
    * @param String $objNoticiasRss 
    * @return void 
    */	
	public function setLocal($objNoticiasRss){
		$this->base = "BASE LOCAL";
		$this->xml  = $objNoticiasRss->getXml();
	}

    /** 
    * Fun��o para setar as not�cias pela web.
    * @access public
    * @param String $objNoticiasRss 
    * @return void 
    */	
	public function setWeb($objNoticiasRss){
		$this->base = "BASE WEB";
		if($fp = @fopen($this->endereco, 'r')){
			while (!@feof($fp)) {
				$this->xml .= @fread($fp, 128);
			}
			@fclose($fp);
			
			$this->xml = $this->limpaXml($this->xml);
			
			//Salvando localmente
			
			$agora = $this->mkTimeAgora();
			
			$objNoticiasRss->setQuando($agora);
			$objNoticiasRss->setXml($this->xml);
			$objNoticiasRss->setQtd($objNoticiasRss->getQtd()+($this->getQuantidade()-2));
			$objNoticiasRss->update();
	
		}else{
			$this->setLocal();
		}
	}
	
    /** 
    * Fun��o para extrair o tempo atual.
    * @access public 
    * @return void 
    */	
	public function mkTimeAgora(){
		$mes      = date("m");
		$diaNum   = date("d");
		$ano      = date("Y");
		
		$hora     = date("H");
		$minuto   = date("i");
		$segundo  = date("s");
		
		$agora = mktime($hora, $minuto, $segundo, $mes, $diaNum, $ano);
		
		return $agora;
	}

    /** 
    * Fun��o para o tempo de quando o arquivo de controle foi gravado.
    * @access public 
    * @param String $gravado
    * @return void 
    */
	public function mkTimeGravado($gravado){
		$mesG      = date("m", $gravado);
		$diaNumG   = date("d", $gravado);
		$anoG      = date("Y", $gravado);
		
		$horaG     = date("H", $gravado);
		$minutoG   = date("i", $gravado);
		$segundoG  = date("s", $gravado);
		
		$gravado = mktime($horaG, $minutoG, $segundoG, $mesG, $diaNumG, $anoG);
		
		return $gravado;
	}
    
    /** 
    * Fun��o para manipular NoticasRSS. 
    * @access public 
    * @param String $endereco Endere�o da Noticia Rss. 
    * @return void 
    */ 
	public function __go_NoticiasRss($endereco, $objNoticiasRss){
	
		@ini_set('allow_url_fopen', true);
	
		$this->endereco        = $endereco;
		$this->enderecoSalva   = rawurlencode($this->endereco);
		$this->timeReload      = "+2 hours";
		$troca                 = true;
		
		$agora = $this->mkTimeAgora();
		
		$objNoticiasRss->__get_db_endereco($endereco);
		
		$gravadoNoticiasRss = $objNoticiasRss->getQuando();
		
		if(!empty($gravadoNoticiasRss)){
		
			$gravado = $this->mkTimeGravado($gravadoNoticiasRss);	
		
		}
		
		$compara = strtotime($this->timeReload, $gravado);
		
		if($agora > $compara){
			$troca = false;
			$this->remain = "0:0:00";
		}
		else{
			$timeRemainLoc = $compara-$agora;
			$hora = date("H", $timeRemainLoc)-21;
			$minu = date("i", $timeRemainLoc);
			$segu = date("s", $timeRemainLoc);
			
			$this->remain = "$hora:$minu:$segu";
		}
		/*
		if($troca){
			$this->setLocal($objNoticiasRss);
		}
		else{
			$this->setWeb($objNoticiasRss);
		}*/
		$this->setLocal($objNoticiasRss);
	}//__go_NoticiasRss
	
	/** 
    * Fun��o para obter os dados da tag. 
    * @access public 
    * @param Array[] $tag O nome das tags que deseja obter os dados.
    * @return Array[] Os dados do nome da tag
    */ 
	public function getTag($tag){
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
    * Fun��o para descobrir a quantidade de noticias foram encontrado. 
    * @access public 
    * @return Int[] A quantida de Noticias Rss
    */ 
	public function getQuantidade(){
		$preg = "|<item>(.*?)</item>|s";
		preg_match_all($preg, $this->xml, $tags);
		$quantidade = 0;
		foreach ($tags[1] as $tmpcont){
			$quantidade++;
		}
		/* -2, recurso para tirar 2 feeds in�teis */
		return $quantidade;
	}//getQuantidade
	
	/** 
    * Fun��o que retorna o endereco da Noticia Rss. 
    * @access public 
    * @return String[] O endereco do objeto.
    */ 
	function getEndereco(){
		return $this->endereco;
	}//getEndereco
	
	/** 
    * Fun��o que retorna o aquivo das Noticias Rss. 
    * @access public 
    * @return string[] O aquivo das Noticias Rss
    */ 
	function getXml(){
		return $this->xml;
	}//getXml
	
	/** 
    * Fun��o que retorna o indice das Noticias Rss. 
    * @access public 
    * @return Int[] O indice das Noticias Rss
    */ 
	function getIndice(){
		return $this->indice;
	}//getIndice
	
	/** 
    * Fun��o que seta o indice das Noticias Rss. 
    * @param int[] $indice O numero do indice das Noticias Rss.
    * @access public 
    */ 
	function setIndice($indice){
		$this->indice = $indice;
	}//setIndice
	
	/** 
    * Fun��o que reseta o indice das Noticias Rss. 
    * @access public 
    */ 
	function resetIndice(){
		$this->indice = 0;
	}//resetIndice
	
	/** 
	* GETS e SETS
	* M�todo __call que � verificado a cada chamada de uma fun��o da classe, o seguinte m�todo implementa automaticamente as fun��es de GET e SET.
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