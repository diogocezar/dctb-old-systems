<?php
/** 
* SpeceBrain
*
* Esse neur�nio � responsavel por enviar e-mails
* This neuron is responsible to send e-mails
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright � 2007-2009
* @access public
* @package neuron
*/
	 
class SendMail{

	/** 
	* Atributo que ir� armazenar o t�tulo do email a ser enviado.
	* @access private  
	* @name $titulo
	* @var String
	*/		
	private $titulo;
	
	/** 
	* Atributo que ir� armazenar o conte�do do email a ser enviado.
	* @access private  
	* @name $conteudo
	* @var String
	*/		
	private $conteudo;
	
	/** 
	* Atributo que ir� armazenar o destino do email a ser enviado.
	* @access private  
	* @name $destino
	* @var String
	*/		
	private $destino;
	
	/** 
	* Atributo que ir� armazenar a origem do email a ser enviado.
	* @access private  
	* @name $origem
	* @var String
	*/		
	private $origem;
	
	/** 
	* Atributo que ir� armazenar Empresa/Autor do email a ser enviado.
	* @access private  
	* @name $origem
	* @var String
	*/		
	private $autor;

	/** 
	* Atributo que ir� armazenar a a mensagem do rodap� do email.
	* @access private  
	* @name $origem
	* @var String
	*/		
	private $msgFinal;

	/** 
	* Atributo que ir� armazenar o cabe�alho do email a ser enviado.
	* @access private  
	* @name $header
	* @var String
	*/		
	private $header;
	
	/** 
	* Atributo que ir� armazenar o diret�rio do arquivo de template.
	* @access private 
	* @name $templateHtmlDir
	* @var String
	*/		
	private $templateHtmlDir;
	
	/** 
	* Atributo que ir� armazenar o nome do arquivo de template.
	* @name $templateHtmlName
	* @var String
	*/		
	private $templateHtmlName;
	
	/**
	* Construtor
	* __construct_SendMail()
	*/
	public function __construct_SendMail(){}
	
	 /** 
	  * M�todo que inicializa os atributos passados como par�metro.
	  * @access public 
	  * @param String $titulo
	  * @param String $conteudo
	  * @param String $destino
	  * @param String $origem
	  * @param String $templateHtml
	  * @return void
	  */  
	function __go_SendMail($titulo, $conteudo, $destino, $origem=ORIGEM, $autor=AUTOR, $msgFinal=MSG_FINAL, $templateHtmlDir=TEMPLATE_HTML_DIR, $templateHtmlName=TEMPLATE_HTML_NAME){
		if(!empty($titulo) && !empty($conteudo) && !empty($destino)){
		
			/* Vari�veis Obrigat�rias */
			$this->titulo           = $titulo;
			$this->conteudo         = $conteudo;
			$this->destino          = $destino;
			$this->origem           = ORIGEM;
		    $this->autor            = AUTOR;
			$this->msgFinal         = MSG_FINAL;
			$this->templateHtmlDir  = TEMPLATE_HTML_DIR;
			$this->templateHtmlName = TEMPLATE_HTML_NAME;
			
			/* Vari�veis Opcionais */
			if($origem != ORIGEM){
				$this->origem = $origem;
			}
			
			if($autor != AUTOR){
				$this->autor = $autor;
			}
			
			if($msgFinal != MSG_FINAL){
				$this->msgFinal = $msgFinal;
			}

			if($templateHtmlDir != TEMPLATE_HTML_DIR){
				$this->templateHtmlDir = $templateHtmlDir;
			}
			
			if($templateHtmlName != TEMPLATE_HTML_NAME){
				$this->templateHtmlName = $templateHtmlName;
			}
		}
	}//__go_SendMail
	
	  /** 
	  * M�todo que envia o email.
	  * @access public 
	  * @return void
	  */  
	function goMail(){
	 	global $erro; // Reconhecendo variavel global para os erros.
		
		if(file_exists($this->templateHtmlDir.$this->templateHtmlName)){
		
			$template = new HTML_Template_IT($this->templateHtmlDir);
	
			$template->loadTemplatefile($this->templateHtmlName, true, true);
			
			$template->setCurrentBlock("bloco_mail");
			
				$template->setVariable("tituloEmail", $this->titulo);
				
				$template->setVariable("destino", $this->destino);
				
				$template->setVariable("origem", $this->origem);
				
				$template->setVariable("conteudo", $this->conteudo);
				
				$template->setVariable("msgFinal", $this->msgFinal);
		
				$template->setVariable("autor", $this->autor);
				
				$template->setVariable("dataHora", getData(4).", ".getHora(":", 1));
				
				$template->parseCurrentBlock("bloco_mail");
	
			$this->conteudo = $template->get();

			$this->header = "From:".$this->origem."\nContent-type: text/html\n";
			
			if (!@mail($this->destino, $this->titulo, $this->conteudo, $this->header)){
				$this->erro($erro['E-MAIL_NOT_SEND']);
			}
		}
		else{
			$this->erro($erro['TEMPLATE_NAO_EN']);
		}
	}//goMail
}//SendMail
?>