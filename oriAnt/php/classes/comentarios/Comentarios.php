<?php

class Comentarios extends Generic{

	/**
	* Atributos
	*/
	protected
		$id         = '',
		$pg         = '',
		$nome       = '',
		$email      = '',
		$url        = '',
		$comentario = '',
		$timestamp  = '';
	
	/**
	* Construtor
	* __construct_Comentarios()
	*/
	public function __construct_Comentarios(){
		$this->__toFillGeneric();
	}	
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$pg = $this->getPg();
		
		/* Par�metro true, faz com que o m�todo __toFillGeneric n�o seja chamado novamente */
		
		$condicao = $camposMap['comentarios'][0]." = '".$pg."'";
		
		$valores = array($this->getId(),
						 $this->getPg(),
						 $this->getNome(),
		                 $this->getEmail(),
						 $this->getUrl(),
						 $this->getComentario(),
				         $this->getTimestamp()
						 );
						 		
		$this->setTabela($tabelaMap['comentarios'], true);
		$this->setCampos($camposMap['comentarios'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setPg($key);
		
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId        ($dados[$this->campos[0]]);
			$this->setPg        ($dados[$this->campos[1]]);
			$this->setNome      ($dados[$this->campos[2]]);
			$this->setEmail     ($dados[$this->campos[3]]);
			$this->setUrl       ($dados[$this->campos[4]]);
			$this->setComentario($dados[$this->campos[5]]);
			$this->setTimestamp ($dados[$this->campos[6]]);
		}
	}//__get
	
	/** 
	* M�todo que retorna a quantidade de coment�rios de uma p�gina.
	* @parm String $url
	* @access public
	*/  
	public function getComments($url){
		$sql .= "SELECT count(*) as total FROM ";
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
			return $dados['total'];
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
}//Comentarios
?>