<?
####################################################################
#                      CLASSE PADRAO XCLASSE                       #
####################################################################
#																   #
#	Essa classe tem como objetivo suprir todas as necessidades 	   #
#	bбsicas que uma pбgina feita em Php que necessite de           #
#   ferramentas para gerenciamento de 3 bancos de dados sгo eles:  #
#   															   #
#   MySQL														   #
#   PostGre														   #
#   FireBird                                                       #
#																   #
#	Tambйm apresenta as seguintes serramentas :					   #
#																   #
#		1. Uma classe de utilitбrios diversos*                     #
#		2. Sistema de envio de email							   #
#		3. Utilitбrios como : Data, Hora, Ip etc... *			   #
#		4. Calendбrio com Links     							   #
#		5. Sistema de Envio de Fotos              		           #	
#		6. Gerenciamento de SESSIONS                               #
#       7. Gerenciamento de COOKIES                                #
#		8. Criptografica                						   #
#																   #
#		*Ver funзхes da classe Utilitarios						   #
#																   #
####################################################################


/* 

 Cript -> Nessa classe estб funзхes para fazer a criptografia de palavras

*/

// Chave para a criptografica //
$alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  Ђ Ѓ ‚ ѓ „ … † ‡ € ‰ Љ ‹ Њ Ќ Ћ Џ ђ ‘ ’ “ ” • – —  ™ љ › њ ќ ћ џ   Ў ў Ј ¤ Ґ ¦ § Ё © Є « ¬ ­ ® Ї ° ± І і ґ µ ¶ · ё № є » ј Ѕ ѕ ї А Б В Г Д Е Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь Э Ю Я а б в г д е ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ы ь э ю я ';

$beta = 'љ З g ю к o « ` N І  Й x ” н  » # 1 – W Ж Ї  R J  ъ о Ќ | + a Щ П я { 4 $ ф †  w ж И т E б ї ы р Х в ) v Ц V Z  & ®  B F r P  y §  : , Џ ¤ C b і t ± c ( ј О ў 0 п > ‘ m ш Ћ С › n  ­ Д Э Њ  Я Б q ¦ @ з ] G ц p а ґ В " Є Ю  } k  f M ё O ‡ 2 Ф Ґ L “ 9 є * l №  и  ‹ _ ^ K ? = z с э д „ Ѓ У ‚ й j г ѕ ° Ў . ¬    ™ - • ¶ Ы  ѓ Ё   ! М њ Q Е X 6 D Г 7 µ  А  К Ђ Ѕ  © H ’ 5 Ч A ђ T s  3 х у d % Ь е щ л € Ј i · e [ Л ‰ <  I Р h … Н u Ъ — ь џ  ч Љ / Т Ш ~ Y ћ ќ 8 м S  \ ; U   ';

