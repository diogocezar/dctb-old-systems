<?php

class ParametrosAdm extends Generic{

	/**
	* Atributos
	*/
	protected
		$login               = '',
		$senha               = '',
		$acrescimo_feromonio = '',
		$tx_evaporacao       = '',
		$div_diferenca       = '';
		
	/**
	* Construtor
	* __construct_ParametrosAdm()
	*/
	public function __construct_ParametrosAdm(){
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
		
		$valores = array($this->getLogin(),
		                 $this->getSenha(),
				         $this->getAcrescimo_feromonio(),
						 $this->getTx_evaporacao(),
						 $this->getDiv_diferenca(),
						 );
						 		
		$this->setTabela($tabelaMap['parametros_adm'], true);
		$this->setCampos($camposMap['parametros_adm'], true);        
		$this->setCondicao('', true);
		$this->setValores($valores, true);

    }//__toFillGeneric

	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db(){
	
		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$this->setLogin               ($dados[$this->campos[0]]);
			$this->setSenha               ($dados[$this->campos[1]]);
			$this->setAcrescimo_feromonio ($dados[$this->campos[2]]);
			$this->setTx_evaporacao       ($dados[$this->campos[3]]);
			$this->setDiv_diferenca       ($dados[$this->campos[4]]);
		}
	}//__get
	
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
}//ParametrosAdm
?>