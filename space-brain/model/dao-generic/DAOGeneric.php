<?php
/** 
 * SpeceBrain
 *
 * Essa classe é genérica, é extendida pelas demais classes do sistema
 * This class is generic, is extend by others system classes
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright © 2007-2009
 * @abstract
 * @package dao-generic
 */

abstract class Generic{

	/** 
	 * Atributo que irá armazenar a tabela que serão armazenados os dados.
	 * @access private  
	 * @name $tabela
	 * @var String
	 */		
    private $tabela;
	
	/** 
	 * Atributo que irá armazenar a condição para update e delete.
	 * @access private  
	 * @name $condicao
	 * @var String
	 */	    
	private $condicao;
	
	/** 
	 * Atributo que irá armazenar os campos da tabela onde serão armazenados os dados.
	 * @access private  
	 * @name $campos
	 * @var Array
	 */	    
    private $campos  = array();
	
	/** 
	 * Atributo que irá armazenar os valores que serão inseridos.
	 * @access private  
	 * @name $campos
	 * @var Array
	 */	    
    private $valores = array();
	
	/** 
	 * Atributo que irá armazenar o objeto de manipulação do banco de dados.
	 * @access private 
	 * @name $db
	 * @var DataBase
	 */	    	
	private $db;
	
	/** 
	 * Atributo que irá o nome da classe que irá herdar a classe genérica.
	 * @access private
	 * @name $nameClass
	 * @var String
	 */	    	
	private $nameClass;
	
	/** 
	 * Atributo que irá um array com os atributos da classe que irá herdar a classe genérica.
	 * @access private
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
	 * Método que retorna o objeto de manipulação de dados.
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
	 * Método que retorna um query de um registro, de acordo com a "key" passada como parâmetro.
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
	 * Método que salva um registro a partir das informações carregadas em seus
	 * atributos
	 * @access public
	 */         
    public function save(){
		$db = $this->dataBase();
        $db->insert($this->getTabela(), $this->getCampos(), $this->getValores());
    }
    
	/** 
	 * Método que atualiza uma novidade a partir das informações carregadas em seus
	 * atributos
	 * @access public
	 */
    public function update(){   
		$db = $this->dataBase();
		$db->update($this->getTabela(), $this->getCondicao(), $this->getCampos(), $this->getValores());
    }
    
	/** 
	 * Método que exclui uma novidade a partir do atributo de identificação carregado
	 * @access public
	 */
    public function delete(){
		$db = $this->dataBase();
        $db->delete($this->getTabela(), $this->getCondicao());
    }
    
	/** 
	 * Método que retorna a quantidade de registros de um objeto no banco de dados
	 * Como sempre o primeiro campo é a PK dos objetos retorna-se o maximo do campo zero
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
	 * Método que retorna o ultimo PK de um objeto
	 * Como sempre o primeiro campo é a PK dos objetos retorna-se o maximo do campo zero
	 * @access public
	 * @return int
	 */
    public function max_r(){
		
		$campos = $this->getCampos();
	
        $key = $campos[0];
		
		$sql = "SELECT MAX(".$key.") as maximo FROM ".$this->getTabela();	
			
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
	 * Método que retorna um ResultSet com elementos contidos entre limit e offset
	 * @access public
	 * @param int $limit
	 * @param int $offset
	 * @param int $keyOrder É o numero do campo que será utilizado para ordenar
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
	 * Método utilizado para retornar uma representação do objeto em formato de samblagem.
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
	 * Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
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