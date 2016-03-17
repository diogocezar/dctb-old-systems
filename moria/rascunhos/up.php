<html>
<head>
<title>Flogs - Mostre sua cara ao Mundo! O Fotolog Brasileiro - Crie ja seu Flog Gratuito!</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/includes/estilos/azul.css" rel="stylesheet" type="text/css"><style type="text/css">
<!--
.style4 {
	color: #FF0000;
	font-weight: bold;
	font-size: 10px;
}
.style5 {font-size: 10px}
-->
</style>
<script>
document.domain = 'flogs.com.br' ;
var escondido = 0;

function preview()
{
	img = document.getElementById('img');
	if(escondido)
	{
		esc.innerHTML = '<a href="javascript:;" class="menu style5" onclick="preview()">(esconder)</a><br><img onload="getSize()" width="500" src="'+escondido+'" name="img" id="img">';
		escondido = 0;
	}
	else
	{
		escondido = img.src;
		img.src = '';
		esc.innerHTML = '<a href="javascript:;" class="menu style5" onclick="preview()">(mostrar)</a><br><img onload="getSize()" src="img/1px.gif" name="img" id="img">';
	}
}

function find_array(arr,str)
{
	for(i=0; arr.length>i; i++)
	{
		if(arr[i] == str) return 1;
	}
	return 0;
}

function verificaFoto()
{
	var obj = document.getElementById('file');
	var v = obj.value;
	var extencao=v.substr(v.length - 4).toLowerCase();
	var extPerm = new Array(".gif",".jpg",".png","jpeg",".GIF",".JPG",".PNG","JPEG");
	var img = document.getElementById('img');
	img.src = "file://"+obj.value;
	img.width = 500;
	if(!find_array(extPerm,extencao))
	{ 
		alert("Só são permitidas fotos nos formatos GIF, PNG e JPG/JPEG");
		obj.value = "";
		esc.innerHTML = '<br><img onload="getSize()" src="img/1px.gif" name="img" id="img">';
		return 0;
	}
	
	escondido = img.src;
	if(escondido) preview();	
}

function getSize()
{
	if(document.getElementById('img').fileSize > 409600)
	{
		alert("A foto não pode ter mais de 400 KB.");
		esc.innerHTML = '<br><img onload="getSize()" src="img/1px.gif" name="img" id="img">';
		obj.value = "";
		return 0;
	}
	return 1;
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="Layer1" style="position:absolute; left:40%; top:-350px; width:300px; height:150px; z-index:1">
  <table width="300" border="0" cellpadding="0" cellspacing="0" class="tabelaborda">
    <tr>
      <td height="20" colspan="3" class="tabelatopo">&nbsp;AGUARDE...</td>
    </tr>
    <tr>
      <td height="10" colspan="3"><img src="img/1px.gif" width="1" height="1"></td>
    </tr>
    <tr>
      <td width="10" rowspan="2">&nbsp;</td>
      <td width="280" align="center" valign="middle" class="verdana12"><div align="justify">Aguarde enquanto a foto está sendo enviada. Isto pode levar alguns segundos. <strong>Não pare este processo.</strong>
      </div>
      <td width="10" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="12" colspan="3" class="noticialink"><img src="img/1px.gif" width="1" height="1"></td>
    </tr>
  </table>
</div><table width="510" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="510" height="556" align="center" valign="top" class="texto"> <font size="3"><b>Enviar Foto</b></font> 
      <p>Selecione a foto que deseja enviar, e certifique-se de que você não estará infringindo nenhuma regra. O tamanho máximo permifito para cada foto é de 400KB e apenas nos formatos GIF, PNG e JPG/JPEG. Fotos pornográficas, ofenças, racismo, ou qualquer conteudo que, viole os termos de serviço, serão excluidas sem aviso prévio, podendo até ter seu Flog cancelado. </p>
      <div id="result" style="width: 70%;" class="style4"></div>
      <table width="510" border="0" cellpadding="0" cellspacing="5">        
        <form name="formEnviaFoto" target="destForm" action="http://up.flogs.com.br/?cLogin=carlinhus&cpUser=67a48f7e076faf5d0ec903552eaf6b20" enctype="multipart/form-data" method="post">
          <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
          <tr> 
            <td colspan="2" valign="top"> <p class="texto">Selecione a foto<br>
              <input type="file" id="file" onChange="verificaFoto()" name="file"  />
              </p></td>
          </tr>
          <tr>
            <td colspan="2" valign="top" class="texto">Pré-visualização: <label id="esc"><br>
            <img src="img/1px.gif" name="img" id="img"></label></td>
    </tr>
          <tr class="texto"> 
            <td colspan="2" valign="top">Descrição da foto<br> 
              <textarea name="descricao" rows="5" class="inputloginsenha" id="descricao" style="width: 90%; height: 90px"></textarea>            </td>
          </tr>
          <tr valign="top"> 
            <td class="texto">Selecione o grupo<br>
            <select class="input" name="codGrupo" disabled><option>Nenhum Grupo</option></select>            </td>
            <td class="texto">Permissão de comentarios da foto<br><select name="perms" class="input" style="width: 150px;">
                <option value="T" >Todos</option>
                <option value="R" >Somente Registrados</option>
                <option value="N" >Ninguém</option>
            </select> </td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="2" class="texto"><input name="Submit" onClick="Layer1.style.top=370;" type="submit" class="entrar" value="Enviar Foto"> </td>
          </tr>
        </form>
      </table>
      <br>
      <iframe width="0" height="0" frameborder="0" name="destForm"></iframe>      <table width="100%"  border="0" cellspacing="2" cellpadding="2">
        <tr align="center">
          <td class="texto"><strong>Voc&ecirc; não é um <a href="/assinar" class="menu">Flogger Colaborador</a>. Portanto você tem direito a enviar apenas 3 fotos a cada 24 horas. Nas ultimas 24 horas já foram enviadas as seguintes fotos:</strong></td>
        </tr>
        <tr>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
           <td class="style5" align="center"><b>Nenhuma foto enviada nas &uacute;ltimas 24 horas.</b></td>          </table></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
