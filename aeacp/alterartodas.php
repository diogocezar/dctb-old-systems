<?
include('./includes/conexao.php');
include('./include/configuracao.php');
include('./classes/session.class.php');
include('./classes/util.class.php');

$Session = new Session;
$Session->IniciaSession();
?>
<html>
<head>
<title>AEACP | Associa&ccedil;&atilde;o dos Engenheiros Agr&ocirc;nomos da Regi&atilde;o de Corn&eacute;lio Proc&oacute;pio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<link href="css/aeacp.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link {
	color: 40683d;
	text-decoration: underline;
}
a:visited {
	text-decoration: underline;
	color: 40683d;
}
a:hover {
	text-decoration: none;
	color: 40683d;
}
a:active {
	text-decoration: underline;
	color: 40683d;
}
.style11 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style13 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.style14 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
.style15 {color: #DC9712}
-->
</style></head>
<body bgcolor="#FFFFFF" background="images/bg.gif" text="40683d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/principal_onrelease.gif','images/institucional_onrelease.gif','images/sejasocio_onrelease.gif','images/noticias_onrelease.gif','images/expediente_onrelease.gif','images/eventos_onrelease.gif','images/faleconosco_onrelease.gif')">
<?php
	if($Session->VeriSession('permitido', 'OK') == OK){
		$permitido = true;
		$login = $Session->RetornaSession('login');
		$id    = $Session->RetornaSession('id');
	}
	
	 if($permitido != true){
		echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='login.php'</script>";
	 }
	 else{
?>
<table width="763" height="768" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
  <!--DWLayoutTable-->
  <tr> 
    <td width="11" rowspan="4" valign="top"><img src="images/lateral_esquerda_01.gif" width="11" height="241"></td>
    <td height="184" colspan="11"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="737" height="184">
        <param name="movie" value="swf/banner.swf">
        <param name="quality" value="high">
        <embed src="swf/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="737" height="184"></embed></object> 
    </td>
    <td width="12" rowspan="5" valign="top" background="images/lateraldireita_midle.gif"> <img src="images/lateraldireita_top.gif" width="12" height="225" alt=""><br>      <br>    </td>
    <td width="1"> <img src="images/spacer.gif" width="1" height="184" alt=""></td>
    <td width="2"></td>
  </tr>
  <tr>
    <td width="40" height="27"> <img src="images/menu_esquerda.gif" width="40" height="27" alt=""></td>
    <td width="86"> <a href="index.php" onMouseOver="MM_swapImage('Image1','','images/principal_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/principal.gif" alt="" name="Image1" width="86" height="27" border="0" id="Image1"></a></td>
    <td colspan="3"> <a href="institucional.htm" onMouseOver="MM_swapImage('Image2','','images/institucional_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/institucional.gif" alt="" name="Image2" width="105" height="27" border="0" id="Image2"></a></td>
    <td width="97"> <a href="sejasocio.htm" onMouseOver="MM_swapImage('Image3','','images/sejasocio_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/sejasocio.gif" alt="" name="Image3" width="97" height="27" border="0" id="Image3"></a></td>
    <td width="83"> <a href="noticias.php" onMouseOver="MM_swapImage('Image4','','images/noticias_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/noticias.gif" alt="" name="Image4" width="83" height="27" border="0" id="Image4"></a></td>
    <td width="99"> <a href="expediente.htm" onMouseOver="MM_swapImage('Image5','','images/expediente_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/expediente.gif" alt="" name="Image5" width="99" height="27" border="0" id="Image5"></a></td>
    <td width="82"> <a href="eventos.htm" onMouseOver="MM_swapImage('Image6','','images/eventos_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/eventos.gif" alt="" name="Image6" width="82" height="27" border="0" id="Image6"></a></td>
    <td width="109"> <a href="faleconosco.htm" onMouseOver="MM_swapImage('Image7','','images/faleconosco_onrelease.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="images/faleconosco.gif" alt="" name="Image7" width="109" height="27" border="0" id="Image7"></a></td>
    <td width="36"> <img src="images/menu_direita.gif" width="36" height="27" alt=""></td>
    <td> <img src="images/spacer.gif" width="1" height="27" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="24" colspan="3" valign="top"><img src="images/top_login.gif" width="203" height="24"></td>
    <td colspan="8" valign="top"><img src="images/top_areaadmin.gif" width="534" height="24"></td>
    <td> <img src="images/spacer.gif" width="1" height="24" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3" rowspan="10" valign="top" bgcolor="#FFFFFF"><br>
      <table width="95%" border="0" align="center">
        <tr>
          <td><span class="style14"><img src="images/bolinha.gif" width="6" height="6"> Voc&ecirc; est&aacute; logado como</span><span class="style11">
            <?= $login ?>
          </span></td>
        </tr>
      </table></td>
    <td width="13" rowspan="10" valign="top" bgcolor="eff6ee"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td colspan="6" rowspan="10" valign="top" bgcolor="eff6ee"><div align="center">
      <p class="style13"><br>
        <span class="style11"><img src="images/bolinha.gif" width="6" height="6"> </span>        Administrar Not&iacute;cias </p>
		<?php
							$Util = new Util;
							
							define(MAX_TITULO, 150);
							define(MAX_FONTE, 150);
							define(MAX_DESCRICAO, 350);
												
							define(ASSUNTO, 'not�cias'); ## ALTERAR (DIN�MICO) ##
							define(TABELA, $tabela['noticias']); ## ALTERAR (DIN�MICO) ##
							define(ORDEM, 'DESC'); ## ALTERAR (DIN�MICO) ##
							
							define(SQL_COUNT, "SELECT count(*) as total FROM ".TABELA);
							
							$qrCount = $MySQL->Query(SQL_COUNT);
							$dtCount = mysql_fetch_array($qrCount);
							
							define(QTD, $dtCount['total']);
													
							if(!isset($_GET['start']))$_GET['start']=0;
							$start = $_GET['start'];
						
							define(ATUAL, $start);
							define(POR_PAGINA, PP_ADM_NOTI);
							define(TOTAL, ceil((QTD)/POR_PAGINA));
							define(ORDENADO, 'not_id'); ## ALTERAR (DIN�MICO) ##
							define(SQL, "SELECT * FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
							
							$query = $MySQL->Query(SQL);
							while($data = mysql_fetch_array($query)){## ALTERAR (DIN�MICO) ##
								
								$id         = $data[$camposTab1[0]]; 
								$titulo     = $data[$camposTab1[1]];
								$fonte      = $data[$camposTab1[2]];
								$descricao  = $data[$camposTab1[3]];
								$autor      = $data[$camposTab1[4]];
								$quando     = $data[$camposTab1[5]];
								
								if(strlen($titulo) > MAX_TITULO){
									$titulo = substr($titulo, 0, MAX_TITULO).'...'; 	
								}
								if(!empty($fonte)){
									if(strlen($fonte) > MAX_FONTE){
										$fonte = substr($fonte, 0, MAX_FONTE).'...'; 	
									}
								}
								if(strlen($descricao) > MAX_DESCRICAO){
									$descricao = substr($descricao, 0, MAX_DESCRICAO).'...'; 	
								}

								echo "
								<table width=\"450\" border=\"0\" bordercolor=\"#4C7149\">
									<tr bgcolor=\"#FFFFFF\">
									  <td colspan=\"3\" bordercolor=\"#40683D\"><font color=\"40683d\" size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong><img src=\"images/bolinha.gif\" width=\"6\" height=\"6\"> $titulo</strong></font></td>
									  </tr>
									<tr>
									  <td width=\"312\" bordercolor=\"#40683D\">&nbsp;</td>
									  <td width=\"63\" class=\"style11\"><font color=\"40683d\" size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong><img src=\"images/bolinha.gif\" width=\"6\" height=\"6\"> </strong></font><a href=\"excluir.php?tipo=noticia&id=$id\">Excluir</a></td>
									  <td width=\"61\" class=\"style11\"><font color=\"40683d\" size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong><img src=\"images/bolinha.gif\" width=\"6\" height=\"6\"> </strong></font><a href=\"frm_alterar.php?id=$id\">Alterar</a></td>
									</tr>
								  </table>";
							}
							echo "<span class=\"style11\">";
							/* Controle da Pagina��o */
								if(TOTAL > 1){
								
									$pag = $_GET['pag'];
									if(empty($pag)){
										$pag = 1;
									}
																	
									$mostra_prox = POR_PAGINA*(($pag+1)-1);
									$mostra_ante = POR_PAGINA*(($pag-1)-1);
									$mostra_essa = POR_PAGINA*(($pag)-1);
									
									$pag_prox = $pag+1;
									
									$pag_ante = $pag-1;
									
									$pag_atua = $pag;
									
									echo "<a href=\"".$Util->PaginaAtual()."\"><img src=\"icones/nav_primeiro.jpg\" border=\"0\"><a>&nbsp;&nbsp;";

									if($pag > 1){
										echo "<a href=\"".$Util->PaginaAtual()."?start=$mostra_ante&pag=$pag_ante\">";
									}
									
									echo "<img src=\"icones/nav_anterior.jpg\" border=\"0\"></a>&nbsp;.<b>.</b>&nbsp;";
									
									for($i=1; $i<=TOTAL ; $i++){
										if(POR_PAGINA*($i-1) == ATUAL){	
											echo "<b> $i</b>";
										}
										else{
											$aevi = POR_PAGINA*($i-1);
											echo " <a href=\"".$Util->PaginaAtual()."?start=$aevi&pag=$i\">$i</a> ";
										}
										/* Guardando o Link para a Ultima P�gina */
										if($i == TOTAL){
											$link = $Util->PaginaAtual()."?start=$aevi&pag=$i";
										}
									}
									
									echo "&nbsp;<b>.</b>.&nbsp;";
									
									if($pag < TOTAL){						
										echo "<a href=\"".$Util->PaginaAtual()."?start=$mostra_prox&pag=$pag_prox\">";
									}
									
									echo "<img src=\"icones/nav_proximo.jpg\" border=\"0\"></a>&nbsp;";
									echo "<a href=\"$link\"><img src=\"icones/nav_ultimo.jpg\" border=\"0\"></a><br><br>";									
								}
								$agora = ($start/POR_PAGINA)+1;
								$todas = TOTAL;

								echo "Exibindo p�gina : <b>$agora</b> de <b>$todas</b> p�ginas<br>";
								echo "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
								echo "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por p�gina.<br><br>";
								echo "</span>";
					      ?>
      <p align="left" class="style13">
        <input name="Voltar" type="button" class="caixa" id="Enviar2" value="&laquo;&laquo; Voltar" onClick="location.href='admin.php'">
        <br>
        <br>
        <br>
      </p>
      </div></td>
    <td rowspan="10" valign="top" bgcolor="eff6ee"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td rowspan="3"> <img src="images/spacer.gif" width="1" height="111" alt=""></td>
    <td height="6"></td>
  </tr>
  <tr>
    <td rowspan="12" valign="bottom" background="images/lateral_esquerda_02.gif"><img src="images/lateral_esquerda_03.gif" width="11" height="273"></td>
    <td height="7"></td>
  </tr>
  <tr>
    <td rowspan="12" valign="bottom" background="images/lateraldireita_midle.gif"><img src="images/lateraldireita_down.gif" width="12" height="136" align="absmiddle"></td>
    <td height="98"></td>
  </tr>
  <tr>
    <td height="29"> <img src="images/spacer.gif" width="1" height="29" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="2"> <img src="images/spacer.gif" width="1" height="2" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="24"> <img src="images/spacer.gif" width="1" height="24" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="44"> <img src="images/spacer.gif" width="1" height="44" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="26"> <img src="images/spacer.gif" width="1" height="26" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="68"> <img src="images/spacer.gif" width="1" height="68" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="142"> <img src="images/spacer.gif" width="1" height="30" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="9" colspan="11"> <img src="images/index_32.gif" width="737" height="9" alt=""></td>
    <td> <img src="images/spacer.gif" width="1" height="9" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="30" colspan="11" background="images/menuinferior.gif"><div align="center"><font color="40683d" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><a href="index.php">Principal</a> 
        | <a href="institucional.htm">Institucional</a> | <a href="sejasocio.htm">Seja 
        S&oacute;cio</a> | <a href="noticias.php">Not&iacute;cias</a> | <a href="expediente.htm">Expediente</a> 
        | <a href="eventos.htm">Eventos</a> | <a href="faleconosco.htm">Fale conosco</a></strong></font> 
      </div></td>
    <td> <img src="images/spacer.gif" width="1" height="30" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="11" rowspan="2"> <img src="images/copyright.gif" width="737" height="47" alt=""></td>
    <td height="46"> <img src="images/spacer.gif" width="1" height="46" alt=""></td>
    <td></td>
  </tr>
  <tr> 
    <td height="1"> <img src="images/index_35.jpg" width="11" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="1" height="1" alt=""></td>
    <td></td>
  </tr>
  <tr>
    <td height="0"></td>
    <td></td>
    <td></td>
    <td width="77"></td>
    <td></td>
    <td width="15"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr> 
    <td height="1"> <img src="images/spacer.gif" width="11" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="40" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="86" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="77" height="1" alt=""></td>
    <td></td>
    <td></td>
    <td> <img src="images/spacer.gif" width="97" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="83" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="99" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="82" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="109" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="36" height="1" alt=""></td>
    <td> <img src="images/spacer.gif" width="12" height="1" alt=""></td>
    <td></td>
    <td></td>
  </tr>
</table>
</body>
<? } ?>
</html>