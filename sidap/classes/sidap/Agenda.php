<?php

class Agenda extends Body{

	/**
	* Atributos
	*/
	protected
		$idagenda,
		$idtipo,
		$idcliente,
		$idusuario,
		$datasolicitacao,
		$dataagenda,
		$horaagenda,
		$descricao,
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
	* Mщtodo que retorna os agendamentos maiores que determinada data e hora
	* @parm Date $data
	* @parm Time $hour
	* @access public
	*/  	
	function queryDateHour($date, $dateTomorrow, $hour){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[5].",".$this->campos[6].",".$this->campos[7].",".$this->campos[4]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[10]." = TRUE";
		$sql .= " AND (((dataagenda = '".$date."') AND (horaagenda >= '".$hour."')) OR dataagenda =  '".$dateTomorrow."')";
		$sql .= " ORDER BY dataagenda, horaagenda";
		
/*

SELECT idagenda,dataagenda,horaagenda,descricao,datasolicitacao FROM agenda WHERE situacao = TRUE 

AND (((dataagenda = '2008-08-27') AND (horaagenda >= '00:00')) OR dataagenda = '2008-08-28')

*/
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}	
	}//queryDateHour

	
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
}//Usuario
?>