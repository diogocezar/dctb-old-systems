<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por calcular o preço de um frete
* This neuron is responsible calcule a freight price
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/
	  
class Freight{

	/** 
	* Atributo que irá armazenar o serviço selecionado.
	*
	* SEDEX          -> "40010"
	* SEDEX Hoje     -> "40290"
	* SEDEX 10       -> "40215"
	* SEDEX a Cobrar -> "40045"
	*
	* @access private  
	* @name $servico
	* @var integer
	*/
	private $servico;
	  
	/** 
	* Atributo que irá armazenar o cep de origem da encomenda.
	* @access private  
	* @name $cepOrigem
	* @var String
	*/
	private $cepOrigem;
	  
	/** 
	* Atributo que irá armazenar o cep de destino da encomenda.
	* @access private  
	* @name $cepDestino
	* @var String
	*/
	private $cepDestino;
	
	/** 
	* Atributo que irá armazenar o peso da encomenda.
	* @access private  
	* @name $peso
	* @var integer
	*/
	private $peso;
	
	/**
	* Construtor
	* __construct_Freight()
	*/
	public function __construct_Freight(){}
	
	/** 
	* Método que inicializa os atributos passados como parâmetros.
	* @access public 
	* @param integer $servico
	* @param String  $cepOrigem
	* @param String  $cepDestino
	* @param integer $peso
	* @return void
	*/  
	function __go_Freight($servico, $cepDestino, $peso, $cepOrigem=FRETE_ORIGEM){
		$this->servico = $servico;
		$this->cepDestino = $cepDestino;
		$this->peso = $peso;
		if($cepOrigem != FRETE_ORIGEM){
			$this->cepOrigem = $cepOrigem;
		}
		else{
			$this->cepOrigem = FRETE_ORIGEM;
		}
	}//__go_Freight
	
	/** 
	* Método que calcula o frete.
	* @access public 
	* @return String
	*/ 
	function calculeFreight(){
	    $correioFile = "http://www.correios.com.br/encomendas/precos/calculo.cfm?servico=". $this->servico . "&CepOrigem=".$this->cepOrigem."&CepDestino=".$this->cepDestino."&Peso=".$this->peso; 
        $resultado = join("", file($correioFile)); 
        $procura   = strpos($resultado,'Tarifa=') + strlen('Tarifa='); 
        $resultado = trim(substr($resultado, $procura)); 
        $fim = strpos($resultado,"&erro="); 
        return trim(substr($resultado,0,$fim));
	}//calculeFreight 
	
	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call ($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Freight
?>