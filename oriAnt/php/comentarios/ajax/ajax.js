// Variaveis globais
var obj;
var id;
var funcao;
var dados;
fila  = [];
ifila = 0;

<!--------------------------------------------------------------------------------------->
// Funcoes do xmlhttprequest
<!--------------------------------------------------------------------------------------->

function CreateObjXMLHttpRequest() { // Cria o objeto

    obj = null;

    // Procura por um objeto nativo W3C (Mozilla/Safari/Konqueror/Opera)
    if (window.XMLHttpRequest){

        obj = new XMLHttpRequest(); // Cria o objeto nativo
        obj_type = "XMLHttpRequest";

    } else if (window.ActiveXObject) { // Senao procura por uma versao ActiveX (IE)

        // Array com tipos de objeto ActiveX
        var msxmls = new Array('Msxml2.XMLHTTP.5.0',
                               'Msxml2.XMLHTTP.4.0',
                               'Msxml2.XMLHTTP.3.0',
                               'Msxml2.XMLHTTP',
                               'Microsoft.XMLHTTP');

        // Percorre array com versoes do ActiveX e tenta criar o objeto
        for (var i = 0; i < msxmls.length; i++) {
            try {
                obj = new ActiveXObject(msxmls[i]); // Tenta criar o objeto nativo
                obj_type = msxmls[i];
                break;
            } catch(e) {
                obj = false;
            }
        }
    } else { // Nenhum objeto suportado pelo browser
        obj = false;
    }
    return obj;
}

function GetContent()
{
    if(obj) // Verifica se objeto ainda existe
    {
        if(obj.readyState == 4) // Se requisicao terminada (readyState = 4)
        {
            if(obj.status == 200) // Se status retornado "ok" (status = 200)
            {
                eval(funcao+'();'); // Chama funcao respectiva
            }
            else  // Se status diferente de "ok"
            {
                alert('Erro! "'+ obj.statusText +'" (erro '+ obj.status +')'); //Exibe mensagem com o erro
            }
            // Proxima requisicao da fila
            ifila++;
            if (ifila < fila.length) {
                setTimeout("SendRequest()",20);
            }
        }
    }
    else
    {
        return false;
    }
}

function Requisition(var_id,arquivo,var_funcao,dados)
{
    obj = CreateObjXMLHttpRequest(); // Cria uma instancia do objeto

    id = var_id;
    funcao = var_funcao;

    // Encadeia variaveis enviadas pela requisicao
    if (dados) {
        var mensagem = '';
        for (var i = 0; i < dados.length; i++) {
            if(i > 0) {
                mensagem += '&';
            }
            mensagem += 'dado'+i+'='+url_encode(dados[i]);
        }
    } else {
        mensagem = null;
    }

    // Adiciona a fila
    fila[fila.length] = [id, arquivo, funcao, mensagem];

    // Se fila sem conexoes pendentes, executa
    if ((ifila + 1) == fila.length) {
        SendRequest();
    }
}

function SendRequest()
{
    id       = fila[ifila][0];
    arquivo  = fila[ifila][1];
    funcao   = fila[ifila][2];
    mensagem = fila[ifila][3];

    obj = CreateObjXMLHttpRequest(); // Cria uma instancia do objeto
    obj.onreadystatechange = GetContent; // Define a funcao chamada na mudanca de status do objeto
    obj.open('POST',arquivo, true) // Metodo prepara objeto pra requisicao
    obj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    obj.send(mensagem); // Envia requisicao
}

// url_encode version 1.0
function url_encode(str) {
    var hex_chars = "0123456789ABCDEF";
    var noEncode = /^([a-zA-Z0-9\_\-\.])$/;
    var n, strCode, hex1, hex2, strEncode = "";

    for(n = 0; n < str.length; n++) {
        if (noEncode.test(str.charAt(n))) {
            strEncode += str.charAt(n);
        } else {
            strCode = str.charCodeAt(n);
            hex1 = hex_chars.charAt(Math.floor(strCode / 16));
            hex2 = hex_chars.charAt(strCode % 16);
            strEncode += "%" + (hex1 + hex2);
        }
    }
    return strEncode;
}

// url_decode version 1.0
function url_decode(str) {
    var n, strCode, strDecode = "";

    for (n = 0; n < str.length; n++) {
        if (str.charAt(n) == "%") {
            strCode = str.charAt(n + 1) + str.charAt(n + 2);
            strDecode += String.fromCharCode(parseInt(strCode, 16));
            n += 2;
        } else {
            strDecode += str.charAt(n);
        }
    }
    return strDecode;
}

<!--------------------------------------------------------------------------------------->
// Funcoes do sistema
<!--------------------------------------------------------------------------------------->

function InserirPagina_envia(){
    document.getElementById(id).innerHTML = obj.responseText;
}

function InserirPagina_recebe(){
    document.getElementById(id).innerHTML = url_decode(obj.responseText);
}

<!--------------------------------------------------------------------------------------->
// Chamadas as funcoes
<!--------------------------------------------------------------------------------------->

function InserirComentario(nome,email,url,comentario,pg)
{
    // Monta array dos dados enviados pela requisicao
    var dados = new Array(nome,
                          email,
                          url,
                          comentario,
                          pg);
	
    // Chama requisicao
    Requisition(id='comunicacao_comentario',url='../comentarios/inserirComentario.php',funcao='InserirPagina_envia',dados);
    // Limpa formulario
    document.getElementById("form_comentario").reset();
    // Atualiza comentarios
	//ListarComentario(pg,'adicionado');
	setTimeout("ListarComentario('" + pg + "','adicionado')", 500);
}

function ListarComentario(pg,acao)
{
    // Monta array dos dados enviados pela requisicao
    var dados = new Array(pg,
                          acao);
    // Chama requisicao
    Requisition(id='comunicacao_comentario',url='../comentarios/listarComentario.php?mostra=ok',funcao='InserirPagina_recebe',dados);
}

