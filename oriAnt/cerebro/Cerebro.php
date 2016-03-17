<?php
/**
* Arquivo de configura��o do framework
*/
include("../conf/config.php");

/**
* Arquivo com o mapeamento das tabelas
*/
include('../conf/tableMapping.php');

/**
* Arquivo com constantes de erro
*/
include('../conf/errors.php');

/**
* Framework sAjax
*/
include("../frameworks/sAjax/Sajax.php");

/**
* Framework PEAR
*/
include("../frameworks/Pear/PEAR.php");

/**
* Framework PEAR::DB
*/
include("../frameworks/DB/DB.php");

/**
* Framework PEAR::HTML_Template_IT
*/
include("../frameworks/HTML_Template_IT/IT.php");

/**
* Classe gen�rica dos objetos
*/
include("../classes/generic/Generic.php");

class Cerebro{

	/** 
	* Atributo que ir� armazenar o ultimo objeto criado, que extende todos os anteriores.
	* @name $objeto
	* @var Object
	*/		
	public $objeto;
	
	/**
	* Construtor
	* ___construct()
	*/
	public function __construct() {
		flush();
	}//__construct
	
	/** 
	* M�todo que retorna o objeto com todas as classes extendidas.
	* @access public 
	* @return object
	*/  
	public function getFrameWork(){
		if(empty($this->objeto)){
			return;
		}
		else{
			return $this->objeto;
		}
	}//getFrameWork
	
	/** 
	* M�todo que extrai a classe a ser extendida do documento php.
	* @access public
	* @param String[] $linhas
	* @return String[]
	*/  
	private function clearClass($linhas){
		$totalLinhas = count($linhas);
		for($i=0; $i<$totalLinhas; $i++){
			if($i == 0 || $i == ($totalLinhas-1) || $i == ($totalLinhas-2)){
				unset($linhas[$i]);
			}
		}
		return $linhas;
	}//clearClass
	
	/** 
	* M�todo adiciona uma nova classe ao objeto $objeto do c�rebro.
	* @access public
	* @param String $diretorio
	* @param String $classe
	* @return void
	*/
	public function neuronio($diretorio, $classe){
		$conteudo   = file($diretorio.$classe.".php");
		$conteudo   = $this->clearClass($conteudo);
		$conteudo   = implode("",$conteudo);
		$funcaoErro = $this->funcaoErro($classe);
		$conteudo  .= $funcaoErro;
		@eval($conteudo);
		$this->objeto[strtolower($classe)] = new $classe();
		$construtor = "__construct_".$classe;
		$objetoNovo = $this->objeto[strtolower($classe)];
		$objetoNovo->$construtor();
	}//neuronio
	
	/** 
	* M�todo que retorna a fun��o de erro que dever� ser agregada por todas as classes do sistema.
	* @access public
	* @return String
	*/	
	function funcaoErro($nomeClasse){
		$funcao .= 'private function erro($mensagem){';
			$funcao .= 'echo "<script language = javascript>';
			$funcao .= 'alert(\'".$mensagem."\');';
			$funcao .= '</script>";';
			$funcao .= 'die();';
		$funcao .= '}';
		$funcao .= '}//'.$nomeClasse;
		
		return $funcao;
	}//funcaoErro
}//Cerebro
?>