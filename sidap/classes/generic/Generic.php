<?php
/** 
* SpeceBraid
*
* Essa classe � uma classe gen�rica, que � extendida pelas demais classes do sistema
* assim, todos herdeiros ter�o essas funcionalidades
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright � 2007
* @access public
* @package session
*/

abstract class Generic{

	/** 
	* Atributo que ir� armazenar a tabela que ser�o armazenados os dados.
	* @access private  
	* @name $tabela
	* @var String
	*/		
    private $tabela;
	
	/** 
	* Atributo que ir� armazenar a condi��o para update e delete.
	* @access private  
	* @name $condicao
	* @var String
	*/	    
	private $condicao;
	
	/** 
	* Atributo que ir� armazenar os campos da tabela onde ser�o armazenados os dados.
	* @access private  
	* @name $campos
	* @var Array
	*/	    
    private $campos  = array();
	
	/** 
	* Atributo que ir� armazenar os valores que ser�o inseridos.
	* @access private  
	* @name $campos
	* @var Array
	*/	    
    private $valores = array();
	
	/** 
	* Atributo que ir� armazenar o objeto de manipula��o do banco de dados.
	* @access private static
	* @name $db
	* @var DataBase
	*/	    	
	private $db;
	
	/** 
	* Atributo que ir� o nome da classe que ir� herdar a classe gen�rica.
	* @access protected static
	* @name $nameClass
	* @var String
	*/	    	
	private $nameClass;
	
	/** 
	* Atributo que ir� um array com os atributos da classe que ir� herdar a classe gen�rica.
	* @access protected static
	* @name $classVars
	* @var Array
	*/	    	
	private $classVars = array();
	
	/**
	* Construtor
	* __construct_Generic()
	*/
	public function __construct_Generic(){}
	
	/** 
	* M�todo que retorna o objeto de manipula��o de dados.
	* @access public
	* @return DataBase
	*/    
	public function dataBase(){
		if(empty($this->db)){
			$this->db = new DataBase();
			return $this->db;
		}
		else{
			return $this->db;
		}
	}
    
	/** 
	* M�todo que retorna um query de um registro, de acordo com a "key" passada como par�metro.
	* @access public
	* @param String key
	* @return ResultSet
	*/    
    public function uniqueKey($key){

        $pk        = "";
        $strCampos = "";
		$campos    = $this->getCampos();
        $separacao = "";
        
        for($i=0; $i<count($campos); $i++){
            if($i == 0) $pk = $campos[$i];
            if($i == count($campos)-1){
                $separacao = "";
            }
            else{
                $separacao = ", ";
            }
            $strCampos .= $campos[$i].$separacao; 
        }
        
        $key = "'".$key."'";
		
		if(!$this->getCondicao()){
			$sql = "SELECT ".$strCampos." FROM ".$this->getTabela();
		}
		else{		
			$sql = "SELECT ".$strCampos." FROM ".$this->getTabela()." WHERE ".$pk." = ".$key;
		}
		
		$db = $this->dataBase();
		
        return $db->query($sql);       
    }
    
	/** 
	* M�todo que salva um registro a partir das informa��es carregadas em seus
	* atributos
	* @access public
	*/         
    public function save(){
		$db = $this->dataBase();
        $db->insert($this->getTabela(), $this->getCampos(), $this->getValores());
    }
    
	/** 
	* M�todo que atualiza uma novidade a partir das informa��es carregadas em seus
	* atributos
	* @access public
	*/
    public function update(){   
		$db = $this->dataBase();
		$db->update($this->getTabela(), $this->getCondicao(), $this->getCampos(), $this->getValores());
    }
    
	/** 
	* M�todo que exclui uma novidade a partir do atributo de identifica��o carregado
	* @access public
	*/
    public function delete(){
		$db = $this->dataBase();
        $db->delete($this->getTabela(), $this->getCondicao());
    }
    
