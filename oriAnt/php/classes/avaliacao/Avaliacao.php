<?php

class Avaliacao extends Generic{

	/**
	* Atributos
	*/
	protected
		$id         = '',
		$pg         = '',
		$total      = '',
		$votantes   = '';
	
	/**
	* Construtor
	* __construct_Avaliacao()
	*/
	public function __construct_Avaliacao(){
		$this->__toFillGeneric();
	}	
	
	/** 
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$pg = $this->getPg();
		
		/* Parтmetro true, faz com que o mщtodo __toFillGeneric nуo seja chamado novamente */
		
		$condicao = $camposMap['avaliacao'][1]." = '".$pg."'";
		
		$valores = array($this->getId(),
						 $this->getPg(),
		                 $this->getTotal(),
				         $this->getVotantes()
						 );
						 		
		$this->setTabela($tabelaMap['avaliacao'], true);
		$this->setCampos($camposMap['avaliacao'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $key;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId         ($dados[$this->campos[0]]);
			$this->setPg         ($dados[$this->campos[1]]);
			$this->setTotal      ($dados[$this->campos[2]]);
			$this->setVotantes   ($dados[$this->campos[3]]);
		}
	}//__get
	
	/** 
	* Mщtodo que retorna a pontuaчуo de uma pсgina cadastrada.
	* @parm String $url
	* @access public
	*/  
	public function getStars($url){
	
		$sql .= "SELECT ".$this->campos[2].", ".$this->campos[3]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $url;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$total = $dados[$this->campos[2]];
			$votantes = $dados[$this->campos[3]];
			if(!empty($total) && !empty($votantes)){
				return floor($total/$votantes);
			}
			else{
				return 0;
			}
		}
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
}//Avaliacao
?>