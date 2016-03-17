<?php

class Acervo extends Body{

	/**
	* Atributos
	*/
	protected
		$id_acervo,
		$id_tipo_acervo,
		$id_autor,
		$id_editora,
		$numero,
		$volume,
		$titulo,
		$qtd_volumes,
		$status,
		$data_cadastro,
		$data_baixa,
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
	* Mщtodo que retorna uma lista de itens do acervo
	* @access public
	*/  	
	function _list(){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[5].",".$this->campos[6]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[11]." = 1";
		$sql .= " AND ".$this->campos[8]." = 'DISPONЭVEL'";
		$sql .= " ORDER BY ".$this->campos[6];
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}	
	}//_list
	
	/** 
	* Mщtodo que retorna uma lista de itens do acervo com sobrecarga filtrando os acervos de uma lista
	* @access public
	*/  	
	function _listWithFil($filtro){
		
		$i=0;
		foreach($filtro as $id){
			if($i+1 == count($filtro)){
				$ids .= $id;
			}
			else{
				$ids .= $id.",";
			}
			$i++;
		}
		
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[5].",".$this->campos[6]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[11]." = 1";
		$sql .= " AND ".$this->campos[0]." IN (".$ids.")";
		$sql .= " ORDER BY ".$this->campos[6];
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}	
	}//_list
	
	/** 
	* Mщtodo que altera o status de um acervo
	* @access public
	*/
	public function chanceStatusAcer($id, $status){
		$sql .= "UPDATE ".$this->getTabela();
		$sql .= " SET status = '".$status."'";
		$sql .= " WHERE id_acervo = ".$id;
		$db = Generic::dataBase();
		$db->query($sql);
	}
	
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
}//Nivel
?>