	/** 
	* M�todo que retorna a quantidade de registros de um objeto no banco de dados
	* Como sempre o primeiro campo � a PK dos objetos retorna-se o maximo do campo zero
	* @access public
	* @return int
	*/
    public function count_r($condicao){
	
		$campos = $this->getCampos();
	
        $key = $campos[0];
		
		$sql = "SELECT COUNT(".$key.") as qtd FROM ".$this->getTabela();
		
		if($condicao != false){
			$sql .= " WHERE ".$condicao;
		}
		
		$db = $this->dataBase();

		$resultado = $db->query($sql);
		
		if(!DB::isError($resultado)){				
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
			return $dados['qtd'];
		}
		else{
			$this->erro($erro['ERRO_COUNT_REGS'].$resultado->getMessage());
			return -1;
		}
    }//count_r
    
	/** 
	* M�todo que retorna o ultimo PK de um objeto
	* Como sempre o primeiro campo � a PK dos objetos retorna-se o maximo do campo zero
	* @access public
	* @return int
	*/
    public function max_r(){
		
		$campos = $this->getCampos();
	
        $key = $campos[0];
		
		$sql = "SELECT MAX(".$key.") + 1 as maximo FROM ".$this->getTabela();	
			
		$db = $this->dataBase();
				
		$resultado = $db->query($sql);
		
		if(!DB::isError($resultado)){
			
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			if($dados['maximo'] == 0){
				return 1;
			}
			else{
				return $dados['maximo'];
			}
		}
		else{
			$this->erro($erro['ERRO_G_MAX_REGS'].$resultado->getMessage());
			return -1;
		}
    }//max_r
    
	/** 
	* M�todo que retorna um ResultSet com elementos contidos entre limit e offset
	* @access public
	* @param int $limit
	* @param int $offset
	* @param int $keyOrder � o numero do campo que ser� utilizado para ordenar
	* @param String $orientation [ASC,DESC];
	* @param String $condicao
	* @return ResultSet
	*/
     
    public function rows($limit, $offset, $keyOrder, $orientation, $condicao){
	
		$campos = $this->getCampos();
        
        $sql = "SELECT ";
        
        for($i=0; $i<count($campos); $i++){
            if($i == count($campos)-1){
                $separacao = "";
            }
            else{
                $separacao = ", ";
            }
            $sql .= $campos[$i].$separacao;
        }
        
        $sql .= " FROM " . $this->getTabela();
		if($condicao != false){ $sql .= " WHERE " . $condicao; }
        $sql .= " ORDER BY " . $campos[$keyOrder];
        $sql .= " " . $orientation;
		if($limit != false && $offset != false){
			if(BASE_TYPE == 'mysql'){
				$sql .= " LIMIT " . $limit . " , " . $offset;
			}
			else{
				$sql .= " LIMIT " . $limit . " OFFSET " . $offset;
			}
		}

		$db = $this->dataBase();
				
		$resultado = $db->query($sql);
		
		if(!DB::isError($resultado)){
			return $resultado;
		}
		else{
			$this->erro($erro['ERRO_GETIN_ROWS'].$resultado->getMessage());
		}
    }//rows
	
	/** 
	* M�todo que abstrato que ser� implementado nas classes herdeiras, esse m�todo deve
	* preencher os atributos da classe pai (Generico)
	* @access public
	*/        
    //abstract public function __toFillGeneric($object = ''); 
	
	/** 
	* M�todo utilizado para retornar uma representa��o do objeto em formato de samblagem.
	* @access public
	* @return String
	*/    
	public function __toString(){
	
		$valores = get_object_vars($this);
		$variaveis = array_keys($valores);
		$arrayIgnoradas = array('tabela',
		                        'campos',
								'condicao',
								'valores'
								);
		
		for($i=0; $i<count($valores); $i++){
			$exclui = true;
			foreach($arrayIgnoradas as $valorIg){
				if($valorIg == $variaveis[$i]){
					$exclui = false;
				}
			}
			if($exclui)
			$retorno[$variaveis[$i]] .= $valores[$variaveis[$i]];
		}
	
		return $retorno;
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
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Generic
?>