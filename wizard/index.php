<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>English Definitions Form</title>
<link href="./css/ec.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="./jscripts/jquery/jquery.js"></script>
<script language="JavaScript" src="./jscripts/validate/validate.js"></script>
</head>
<body>
<div id="padraoFormAdmin">
<div id="title">English definitions </div>
<div id="linhaQuebra">Input the words between ';' like the examples. (wait, this may take).</div>
<div id="separadorEnviar"></div>
  <form name= "form_ed" action="gerar.php" method="post" class="checkForm">
    <div id="linha">
      <div id="formTituloOBG">Book</div>
      <select id="frm_opt_book" name="book" class="formDrop">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select>
    </div>
    <div id="linha">
      <div id="formTituloOBG">Lesson</div>
      <select id="frm_opt_lesson" name="lesson" class="formDrop">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
      </select>
    </div>
    <div id="linhaQuebraTxtArea">
      <div id="formTituloOBG">Verbs</div>
      <textarea name="verbs" rows="5" class="formTxtArea" id="frm_obg_verbs"></textarea>
    </div>
    <div id="linhaQuebraTxtArea">
      <div id="formTituloOBG">Vocabulary</div>
      <textarea name="vocabulary" rows="5" class="formTxtArea" id="frm_obg_vocabulary"></textarea>
    </div>
    <div id="linhaQuebraTxtArea">
      <div id="formTituloOBG">Expressions</div>
      <textarea name="expressions" rows="5" class="formTxtArea" id="frm_obg_expressions"></textarea>
    </div>
    <div id="separadorEnviar"></div>
    <div id="formCampo" align="center">
      <input id="enviar" name="enviar" type="button" value="Send" class="botao"/>
    </div>
  </form>
</div>
</body>
</html>
