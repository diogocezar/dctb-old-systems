<?php

function calculaValorTag( $totalTag, $totalTagAtual ){   
$tamanhoTag  = ceil( ( ( $totalTagAtual * 100 ) / $totalTag ) * 50 ) + 100;   
$tamanhoTag  = $tamanhoTag > 500 ? 500 : $tamanhoTag;   
return $tamanhoTag;   
}   

$tag  = array(    
"javascript", "ajax", "ajaxbox", "asp", "php", "cfm", "web2.0", "js ",    
"asp", "url", "querystring", "decodifica", "ascii", "html", "badword", "fórum",    
"guestbook", "javascript", "html", "php", "java", "js", "cfm", "windows", "linux",    
"web 2.0", "css", "asp", "javascript", "ajaxbox", "web", "mundo", "conhecimento",    
"programação", "comunidade", "layout", "js", "htm", "menu", "aplfa", "javascript",    
"html", "ajax", "tutoriais", "demos", "apostilas", "links", "download", "ajaxbox",    
"ajax", "ajax", "tutoriais", "demos", "apostilas", "links", "trim", "rtrim", "ltrim",    
"retirar espaço vazio", "asp", "insert", "mysql", "sqlserver", "php", "badword",    
"fórum", "guestbook", "insert", "mysql", "sqlserver", "asp", "randomico", "senha",    
"gerador", "mysql", "asp", "conectar", "banco", "odbc", "centralizar", "div", "margin",    
"navegador", "div", "100 porcento", "height 100%", "height 100%", "div", "altura", "resize",    
"iis 6", "upload", "limit", "persist", "metabase.xml", "php", "mysql", "conectar", "asp.net",    
"email", "smtp", "autenticação", "upload", "asp.net", "c#", "asp", "badword", "fórum",    
"guestbook", "asp", "enquete", "porcentagem", "gráfico", "asp", "dolar", "custo", "conta",    
"asp", "array", "treeview", "menu", "syntaxhighlighter", "asp", "array", "print_r",    
"asp", "while", "loop", "for", "each", "repetição", "asp", "objeto", "cookie",    
"javascript", "cookie", "navegador", "html", "css", "style", "herança", "asp",    
"javascript", "ajax", "request", "get", "asp", "classe", "function", "class", "ereg",    
"asp", "busca", "google", "asp", "ereg", "buscador", "html", "cep", "webservice",    
"web service cep", "web service", "busca cep", "formulário", "for", "formulário",    
"busca cep", "web service", "web service cep", "webservice", "cep", "thumb",    
"thumb em preto e branco", "thumbnail", "php", "imagem", "gd", "foto", "imagem",    
"alexa", "ajaxbox", "hanking", "get", "post", "javascript", "ajax", "php", "asp",    
"php", "upload", "class", "classe", "validar", "arquivo"  
); 

# Aqui contamos o total de tags de nosso array.   
$tTag = count( $tag );   
# Juntando todas tags.   
$tagCountIguais = array_count_values( $tag );   
while ( list ( $chaveArray, $valor ) = each ( $tagCountIguais  ) ) {   
?>     
    <span style="font-size:<? echo calculaValorTag( $tTag, $valor );?>%">   
    <? echo $chaveArray;?>, </span>   
<? } ?>   
