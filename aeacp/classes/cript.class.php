<?
####################################################################
#                      CLASSE PADRAO XCLASSE                       #
####################################################################
#																   #
#	Essa classe tem como objetivo suprir todas as necessidades 	   #
#	b�sicas que uma p�gina feita em Php que necessite de           #
#   ferramentas para gerenciamento de 3 bancos de dados s�o eles:  #
#   															   #
#   MySQL														   #
#   PostGre														   #
#   FireBird                                                       #
#																   #
#	Tamb�m apresenta as seguintes serramentas :					   #
#																   #
#		1. Uma classe de utilit�rios diversos*                     #
#		2. Sistema de envio de email							   #
#		3. Utilit�rios como : Data, Hora, Ip etc... *			   #
#		4. Calend�rio com Links     							   #
#		5. Sistema de Envio de Fotos              		           #	
#		6. Gerenciamento de SESSIONS                               #
#       7. Gerenciamento de COOKIES                                #
#		8. Criptografica                						   #
#																   #
#		*Ver fun��es da classe Utilitarios						   #
#																   #
####################################################################


/* 

 Cript -> Nessa classe est� fun��es para fazer a criptografia de palavras

*/

// Chave para a criptografica //
$alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � �   � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � ';

$beta = '� � g � � o � ` N �  � x � �  � # 1 � W � �  R J  � � � | + a � � � { 4 $ � �  w � � � E � � � � � � ) v � V Z  & �  B F r P  y �  : , � � C b � t � c ( � � � 0 � > � m � � � � n  � � � � � � � q � @ � ] G � p � � � " � �  } k  f M � O � 2 � � L � 9 � * l �  �  � _ ^ K ? = z � � � � � � � � j � � � � . �    � - � � �  � �   ! � � Q � X 6 D � 7 �  �  � � �  � H � 5 � A � T s  3 � � d % � � � � � � i � e [ � � <  I � h � � u � � � �  � � / � � ~ Y � � 8 � S  \ ; U   ';

/*class Cript{
	/* Atributos 
	var $palavra;
	var $crip;

	/* Construtor 
	function Cript($palavra = ''){
		$this.$palavra = $palavra;
		$this.$crip = FALSE;
	}	
	/* M�todos 
	function setPalavra($palavra){ $this.$palavra = $palavra; }
	function setCript($boolean)  { $this.$crip = $boolean;    }
	function getPalavra()        { return $this.$palavra;     }
	function getCript()          { return $this.$crip;        }
	
	function criptPalavra(){
		if(!empty($palavra)){
			$palavraCript = '';
			for($i=0; $i<strlen($palavra); $i++){
				$palavraCript += $beta[strstr($alfa, $palavra[$i])];
			}
		}
		$cript = TRUE;
		$palavra = $palavraCript;
	}
	
	function unCriptPalavra(){
	}
	
}//Cript*/

class Cript{
	/* Atributos */
	private $palavra;
	private $crip;
	private $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � �   � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � ';
    private $beta = '� � g � � o � ` N �  � x � �  � # 1 � W � �  R J  � � � | + a � � � { 4 $ � �  w � � � E � � � � � � ) v � V Z  & �  B F r P  y �  : , � � C b � t � c ( � � � 0 � > � m � � � � n  � � � � � � � q � @ � ] G � p � � � " � �  } k  f M � O � 2 � � L � 9 � * l �  �  � _ ^ K ? = z � � � � � � � � j � � � � . �    � - � � �  � �   ! � � Q � X 6 D � 7 �  �  � � �  � H � 5 � A � T s  3 � � d % � � � � � � i � e [ � � <  I � h � � u � � � �  � � / � � ~ Y � � 8 � S  \ ; U   ';

	/* Construtor */
	function Cript($palavra = ''){
		$this->palavra = $palavra;
		$crip = false;
	}	
	/* M�todos */
	function setPalavra($palavra){ $this->palavra = $palavra; $crip=false; }
	function setCript($cript)    { $this->crip = $cript;                   }
	function getPalavra()        { return $this->palavra;                  }
	function getCript()          { return $this->crip;                     }
	
	function criptPalavra(){
		if(!empty($this->palavra)){
			if($this->crip == false){
				$palavraCript = '';
				for($i=0; $i<strlen($this->palavra); $i++){
					$palavraCript .= $this->beta[strpos($this->alfa, $this->palavra[$i])];
				}
			}
		}
		$this->crip    = true;
		$this->palavra = $palavraCript;
	}//criptPalavra
	
