<?php
/**
* Arquivo de configura��o da p�gina.
*
* Definindo constantes de configura��o
*/

/**
* I N C L U I N D O  C O N F I G U R A � � O   D O   K O M P R E 
*/

include('../kompre/php/configSite.php');

/**
* D I R E T � R I O S    P A R A   A L O C A �  � O   D E   A R Q U I V O S
*/

$diretorio['lojas'] = "../images/fotos";

/**
* N � M E R O   D E   � T E N S   P O R   P A G I N A � � O 
*/

define(PP_LOJAS, 10);

/**
* E - M A I L   D E S T I N O   C O N T A T O
*/

define(EMAIL, 'falecom@promotos.com.br');

/**
* D E F I N I � � O   D A S   C O N S  T A N T E S 
*/

define(HISTORICO, "Tudo se inicia na caixa de login. Inicia-se digitando-se um ap�strofo e clicando-se no bot�o para seguir adiante. As rea��es podem ser as mais diversas : Uma mensagem de erro gerada pelo pr�prio site: Essa � a melhor rea��o poss�vel, quando bem utilizada, quando n�o fica in�til. O fato da pr�pria aplica��o no site gerar a mensagem de erro significa que, se � que houve um erro ocorreu um tratamento e o pretenso hacker ficar� sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inv�lido\", \"senha inv�lida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro � in�til, pois a mensagem de erro personalizada de acordo com o erro est� informando ao hacker que a tentativa dele gerou algum resultado. O ideal � dar uma mensagem padr�o do tipo \"Login inv�lido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princ�pio, n�o saber� se as tentativas dele geraram algum resultado ou n�o, dificultando (n�o impedindo) a a��o do pretenso hacker. Vale mencionar que o tratamento padr�o dos ap�strofos faz com que o ap�strofo digitado na caixa de login seja visto como um usu�rio. Assim sendo se o site est� usando mensagens diferenciadas e, como resposta ao ap�strofo, o pretenso hacker recebe alguma mensagem diferente de \"usu�rio inv�lido\", ele est� na verdade recebendo um convite do tipo \"continue, voc� est� no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inv�lidos no login: Pode ser vista como a solu��o do problema. Se disparada a partir do servidor significa que o algor�timo de login testou o login e identificou que haviam caracteres inv�lidos, n�o indo ao banco. Isso far� com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site � mal programado, j� que esta n�o � a forma correta de se tratar os ap�strofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, n�o do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e m�os nas costas. Mensagem do Cliente: Caracteres inv�lidos no login: Nesta hora o hacker d� um risinho e arrega�a as mangas: isso � um desafio, ele foi desafiado por um mal programador! Que aud�cia! Em menos de 5 minutos o hacker edita o c�digo fonte, elimina a valida��o e invade o site. Manter valida��o apenas no cliente � o mesmo que n�o manter valida��o nenhuma.");

define(DICAS, "Tudo se inicia na caixa de login. Inicia-se digitando-se um ap�strofo e clicando-se no bot�o para seguir adiante. As rea��es podem ser as mais diversas : Uma mensagem de erro gerada pelo pr�prio site: Essa � a melhor rea��o poss�vel, quando bem utilizada, quando n�o fica in�til. O fato da pr�pria aplica��o no site gerar a mensagem de erro significa que, se � que houve um erro ocorreu um tratamento e o pretenso hacker ficar� sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inv�lido\", \"senha inv�lida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro � in�til, pois a mensagem de erro personalizada de acordo com o erro est� informando ao hacker que a tentativa dele gerou algum resultado. O ideal � dar uma mensagem padr�o do tipo \"Login inv�lido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princ�pio, n�o saber� se as tentativas dele geraram algum resultado ou n�o, dificultando (n�o impedindo) a a��o do pretenso hacker. Vale mencionar que o tratamento padr�o dos ap�strofos faz com que o ap�strofo digitado na caixa de login seja visto como um usu�rio. Assim sendo se o site est� usando mensagens diferenciadas e, como resposta ao ap�strofo, o pretenso hacker recebe alguma mensagem diferente de \"usu�rio inv�lido\", ele est� na verdade recebendo um convite do tipo \"continue, voc� est� no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inv�lidos no login: Pode ser vista como a solu��o do problema. Se disparada a partir do servidor significa que o algor�timo de login testou o login e identificou que haviam caracteres inv�lidos, n�o indo ao banco. Isso far� com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site � mal programado, j� que esta n�o � a forma correta de se tratar os ap�strofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, n�o do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e m�os nas costas. Mensagem do Cliente: Caracteres inv�lidos no login: Nesta hora o hacker d� um risinho e arrega�a as mangas: isso � um desafio, ele foi desafiado por um mal programador! Que aud�cia! Em menos de 5 minutos o hacker edita o c�digo fonte, elimina a valida��o e invade o site. Manter valida��o apenas no cliente � o mesmo que n�o manter valida��o nenhuma.");

