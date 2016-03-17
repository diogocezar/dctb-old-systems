<?php
/** 
* SpeceBraid
*
* Esta classe é responsavel controlar todos seus neurônios, ou seja todas as classes do sistema, sejam classes de apoio ou classes reais.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package sendfile
*/

/**
* Arquivo de configuração do framework
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
* Framework sAjax
*/
include("../frameworks/sAjax/Sajax.php");

/**
* Classe genérica dos objetos
*/
include("../classes/generic/Generic.php");

/**
* Classe corpo dos objetos
*/
include("../classes/body/Body.php");

class Cerebro{

	/** 
	* Atributo que irá armazenar o ultimo objeto criado, que extende todos os anteriores.
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
	* Método que retorna o objeto com todas as classes extendidas.
	* @access public 
	* @return void
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
	* Método que extrai a classe a ser extendida do documento php.
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
	* Método adiciona uma nova classe ao objeto $objeto do cérebro.
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
		eval($conteudo);
		$this->objeto[strtolower($classe)] = new $classe();
		$construtor = "__construct_".$classe;
		$objetoNovo = $this->objeto[strtolower($classe)];
		$objetoNovo->$construtor();
	}//neuronio
	
	/** 
	* Método que retorna a função de erro que deverá ser agregada por todas as classes do sistema.
	* @access public
	* @return String
	*/	
	function funcaoErro($nomeClasse){
		$funcao .= 'private function erro($mensagem){';
			$funcao .= 'echo "<script language = javascript>';
			$funcao .= 'alert(\'".$mensagem."\');';
			$funcao .= 'history.go(-1);';
			$funcao .= '</script>";';
		$funcao .= '}';
		$funcao .= '}//'.$nomeClasse;
		
		return $funcao;
	}//funcaoErro
}//Cerebro
?>