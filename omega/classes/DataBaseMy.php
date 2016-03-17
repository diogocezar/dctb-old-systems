<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo impress�o de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe � responsavel por fazer a manipula��o do banco de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package Connection
	 */
	  
class DataBase{
	  /** 
      * Atributo que ir� armazenar o banco de dados.
	  * 1 - MySQL;
	  * 2 - PostGreSQL;
	  * 3 - FireBird/InterBase;
	  *
      * @access private  
      * @name $banco
	  * @var integer
      */
	var $opBanco;
	  
	  /** 
      * Atributo que ir� armazenar o nome do banco.
      * @access private  
      * @name $conectado
	  * @var boolean
      */ 
	var $banco;
	
	  /** 
      * Atributo que ir� armazenar se a classe j� est� ou n�o conectada.
      * @access private  
      * @name $conectado
	  * @var boolean
      */	
	var $conectado;
	
	  /** 
      * Atributo que ir� armazenar o host ao qual o banco deve se conectar.
      * @access private  
      * @name $host
	  * @var String
      */		
	var $host;
	
	  /** 
      * Atributo que ir� armazenar o usu�rio utilizado para conex�o do banco de dados.
      * @access private  
      * @name $user
	  * @var String
      */		
	var $user;
	
	  /** 
      * Atributo que ir� armazenar a senha para conex�o com o banco de dados.
      * @access private  
      * @name $conectado
	  * @var boolean
      */		
	var $pass;
	
	  /** 
      * Atributo que a localiza��o do banco de dados (caso FireBird ou InterBase)
      * @access private  
      * @name $conectado
	  * @var boolean
      */		
	var $path;
		
	  /**
	  * Construtor
	  */
	   
	  /** 
	  * M�todo construtor para inicializar as vari�veis e conectar ao banco.
	  * @access public 
	  * @param integer $opBanco
	  * @param String  $banco
	  * @param String  $host
	  * @param String  $user
	  * @param String  $pass
	  * @param String  $path	  
	  * @return void
	  */  
	 function DataBase($opBanco, $banco, $host, $user, $pass, $path){
	 
	 	$this->opBanco = $opBanco;
		$this->banco   = $banco;
		$this->host    = $host;
		$this->user    = $user;
		$this->pass    = $pass;
		$this->path    = $path;
		
		$this->Connect();
		 	
	 }//Construtor
	 
	  /** 
	  * M�todo que verifica se os atributos est�o setados.
	  * @access public 
	  * @return void
	  */  
	 function veryAttribs(){
	 	/* Campos obrigat�rios */
		/* Senha e Path n�o verificados pois podem estar em branco */
		if(empty($this->opBanco) || empty($this->banco) || empty($this->user)){
			return false;
		}
		else{
			return true;
		}
     }//veryAttribs 
	 
	  /** 
	  * M�todo que faz a conex�o com o banco de dados dependendo da op��o do banco selecionada.
	  * @access public 
	  * @return void
	  */  
	function Connect(){
		global $erro; // Reconhecendo variavel global para os erros.
		if($this->veryAttribs()){
			switch($this->opBanco){
				case 1:
					/* MySQL */					
					$link = mysql_connect($this->host, $this->user, $this->pass);
					if(!mysql_select_db($this->banco, $link)){
						$mysqlError = str_replace("'", '"', mysql_error());
						$erroMySQL = new Errors();
						$erroMySQL->erroConnection($erro['CONNECT_TO_DATA'].$mysqlError);	
					}
				break;
				
				case 2:
					/* PostGreSQL */
					$erroPgSQL = new Errors();
					$strConnection = "host=".$this->host." user=".$this->user." password=".$this->pass." dbname=".$this->banco;
					$link = pg_connect($strConnection);
					if(!$link){
						$erroPgSQL = new Errors();
						$erroPgSQL->erroConnection($erro['CONNECT_TO_DATA']."Par�metors incorretos !");	
					}
				break;
				
				case 3:
					/* FireBird / InterBase */
					$strConnection = $this->host.":".$this->path."\\".$this->banco;
					if(!ibase_connect($strConnection, $this->user, $this->pass)){
						$erroFbSQL = new Errors();
						$erroFbSQL->erroConnection($erro['CONNECT_TO_DATA'].ibase_errmsg());
					}
				break;			
			}
		}
	}//Conectar()
	
