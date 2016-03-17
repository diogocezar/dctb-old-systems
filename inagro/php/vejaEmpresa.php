<? include('includes.php'); ?>
<? include('detalhesEmpresa.php'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>....::: Empresas :::....</title>
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
<div id="Layer1" style="position:absolute; left:120px; top:1px; width:760px; height:630px; z-index:14; visibility: visible;">
  <div id="layer" style="position:absolute; left:140px; top:219px; width:350px; height:340px; z-index:0; overflow-x: hidden; overflow-y: auto;" >
  <div id="tituloDetalheEmpresa"><?= $info['nome']; ?></div>
  <div id="separadorDetalhe"></div>
  <div id="textoDetalheEmpresa"><div align="justify"><?= $info['descricao']; ?></div></div>
  </div>
  <div id="Layer5" style="position:absolute; left:626px; top:217px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[2] ?></div>
  <div id="Layer5" style="position:absolute; left:493px; top:217px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[1] ?></div>
  <div id="Layer5" style="position:absolute; left:493px; top:334px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[3] ?></div>
  <div id="Layer5" style="position:absolute; left:626px; top:334px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[4] ?></div>
  <div id="Layer5" style="position:absolute; left:493px; top:446px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[5] ?></div>
  <div id="Layer5" style="position:absolute; left:626px; top:446px; width:133px; height:117px; z-index:18; visibility: visible;"  class="imgQuadrado"><?= $info[6] ?></div>
</div>
<div id="Layer13" style="position:absolute; left:120px; top:602px; width:760px; height:21px; z-index:24; visibility: visible;"><span class="style1">..:: Inagro - Incubadora de Agroneg&oacute;cios de Piraju e Regi&atilde;o ::..<br>
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
<div id="Layer5" style="position:absolute; left:119px; top:217px; width:133px; height:117px; z-index:18; visibility: visible;" class="imgQuadrado"><?= $info['logo']; ?></div>
<div id="Layer10" style="position:absolute; left:119px; top:563px; width:760px; height:38px; z-index:23; visibility: visible;"><img src="../images/barra%20fim%20pagina.jpg" width="760" height="38"></div>
<div id="Layer4" style="position:absolute; left:119px; top:515px; width:133px; height:47px; z-index:25"><img src="../images/logos%20sebrae.jpg" width="136" height="48"></div>
</div>
</body>
</html>
