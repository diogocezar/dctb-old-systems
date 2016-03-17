<? include('includes.php'); ?>
<? include('detalhesEvento.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>....::: Eventos :::....</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../css/cssInagroPage.css">
<script src="../jscripts/validate/validate.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<head>
<style type="text/css">
body {
	margin:0;
	padding:0;
	text-align:center;
	background-color: #FFFFFF;
}
#geral {
     width: 770px;
     margin: 0 auto;   /* ao magico aqui */ 
     text-align: left;    /* arrumando a zona q o hack anterior  */ 
 }
#conteudo {
    padding: 5px;
    background-color: #0086c6;
   
}
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #006600;
	font-style: italic;
	font-weight: bold;
}
</style>
</head>
<body>
<div id="Layer1" style="position:absolute; left:120px; top:1px; width:760px; height:582px; z-index:14;">
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:33px; top:407px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[5] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:166px; top:407px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[6] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:166px; top:291px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[2] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:299px; top:291px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[3] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:299px; top:407px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[7] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:432px; top:291px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[4] ?></div>
  <div class="imgQuadrado" id="Layer6" style="position:absolute; left:432px; top:407px; width:133px; height:117px; z-index:19; visibility: visible;"><?= $info[8] ?></div>
</div>
<div id="Layer13" style="position:absolute; left:120px; top:562px; width:760px; height:21px; z-index:24; visibility: visible;"><span class="style1">..:: Inagro - Incubadora de Agroneg&oacute;cios de Piraju e Regi&atilde;o ::..<br>
:: <a href="mailto:psvecchia@hotmail.com">Desenvolvido: Paulo Vecchia</a> :: </span></div>
<div id="Layer2" style="position:absolute; left:119px; top:1px; width:760px; height:181px; z-index:16; visibility: visible;">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="760" height="180">
    <param name="movie" value="abertura%20e%20banner.swf">
    <param name="quality" value="high">
    <embed src="abertura%20e%20banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="760" height="180"></embed>
  </object>
</div>
<div id="Layer3" style="position:absolute; left:119px; top:180px; width:760px; height:38px; z-index:26; visibility: visible;"><img src="../images/menu%20superior.jpg" width="760" height="38" border="0" usemap="#mapa_links_superior">
</div>
<div id="Layer5" style="position:absolute; left:119px; top:218px; width:586px; height:74px; z-index:18; visibility: visible;" class="caixaEventoTexto">
<div id="tituloDetalheEvento"><?= $info['titulo']; ?></div>
<div id="dataDetalheEvento"><?=   $info['data']; ?></div>
<div id="textoDetalheEvento" style="width:450; height:35px; overflow-x: hidden; overflow-y: auto;"><div align="justify"><?= $info['descricao']; ?></div></div>
</div>
<div id="Layer6" style="position:absolute; left:153px; top:292px; width:133px; height:117px; z-index:15; visibility: visible;" class="imgQuadrado"><?= $info[1] ?></div>
<div id="Layer7" style="position:absolute; left:705px; top:217px; width:174px; height:135px; z-index:20" class="noticias">
  <div align="left"><? include('./ultimaNoticia.php'); ?></div>
</div>
<div id="Layer9" style="position:absolute; left:708px; top:492px; width:174px; height:28px; z-index:25; visibility: visible;"><img src="../images/logos%20sebrae.jpg" width="171" height="48"></div>
<div id="Layer10" style="position:absolute; left:119px; top:525px; width:760px; height:38px; z-index:23; visibility: visible;"><img src="../images/barra%20fim%20pagina.jpg" width="760" height="38"></div>
</div>
</body>
</html>