      /** 
	  * M�todo que executa um query e retorna um resultado de acordo com a op��o passada tamb�m como par�metro.
	  * $result = '_nenhum' ou $result = '' (Padr�o) - Retorna o proprio query da senten�a SQL exzecutada.
	  * $result = '_array' - Retorna a senten�a em formato de array (indexado pelos nomes das colunas da tabela).
	  * $result = '_rows'  - Retorna a senten�a em formato de array (indexado por n�meros sequenciais).
	  * @access public
	  * @param String $sql
	  * @param String $result 
	  * @return Array|Query
	  */  
	function Query($sql, $result = "_nenhum"){ 
		global $erro; // Reconhecendo variavel global para os erros.
		
		/* Normalmente quando se executa um query, coloca-se o resultado dentro de um while, assim para que a consulta
		   n�o se repita a cada exibi��o do la�o, uma variavel est�tica � colocada para fazer este controle, onde s� executar�
		   a consulta (query) a primeira vez que o objeto for instanciado. */
		   
		/* Static faz com que esse valor exista enquanto algum objeto da classe existir */
		 
		static $fSQL = ''; 
		static $exec = ''; 		
		
		if($fSQL != $sql){
			$fSQL = $sql;
			switch($this->opBanco){
				case 1:
					$exec = mysql_query($sql);
				break;
				
				case 2:
					$exec = pg_query($sql);
				break;
				
				case 3:
					$exec = ibase_query($sql);
				break;
			}
		}
		if(!$exec){
			$erroQue = new Errors($erro['QUERY_ERRO_CAMP']);	
		}
		switch ($result){ 
			case '_array':
				switch($this->opBanco){
					case 1:
						return mysql_fetch_array($exec); 
					break;
					
					case 2:
						return pg_fetch_array($exec); 
					break;
					
					case 3:
						return ibase_fetch_assoc($exec); 
					break;
				}	 
			break; 
			case '_rows':
				switch($this->opBanco){
					case 1:
						return mysql_num_rows($exec);
					break;
					
					case 2:
						return pg_num_rows($exec); 
					break;
					
					case 3:
						return ibase_fetch_row($exec); 
					break;
				}	
			break; 
			case '_nenhum': 
				return $exec;                      
			break;
		}
	}//Query
	
	
	  /** 
	  * M�todo que fecha uma conex�o com o banco de dados.
	  * @access public
	  * @return void
	  */  	
	function Close(){
		switch($this->opBanco){
			case 1:
				mysql_close();
			break;
			
			case 2:
				pg_close(); 
			break;
			
			case 3:
				ibase_close(); 
			break;
		}	
	}//Close
	
	  /** 
	  * M�todo que faz uma inser��o no banco de dados.
	  * @access public
	  * @param String $tabela
	  * @param Array  $campos
	  * @param Array  $valores
	  * @return void
	  */  
	function Insert($tabela, $campos, $valores){				
		global $erro; // Reconhecendo variavel global para os erros.
		
		if(empty($campos) || empty($tabela) || count($campos) != count($valores) || empty($tabela)){
			$erroIns = new Errors($erro['INSERT_ERRO_CAM']);	
		}
		
		foreach($campos  as $campo){
			$x++;
			$virgula = ",";
			if($x == count($campos)){
				$virgula="";
			}
			$fields .= $campo.$virgula;			
		}
		foreach($valores as $valor){
			$y++;
			$virgula = ",";
			if($y == count($valores)){
				$virgula="";
			}			
			$values .= "\"".$valor."\"".$virgula;
		}
		$sql = "INSERT INTO $TABELA ($FIELDS) VALUES ($VALUES)";
		$this->Query($sql);					
	}// Insert
	
      /** 
	  * M�todo que faz uma exclus�o no banco de dados.
	  * @access public
	  * @param String $tabela
	  * @param String $condicao
	  * @return void
	  */  
	function Delete($tabela, $condicao){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($tabela) || empty($condicao)){
			$erroDel = new Errors($erro['DELETE_ERRO_CAM']);	
		}
		$sql = "DELETE FROM $tabela WHERE $condicao";
		$this->Query($sql);
	}// Deletar
	
	
	  /** 
	  * M�todo que faz uma atualiza��o no banco de dados.
	  * Se a condi��o estiver vazia, todos registros ser�o alterados.
	  * @access public
	  * @param String $tabela
	  * @param String $condicao
	  * @param Array  $campos
	  * @param Array  $valores
	  * @return void
	  */  
	function Update($tabela, $condicao, $campos, $valores){
		global $erro; // Reconhecendo variavel global para os erros.
			
		if(empty($tabela) || count($campos) != count($valores)){
			$erroUpd = new Errors($erro['DELETE_UPDA_CAM']);	
		}
		
		$limite = count($campos);
		$sql = "UPDATE $TABELA SET ";
		$igual = " = ";
		$virgula = ", ";
		for($i=0; $i<$limite; $i++){
			$sql.= $campos[$i].$igual."'".$valores[$i]."'";
			if($i<($limite-1)){
				$sql.= $virgula;
			}		
		}
		if(!empty($condicao)){
			$sql.= " WHERE $condicao";
		}
		$this->Query($sql);		
	}//Update
}//DataBase
?>