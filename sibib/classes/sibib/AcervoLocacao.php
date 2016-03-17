<?php

class AcervoLocacao extends Body{

	/**
	* Atributos
	*/
	protected
		$id_acervo,
		$id_locacao,
		$data_cadastro,
		$data_baixa,
		$situacao;
		
	/** 
	* Método que será implementado nas classes herdeiras, esse método deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Parâmetro true (no método set) faz com que o método __toFillGeneric não seja chamado novamente
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
	* Método salva os acervos de um array
	* @access public
	*/  	
	function saveAcer($itens, $idLocacao){
		global $controlador;
		$objAcervo = $controlador['acervo'];
		$objAcervo->__toFillGeneric();
		foreach($itens as $value){
			$this->__toFillGeneric();
			$this->setIdAcervo($idLocacao);
			$this->setIdLocacao($value);
			$this->setDatacadastro('NOW()');
			$this->setDatabaixa('NULL');
			$this->setSituacao('1');
			$this->save();
			$objAcervo->chanceStatusAcer($value, "LOCADO"); // alterando status para LOCADO
		}
	}//saveAcer
	
	/** 
	* Método que deleta todos os acervos de uma locação
	* @access public
	*/  	
	function deleteAcer($idLocacao){
		global $controlador;
		
		/* Tornando todos acervos disponíveis */		
		$listaAcervos = $this->getAcer($idLocacao);
		
		$acervo = $controlador['acervo'];
		$acervo->__toFillGeneric();
		
		foreach($listaAcervos as $item){
			$acervo->chanceStatusAcer($item, 'DISPONÍVEL');
		}
		/* fim */
		
		$sql .= "DELETE FROM ";
		$sql .= str_replace("NPN_", "", $this->getTabela());
		$sql .= " WHERE ".$this->campos[0]." = ".$idLocacao;

		$db = Generic::dataBase();
		$db->query($sql);
	}//deleteAcer
	
	/** 
	* Método que retorna os acervos de uma locação em um array
	* @access public
	* @return Array
	*/  	
	function getAcer($idLocacao){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1]." FROM ";
		$sql .= str_replace("NPN_", "", $this->getTabela());
		$sql .= " WHERE ".$this->campos[4]." = 1";
		$sql .= " AND ".$this->campos[0]." = ".$idLocacao;
		$sql .= " ORDER BY ".$this->campos[1]." DESC";

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$arrayAcervos[] = $dados[$this->campos[1]];
			}
			return $arrayAcervos;
		}
	}//getCon
	
	/** 
	* Método que retorna a última locação de um acervo
	* @access public
	*/
	public function getLocByAcer($idAcervo){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1]." FROM ";
		$sql .= str_replace("NPN_", "", $this->getTabela());
		$sql .= " WHERE ".$this->campos[4]." = 1";
		$sql .= " AND ".$this->campos[1]." = ".$idAcervo;
		$sql .= " ORDER BY ".$this->campos[2]." DESC";

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[0]];
		}
	}
	
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
}//Usuario
?>