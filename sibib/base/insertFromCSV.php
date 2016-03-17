<HTML>
<HEAD>
<TITLE> Exibindo Dados </TITLE>
</HEAD>
<BODY>
<?php
set_time_limit(0);

mysql_connect('localhost','root','') or die(mysql_error());
mysql_select_db('sibib') or die(mysql_error());

// nome do arquivo
$arquivo = 'livros.csv';

// ponteiro para o arquivo
$fp = fopen($arquivo, "r");

// processa os dados do arquivo
while(($dados = fgetcsv($fp, 0, ";")) !== FALSE){
	$quant_campos = count($dados);
	$j = 0;
	for($i = 0; $i < $quant_campos; $i++){
		  /*
		  if($j < 5){
			  $j++;
			  $fim = "',";
		  }
		  else{
			  $fim = "'";
			  $j=0;
		  }
		  */
		  $j++;
		  $dados[$i] = strtoupper($dados[$i]);
		  $imprime = $dados[$i];
		  $fim = "',";
		  if($j == 2){
			  /* VERIFICANDO SE AUTOR JAH EXISTE */
			  $sql = "SELECT count(nome) as c FROM autor where nome = '".$dados[$i]."'";
			  $resultado = mysql_query($sql) or die(mysql_error());
			  $autor_verifica = mysql_fetch_array($resultado) or die(mysql_error());
			  if($autor_verifica['c'] == 0){
				mysql_query("INSERT INTO autor (nome) VALUES ('".$dados[$i]."')") or die(mysql_error());
				
				$resultado_id = mysql_query("SELECT MAX(id_autor) as m FROM autor");
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  else{
				$resultado_id = mysql_query("SELECT id_autor as m FROM autor WHERE nome = '".$dados[$i]."'") or die(mysql_error());
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  $imprime = $id['m'];
		  }
		  if($j == 3){
			  /* VERIFICANDO SE EDITORA JAH EXISTE */
			  $sql = "SELECT count(nome) as c FROM editora where nome = '".$dados[$i]."'";
			  $resultado = mysql_query($sql) or die(mysql_error());
			  $autor_verifica = mysql_fetch_array($resultado) or die(mysql_error());
			  if($autor_verifica['c'] == 0){
				mysql_query("INSERT INTO editora (nome) VALUES ('".$dados[$i]."')") or die(mysql_error());
				$resultado_id = mysql_query("SELECT MAX(id_editora) as m FROM editora");
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  else{
				$resultado_id = mysql_query("SELECT id_editora as m FROM editora WHERE nome = '".$dados[$i]."'") or die(mysql_error());
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  $imprime = $id['m'];
		  }
		  if($j == 5){
			  /* VERIFICANDO SE GENERO JAH EXISTE */
			  $sql = "SELECT count(nome) as c FROM tipo_acervo where nome = '".$dados[$i]."'";
			  $resultado = mysql_query($sql) or die(mysql_error());
			  $autor_verifica = mysql_fetch_array($resultado) or die(mysql_error());
			  if($autor_verifica['c'] == 0){
				mysql_query("INSERT INTO tipo_acervo (nome) VALUES ('".$dados[$i]."')") or die(mysql_error());
				$resultado_id = mysql_query("SELECT MAX(id_tipo_acervo) as m FROM tipo_acervo");
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  else{
				$resultado_id = mysql_query("SELECT id_tipo_acervo as m FROM tipo_acervo WHERE nome = '".$dados[$i]."'") or die(mysql_error());
				$id = mysql_fetch_array($resultado_id) or die(mysql_error());
			  }
			  $imprime = $id['m'];
		  }
		  $tupla .= "'".$imprime.$fim;
		  echo $j." ".$tupla."<br><br><br>";
	}
	
	$sql = "INSERT INTO acervo (numero, id_autor, id_editora, titulo, id_tipo_acervo, qtd_volumes, volume, status) VALUES (".$tupla."'1','DISPONÍVEL')";
	echo $sql;
	mysql_query($sql) or die(mysql_error());
	$tupla = "";
}

fclose($fp);



?>
</BODY>
</HTML>