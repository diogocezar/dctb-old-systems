<?php

class Agregado extends Body{

	/**
	* Atributos
	*/
	
	protected
		$idagregado,
		$idpessoa,
		$nome,
		$cnpjcpf,
		$inscestadualrg,
		$datacadastro,
		$databaixa,
		$situacao;
		
	/** 
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Parтmetro true (no mщtodo set) faz com que o mщtodo __toFillGeneric nуo seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* Mщtodo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	/** 
	* Mщtodo que verifica se a pessoa jс existe no banco
	* @access public
	*/  	
	function exists($nome){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[2]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[2]." = '".$nome."'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if(empty($dados[$this->campos[2]])){
				return false;
			}
			else{
				return true;
			}
		}
	}//exists
	
	/** 
	* Mщtodo retorna uma lista de agregados e a indexaчуo da tabela pessoa
	* @access public
	*/  	
	function _list($index = 'pessoa'){
		global $tabelaMap;
		global $camposMap;
		
		if($index == 'pessoa'){
			$campoIndex = $this->campos[1];
		}
		else{
			$campoIndex = $this->campos[0];
		}

		$sql .= "SELECT ".$this->campos[2].", ".$campoIndex." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[7]." = 'TRUE'";
		$sql .= " ORDER BY ".$this->campos[2]." ASC";

		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//list	
		
	/** 
	* GETS e SETS
	* Mщtodo __call que щ verificado a cada chamada de uma funчуo da classe, o seguinte mщtodo implementa automaticamente as funчѕes de GET e SET.
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
}//Agregado
?>