<?php
/** 
 * SpeceBrain
 *
 * Essa classe é gerada automaticamente
 * This class is generated automatically
 * Administrador
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright © 2007-2009
 * @package system-class
 */

class Administrador extends Body{

	/**
	 * Atributos
	 */
		protected
		$idadministrador,
		$idcurso,
		$nome,
		$email,
		$login,
		$senha,
		$situacao,
		$data_baixa;

	
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
	
// write your methods here

	/** 
	* M�todo que permite o acesso de um usu�rio no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLogin($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1].",".$this->campos[2].",".$this->campos[3].",".$this->campos[4].",".$this->campos[5]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE situacao = TRUE";

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$retorno = false;
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if(strtoupper($login) == strtoupper($dados[$this->campos[4]]) && $senha == $dados[$this->campos[5]]){
					$retorno['idadministrador']  = $dados[$this->campos[0]];
					$retorno['idcurso']			 = $dados[$this->campos[1]];
					$retorno['nome']             = $dados[$this->campos[2]];
					$retorno['email']            = $dados[$this->campos[3]];
					$retorno['login']            = $dados[$this->campos[4]];
					$retorno['senha']            = $dados[$this->campos[5]];
				}
			}
		}	
		return $retorno;
	}//allowLogin
	
	/** 
	* M�todo que retorna os emails dos administradores de determinado curso
	* @access public
	* @parm Integer $curso
	*/  	
	function returnEmails($curso){
		
		$separacao = "";
		$i = 0;
		$db = Generic::dataBase();
		$qtd = 0;
		
		$sqlCount = "SELECT count(*) as qtd FROM ".$this->getTabela()." WHERE idcurso = $curso AND situacao = TRUE";
		$sqlResultado = $db->query($sqlCount);
		$dados = $sqlResultado->fetchRow(DB_FETCHMODE_ASSOC);
		$qtd = $dados['qtd'];
		
		$sql = "SELECT email FROM ".$this->getTabela()." WHERE idcurso = $curso AND situacao = TRUE";
		$resultado = $db->query($sql);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			if($qtd > 1){
				$separacao = ", ";
			}
			if($i+1 == $qtd){
				$separacao = "";
			}
			$retorno .= $dados['email'].$separacao;
			$i++;
		}
		return $retorno;
	}//returnEmails

			
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
}//Administrador
?>