/*class Cript{
	/* Atributos 
	var $palavra;
	var $crip;

	/* Construtor 
	function Cript($palavra = ''){
		$this.$palavra = $palavra;
		$this.$crip = FALSE;
	}	
	/* Mйtodos 
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
	private $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  Ђ Ѓ ‚ ѓ „ … † ‡ € ‰ Љ ‹ Њ Ќ Ћ Џ ђ ‘ ’ “ ” • – —  ™ љ › њ ќ ћ џ   Ў ў Ј ¤ Ґ ¦ § Ё © Є « ¬ ­ ® Ї ° ± І і ґ µ ¶ · ё № є » ј Ѕ ѕ ї А Б В Г Д Е Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь Э Ю Я а б в г д е ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ы ь э ю я ';
    private $beta = 'љ З g ю к o « ` N І  Й x ” н  » # 1 – W Ж Ї  R J  ъ о Ќ | + a Щ П я { 4 $ ф †  w ж И т E б ї ы р Х в ) v Ц V Z  & ®  B F r P  y §  : , Џ ¤ C b і t ± c ( ј О ў 0 п > ‘ m ш Ћ С › n  ­ Д Э Њ  Я Б q ¦ @ з ] G ц p а ґ В " Є Ю  } k  f M ё O ‡ 2 Ф Ґ L “ 9 є * l №  и  ‹ _ ^ K ? = z с э д „ Ѓ У ‚ й j г ѕ ° Ў . ¬    ™ - • ¶ Ы  ѓ Ё   ! М њ Q Е X 6 D Г 7 µ  А  К Ђ Ѕ  © H ’ 5 Ч A ђ T s  3 х у d % Ь е щ л € Ј i · e [ Л ‰ <  I Р h … Н u Ъ — ь џ  ч Љ / Т Ш ~ Y ћ ќ 8 м S  \ ; U   ';

	/* Construtor */
	function Cript($palavra = ''){
		$this->palavra = $palavra;
		$crip = false;
	}	
	/* Mйtodos */
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
$palavra = "Olб a todos. Bem primeiro gostaria de agradecer a todos que colaboraram para que o site estivesse de volta, e aqui estб ele todo reformulado e o mais interessante feito em PHP.
Bom nessas consideraзхes iniciais eu gostaria de fazer um breve comentбrio do poder que o PHP possui. Para isso vamos tomar como exemplo o nosso prуprio site, que foi feito inteiramente em PHP com alguns pequenos auxнlios do nosso glorioso JAVASCRIP que nгo tem nada a ver com JAVA (Costumam confundir)*.
Bom nosso site й formado por sessхes, essas sessхes possuem artigos, lуgico que nada disso seria possнvel de ser feito dinamicamente sem ajuda de um banco de dados no nosso caso utilizamos o nosso velho de guerra (porem muito funcional no nosso caso) MySQL.
Voltando a estrutura da pбgina, todo o cadastro de artigos, sessхes, noticias, links, entre outros, й feito dinamicamente por nossos administradores. Atravйs de formulбrios, combos, checkbox entre outros, ou seja, tudo o que diz respeito а interaзгo com o usuбrio e a pбgina.
E o que o PHP faz й isso, somente possibilitar que essa interaзгo seja feita, facilitando e muito a construзгo de softwares para web. Como й o case de softwares de e-comerce ou e-learning. Esses sistemas necessitam desse tipo de interaзгo com o usuбrio e o php possibilita essa interaзгo.
Nos artigos seguintes provavelmente irб se acostumar com alguns termos, nгo se assuste pois eles irгo fazer parte de nossa jornada na desbravaзгo do php.
Funзхes, Strings, Classes, Mйtodos, Arrays...
Nгo se assuste tudo tem seu tempo e o tempo agora й de entender como tudo funciona.
Atualmente o PHP suporta a maioria dos bancos de dados existentes no mercado, tendo uma relaзгo especial com o banco de dados MySQL, sendo que este possui as bibliotecas nativas no PHP.
PHP й uma linguagem interpretada, diferentemente de linguagens como C, Pascal e outras, onde o cуdigo й compilado e depois executado. Por ser interpretado, PHP ganha em portabilidade. Qualquer aplicativo que vocк tenha feito rodando em Windows, й compatнvel e vai funcionar sem alteraзхes num sistema Linux ou semelhante. A nгo ser, й claro, que vocк use funзхes especнficas para um sistema operacional.
O que й PHP?
PHP й a abreviaзгo de \"Hypertext PreProcessor\", ou seja, Prй-Processador Hipertexto. E isso faz sentido, se levarmos em conta que o PHP normalmente й escrito embutido junto com a linguagem HTML.
PHP faz parte do conceito de software livre. O cуdigo-fonte desta linguagem estб
disponнvel para quem se interessar, alйm de que pode-se utilizб-la sem custo algum para a empresa, profissional ou pessoa fнsica.
Apesar de ser largamente usado em aplicativos web, o PHP tambйm pode produzir
aplicativos que possuam interface grбfica (os softwares que normalmente usamos nos
computadores). Dentre as vantagens do PHP quanto а outras linguagem voltadas para desenvolvimento de aplicaзхes web, podemos citar:
• Linguagem de fбcil aprendizado;
• Performance e estabilidade excelentes;
• Cуdigo-aberto (nгo necessitando licenзa de uso e podendo alterб-lo conforme as
necessidades);
• Suporte nos principais servidores de pбginas existentes;
• Suporte aos principais banco de dados existentes, sendo que o suporte ao MySQL й
nativo;
• Multipataforma e totalmente portбvel;
• Suporte a uma grande variedade de padrхes e protocolos, como XML, DOM, IMAP,
POP3, LDAP, HTTP, FTP, entre outros.
Como o php funciona ?
O PHP funciona, normalmente, em parceria com um servidor de pбginas. Ele pode atuar
sozinho, no caso de vocк desenvolver algum tipo de programaзгo para executar
localmente. O desenvolvimento local nгo й o foco nem a intenзгo do PHP, sua utilidade й mesmo vista no desenvolvimento web.
O processo inicia quando o navegador solicita uma pбgina no servidor.
Se for uma pбgina HTML comum, o servidor simplesmente iria enviar a pбgina pro navegador da forma como ele estб, porйm, sendo uma pбgina PHP, o servidor vai primeiro executar a pбgina e depois enviar apenas o resultado para o navegador do cliente.
Dessa forma, o cуdigo PHP nunca poderб ser visto diretamente pelo browser. Para ter
acesso ao cуdigo escrito em PHP, deve-se ter acesso via FTP ou acesso direto ao disco onde estгo armazenados estes arquivos.
Vale ressaltar que a saнda do PHP й o cуdigo HTML, portanto, faz-se imprescindнvel que se tenha noзхes bбsicas de HTML para a criaзгo e desenvolvimento de websites dinвmicos com PHP.
Bom galera acho que por enquanto й sу.
Qualquer dъvida nгo exitem em perguntar...
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