	function unCriptPalavra(){
		if(!empty($this->palavra)){
			if($this->crip == true){
				$palavraUnCript = '';
				for($i=0; $i<strlen($this->palavra); $i++){
					$palavraUnCript .= $this->alfa[strpos($this->beta, $this->palavra[$i])];
				}
			}
		}
		$this->crip    = false;
		$this->palavra = $palavraUnCript;
	}//unCriptPalavra
	
}//Cript
$palavra = "Ol� a todos. Bem primeiro gostaria de agradecer a todos que colaboraram para que o site estivesse de volta, e aqui est� ele todo reformulado e o mais interessante feito em PHP.
Bom nessas considera��es iniciais eu gostaria de fazer um breve coment�rio do poder que o PHP possui. Para isso vamos tomar como exemplo o nosso pr�prio site, que foi feito inteiramente em PHP com alguns pequenos aux�lios do nosso glorioso JAVASCRIP que n�o tem nada a ver com JAVA (Costumam confundir)*.
Bom nosso site � formado por sess�es, essas sess�es possuem artigos, l�gico que nada disso seria poss�vel de ser feito dinamicamente sem ajuda de um banco de dados no nosso caso utilizamos o nosso velho de guerra (porem muito funcional no nosso caso) MySQL.
Voltando a estrutura da p�gina, todo o cadastro de artigos, sess�es, noticias, links, entre outros, � feito dinamicamente por nossos administradores. Atrav�s de formul�rios, combos, checkbox entre outros, ou seja, tudo o que diz respeito � intera��o com o usu�rio e a p�gina.
E o que o PHP faz � isso, somente possibilitar que essa intera��o seja feita, facilitando e muito a constru��o de softwares para web. Como � o case de softwares de e-comerce ou e-learning. Esses sistemas necessitam desse tipo de intera��o com o usu�rio e o php possibilita essa intera��o.
Nos artigos seguintes provavelmente ir� se acostumar com alguns termos, n�o se assuste pois eles ir�o fazer parte de nossa jornada na desbrava��o do php.
Fun��es, Strings, Classes, M�todos, Arrays...
N�o se assuste tudo tem seu tempo e o tempo agora � de entender como tudo funciona.
Atualmente o PHP suporta a maioria dos bancos de dados existentes no mercado, tendo uma rela��o especial com o banco de dados MySQL, sendo que este possui as bibliotecas nativas no PHP.
PHP � uma linguagem interpretada, diferentemente de linguagens como C, Pascal e outras, onde o c�digo � compilado e depois executado. Por ser interpretado, PHP ganha em portabilidade. Qualquer aplicativo que voc� tenha feito rodando em Windows, � compat�vel e vai funcionar sem altera��es num sistema Linux ou semelhante. A n�o ser, � claro, que voc� use fun��es espec�ficas para um sistema operacional.
O que � PHP?
PHP � a abrevia��o de \"Hypertext PreProcessor\", ou seja, Pr�-Processador Hipertexto. E isso faz sentido, se levarmos em conta que o PHP normalmente � escrito embutido junto com a linguagem HTML.
PHP faz parte do conceito de software livre. O c�digo-fonte desta linguagem est�
dispon�vel para quem se interessar, al�m de que pode-se utiliz�-la sem custo algum para a empresa, profissional ou pessoa f�sica.
Apesar de ser largamente usado em aplicativos web, o PHP tamb�m pode produzir
aplicativos que possuam interface gr�fica (os softwares que normalmente usamos nos
computadores). Dentre as vantagens do PHP quanto � outras linguagem voltadas para desenvolvimento de aplica��es web, podemos citar:
� Linguagem de f�cil aprendizado;
� Performance e estabilidade excelentes;
� C�digo-aberto (n�o necessitando licen�a de uso e podendo alter�-lo conforme as
necessidades);
� Suporte nos principais servidores de p�ginas existentes;
� Suporte aos principais banco de dados existentes, sendo que o suporte ao MySQL �
nativo;
� Multipataforma e totalmente port�vel;
� Suporte a uma grande variedade de padr�es e protocolos, como XML, DOM, IMAP,
POP3, LDAP, HTTP, FTP, entre outros.
Como o php funciona ?
O PHP funciona, normalmente, em parceria com um servidor de p�ginas. Ele pode atuar
sozinho, no caso de voc� desenvolver algum tipo de programa��o para executar
localmente. O desenvolvimento local n�o � o foco nem a inten��o do PHP, sua utilidade � mesmo vista no desenvolvimento web.
O processo inicia quando o navegador solicita uma p�gina no servidor.
Se for uma p�gina HTML comum, o servidor simplesmente iria enviar a p�gina pro navegador da forma como ele est�, por�m, sendo uma p�gina PHP, o servidor vai primeiro executar a p�gina e depois enviar apenas o resultado para o navegador do cliente.
Dessa forma, o c�digo PHP nunca poder� ser visto diretamente pelo browser. Para ter
acesso ao c�digo escrito em PHP, deve-se ter acesso via FTP ou acesso direto ao disco onde est�o armazenados estes arquivos.
Vale ressaltar que a sa�da do PHP � o c�digo HTML, portanto, faz-se imprescind�vel que se tenha no��es b�sicas de HTML para a cria��o e desenvolvimento de websites din�micos com PHP.
Bom galera acho que por enquanto � s�.
Qualquer d�vida n�o exitem em perguntar...
xgordo@kakitus.com
";

$cript = new Cript($palavra);

$cript->criptPalavra();
$palavraCript = $cript->getPalavra();

$cript->unCriptPalavra();
$palavraUnCript = $cript->getPalavra();

echo "Palavra original : $palavra";
echo "<br>";
echo "<hr>";
echo "Palavra criptografada : $palavraCript";
echo "<br>";
echo "<hr>";
echo "Palavra descriptografada : $palavraUnCript";
?>