define(SERVICOS, "Tudo se inicia na caixa de login. Inicia-se digitando-se um ap�strofo e clicando-se no bot�o para seguir adiante. As rea��es podem ser as mais diversas : Uma mensagem de erro gerada pelo pr�prio site: Essa � a melhor rea��o poss�vel, quando bem utilizada, quando n�o fica in�til. O fato da pr�pria aplica��o no site gerar a mensagem de erro significa que, se � que houve um erro ocorreu um tratamento e o pretenso hacker ficar� sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inv�lido\", \"senha inv�lida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro � in�til, pois a mensagem de erro personalizada de acordo com o erro est� informando ao hacker que a tentativa dele gerou algum resultado. O ideal � dar uma mensagem padr�o do tipo \"Login inv�lido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princ�pio, n�o saber� se as tentativas dele geraram algum resultado ou n�o, dificultando (n�o impedindo) a a��o do pretenso hacker. Vale mencionar que o tratamento padr�o dos ap�strofos faz com que o ap�strofo digitado na caixa de login seja visto como um usu�rio. Assim sendo se o site est� usando mensagens diferenciadas e, como resposta ao ap�strofo, o pretenso hacker recebe alguma mensagem diferente de \"usu�rio inv�lido\", ele est� na verdade recebendo um convite do tipo \"continue, voc� est� no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inv�lidos no login: Pode ser vista como a solu��o do problema. Se disparada a partir do servidor significa que o algor�timo de login testou o login e identificou que haviam caracteres inv�lidos, n�o indo ao banco. Isso far� com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site � mal programado, j� que esta n�o � a forma correta de se tratar os ap�strofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, n�o do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e m�os nas costas. Mensagem do Cliente: Caracteres inv�lidos no login: Nesta hora o hacker d� um risinho e arrega�a as mangas: isso � um desafio, ele foi desafiado por um mal programador! Que aud�cia! Em menos de 5 minutos o hacker edita o c�digo fonte, elimina a valida��o e invade o site. Manter valida��o apenas no cliente � o mesmo que n�o manter valida��o nenhuma.");

/**
* M E N U
*/

$menu  = array("onClickM1"  => "index.php",
               "onClickM2"  => "promotos.php",
		       "onClickM3"  => "servicos.php",
		       "onClickM4"  => "dicas.php",
			   "onClickM5"  => "http://kompre.promotos.com.br/",
			   "onClickM6"  => "contato.php"
			   );
			   
/**
* M E N U  A D M I N I S T R A � � O 
*/

$menuAdm = array(
                   "Lojas" => array(
					   "Inserir loja"     => "admLoja.php?acao=adicionar",
					   "Gerenciar lojas"  => "admLojas.php",
				   ),
				   "Dicas" => array(
					   "Inserir dica"    => "admDica.php?acao=adicionar",
					   "Gerenciar dicas" => "admDicas.php",
				   ),
				   "Servi�os" => array(
					   "Inserir servi�o"    => "admServico.php?acao=adicionar",
					   "Gerenciar servi�os" => "admServicos.php",
				   ),
				   "Loja Virtual" => array(
					   "Kompre !" => "http://kompre.promotos.com.br/php/login.php!",
				   ),
				   "Relat�rios" => array(
					   "Estatisticas do site" => "http://67.19.228.7/awstats.pl?config=promotos.com.br&lang=br!",
				   ),				   
				   "Logout" => array(
					   "Sair do sistema" => "admLogOut.php"
				   )
		     );

			   
/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/
			   
/******************************************************************/


$tabela['dicas'] = "pro_dicas";

$campos['dicas'] = array("dic_id",
						 "dic_titulo",
                         "dic_descricao"
					     );
// PK -> dic_cod

/******************************************************************/

$tabela['lojas'] = "pro_lojas";

$campos['lojas'] = array("loj_id",
					     "loj_titulo",
						 "loj_endereco",
						 "loj_telefone",
						 "loj_email",
						 "loj_contatos",
						 "loj_descricao",
						 "loj_foto_url"
					     );
// PK -> loj_cod

/******************************************************************/

$tabela['servicos'] = "pro_servicos";

$campos['servicos'] = array("ser_id",
							"ser_titulo",
						    "ser_descricao"
					        );
// PK -> ser_cod
?>
