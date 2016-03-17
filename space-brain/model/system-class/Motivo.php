<?php
/** 
 * SpeceBrain
 *
 * Essa classe é gerada automaticamente
 * This class is generated automatically
 * Motivo
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright © 2007-2009
 * @package system-class
 */

class Motivo extends Body{

	/**
	 * Atributos
	 */
		protected
		$idmotivo,
		$descricao,
		$datacadastro,
		$databaixa,
		$situacao;

	
	/** 
	 * Método que será implementado nas classes herdeiras, esse método deve preencher os atributos da classe pai (Generic)
	 * Obs. Parâmetro true (no método set) faz com que o método __toFillGeneric não seja chamado novamente
	 * @access public
	 */  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	 * Método que extrai do banco de dados um registro com determinado índice.
	 * @parm String $key
	 * @access public
	 */  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	 * Método que retorna um array com os atributos privados da classe
	 * @access public
	 */ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	/** 
	 * Métodos específicos da classe
	 */
	
			
	/** 
	 * GETS e SETS
	 * Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	 * @access public 
	 */  	
	public function __call($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
			if(empty($parametros[1])){
				$this->__toFillGeneric();
			}
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Motivo
?>