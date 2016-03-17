<?php

class Informacoes extends Generic{

	/**
	* Atributos
	*/
	protected
		$historico,
		$equipe,
		$servicos,
		$links,
		$dicas,
		$trabalhos;
	   
	/**
	* Construtor
	* __construct_Informacao()
	*/
	public function __construct_Informacao(){}	
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		/* Par�metro true, faz com que o m�todo __toFillGeneric n�o seja chamado novamente */
		
		$condicao = false;
		
		$valores = array($this->getHistorico(),
						 $this->getEquipe(),
				         $this->getServicos(),
						 $this->getLinks(),
						 $this->getDicas(),
						 $this->getTrabalhos()
						 );
					 		
		$this->setTabela($tabelaMap['informacoes'], true);
		$this->setCampos($camposMap['informacoes'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setHistorico  ($dados[$this->campos[0]]);
			$this->setEquipe     ($dados[$this->campos[1]]);
			$this->setServicos   ($dados[$this->campos[2]]);
			$this->setLinks      ($dados[$this->campos[3]]);
			$this->setDicas      ($dados[$this->campos[4]]);
			$this->setTrabalhos  ($dados[$this->campos[5]]);
		}
	}//__get

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
}//Informacao
?>