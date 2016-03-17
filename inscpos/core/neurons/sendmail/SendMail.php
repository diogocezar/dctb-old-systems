<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por enviar e-mails
* This neuron is responsible to send e-mails
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/
	 
class SendMail{

	/** 
	* Atributo que irá armazenar o título do email a ser enviado.
	* @access private  
	* @name $titulo
	* @var String
	*/		
	public $titulo;
	
	/** 
	* Atributo que irá armazenar o conteúdo do email a ser enviado.
	* @access private  
	* @name $conteudo
	* @var String
	*/		
	public $conteudo;
	
	/** 
	* Atributo que irá armazenar o destino do email a ser enviado.
	* @access private  
	* @name $destino
	* @var String
	*/		
	public $destino;
	
	/** 
	* Atributo que irá armazenar a origem do email a ser enviado.
	* @access private  
	* @name $origem
	* @var String
	*/		
	public $origem;
	
	/** 
	* Atributo que irá armazenar Empresa/Autor do email a ser enviado.
	* @access private  
	* @name $origem
	* @var String
	*/		
	public $autor;

	/** 
	* Atributo que irá armazenar a a mensagem do rodapé do email.
	* @access private  
	* @name $origem
	* @var String
	*/		
	public $msgFinal;
	
	/** 
	* Atributo que irá armazenar o diretório do arquivo de template.
	* @name $templateHtmlDir
	* @var String
	*/		
	public $templateHtmlDir;
	
	/** 
	* Atributo que irá armazenar o nome do arquivo de template.
	* @name $templateHtmlName
	* @var String
	*/		
	public $templateHtmlName;
	
	/** 
	* Atributo que irá armazenar os parâmetros de conexão.
	* @name $params
	* @var Array
	*/			
	public $params;
	
	/** 
	* Atributo que irá armazenar os dados do e-mail.
	* @name $dados
	* @var Array
	*/	
    public $dados;
	
	/** 
	* Atributo que irá armazenar o e-mail de origem.
	* @name $dados
	* @var Array
	*/		
    public $email = 'assinfdsv-cp@utfpr.edu.br';
	
	function __construct_SendMail(){}
	
	/** 
	* Método que inicializa os atributos passados como parâmetro.
	* @access public 
	* @param String $titulo
	* @param String $conteudo
	* @param String $destino
	* @param String $origem
	* @param String $templateHtml
	* @return void
	*/
	function prepareMail($titulo, $conteudo, $destino, $origem, $autor, $msgFinal, $templateHtmlDir, $templateHtmlName){
		//if(!empty($titulo) && !empty($conteudo) && !empty($destino)){	
			/* Variáveis Obrigatórias */
			$this->titulo           = $titulo;
			$this->conteudo         = $conteudo;
			$this->destino          = $destino;
			$this->origem           = $origem;
		    $this->autor            = $autor;
			$this->msgFinal         = $msgFinal;
			$this->templateHtmlDir  = $templateHtmlDir;
			$this->templateHtmlName = $templateHtmlName;
		//}
	}//prepareMail
	
	/** 
	* Método prepara as informações para o envio do e-mail.
	* @access public 
	* @return void
	*/  
	function goMail(){
	 	global $error; // Reconhecendo variavel global para os erros.
		if(file_exists($this->templateHtmlDir.$this->templateHtmlName)){
		
			$template = new HTML_Template_IT($this->templateHtmlDir);
	
			$template->loadTemplatefile($this->templateHtmlName, true, true);
			
			$template->setCurrentBlock("mail");
			
				$template->setVariable("tituloEmail", $this->titulo);
				
				$template->setVariable("destino", $this->destino);
				
				$template->setVariable("origem", $this->origem);
				
				$template->setVariable("conteudo", $this->conteudo);
				
				$template->setVariable("msgFinal", $this->msgFinal);
		
				$template->setVariable("autor", $this->autor);
			
			$template->parseCurrentBlock("mail") ;
	
			$this->conteudo = $template->get();			
											  
			$this->dados    = array('to'      => $this->destino,
                                    'ccs'     => $this->origem,
                                    'subject' => $this->titulo,
                                    'content' => $this->conteudo,
                                    'html'    => true
								    );
			$this->send();
		}
		else{
			$this->error($error['TEMPLATE_NAO_EN']);
		}
	}//prepareMail
	
	/** 
	* Método prepara envia o e-mail.
	* @access public 
	* @return void
	*/ 	
    function send(){
		
		//print_r($this->dados);	

		$email_to = $this->dados['to'];
		
		$email_subject = $this->dados['subject'];
		
		$email_ccs = $this->dados['ccs'];

		$email_body = $this->dados['content'];
		
		//$email_to = "diogo@diogocezar.com, xgordo@gmail.com";

		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host = "smtp.utfpr.edu.br"; // SMTP server
		$mail->From = "assinfdsv-cp@utfpr.edu.br";
		$mail->FromName = "DIRPPG - Campus Cornélio Procópio";
		if(eregi(', ', $email_to)){
			$email_to_array = explode(', ',$email_to);
			foreach($email_to_array as $email){
				$mail->AddAddress($email);
			}
		}
		else{
			$mail->AddAddress($email_to);
		}
		$mail->Subject = $email_subject;
		$mail->Body = $email_body;
		//$mail->CharSet = "utf-8";
		$mail->ContentType = "text/html";
		
		if(!$mail->Send())
		{
		   echo "Mensagem nao enviada para " . $email_to . "<br />";
		   echo "Mailer Error: " . $mail->ErrorInfo . "<br />";
		}
    }//goMail
}//SendMail
?>