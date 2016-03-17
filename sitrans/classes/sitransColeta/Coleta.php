<?php

class Coleta extends Body{

	/**
	* Atributos
	*/		
	protected
		$idcoleta,
		$versao,
		$codigo,
		$idcliente,
		$idcontato,
		$idveiculo,
		$idfornecedor,
		$idusuario,
		$idusuariobaixa,
		$idstatus,
		$idmotivo,
		$idembalagem,
		$idrestricao,
		$data,
		$hora,
		$qtdadenotafiscal,
		$qtdadevolumes,
		$peso,	
		$obscoleta,		 
		$datacadastro,
		$databaixa;
	
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
	* M�todo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	public function __get_dbColeta($key, $versao){
	
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[0]." = ".$key;
		$sql .= " AND ".$this->campos[1]." = ".$versao;
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$i = 0;
			$arrayClassVars = $this->getClassvars();
			foreach($arrayClassVars as $name => $value){
				$nomeVar = Body::convertSet($name);
				$this->$nomeVar($dados[$this->campos[$i++]]);
			}
		}
	}//__get
	
	/** 
	* M�todo que verifica se um cliente j� est� cadastrado em uma determinada data de uma coleta
	* @access public
	*/ 
	public function checkClienteData($idCliente, $data){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[3]." = ".$idCliente;
		$sql .= " AND ".$this->campos[13]." = '".converteData($data)."'";
		
		//return $sql;
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if(!empty($dados['idcliente'])){
				return 1;
			}
			else{
				return 0;
			}
		}
	}
	
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