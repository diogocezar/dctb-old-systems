<?php

class SaidaManifesto extends Body{

	/**
	* Atributos
	*/		
	protected
		$idsaidamanifesto,
		$idveiculo,
		$data,
		$hora,
		$datacadastro,
		$databaixa,
		$situacao;
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Par�metro true (no m�todo set) faz com que o m�todo __toFillGeneric n�o seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* M�todo retorna uma lista de Embalagens e a indexa��o de seu id
	* @access public
	*/  	
	function _list(){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[1].", FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[6]." = 'TRUE'";
		$sql .= " ORDER BY ".$this->campos[1]." DESC";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//list	
	
	/** 
	* M�todo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars

	/** 
	* GETS e SETS
	* M�todo __call que � verificado a cada chamada de uma fun��o da classe, o seguinte m�todo implementa automaticamente as fun��es de GET e SET.
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
}
?>