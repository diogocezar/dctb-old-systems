<?
/* Incluindo classes */
include('./classes/Session.php');
include('./classes/DataBase.php');
include('./classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./php/configSite.php');

/* Incluindo arquivos de funções */
include('./lib/util.php');
include('./lib/library.php');

/*echo "Fotos dos filmes :";
echo "<br><br>";

$sql = "SELECT fil_foto FROM {$tabela['filme']} ORDER BY fil_foto";	
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$foto = str_replace('../', './', $dados['fil_foto']);
	if(!file_exists($foto)){
		echo $foto;
		echo "<br>";
	}
}

echo "<br><br><hr>";

echo "Fotos dos atores :";
echo "<br><br>";

$sql = "SELECT ato_foto FROM {$tabela['ator']} ORDER BY ato_foto";	
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$foto = str_replace('../', './', $dados['ato_foto']);
	if(!file_exists($foto) && !empty($foto)){
		echo $foto;
		echo "<br>";
	}
}

echo "Filmes sem gênero ++++++++++++++++++++++++++++++<br><br>";

$sql = "SELECT fil_cod FROM filme";	
$resultado = $dataBase->query($sql);
$i = 0;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$filme[$i] = $dados['fil_cod'];
	$i++;
}

for($i=0; $i<count($filme); $i++){
	$sql = "SELECT fil_cod FROM genero_filme WHERE fil_cod = {$filme[$i]}";
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if(empty($dados)){ echo $filme[$i]."<br>"; }
}*/

echo "Filmes sem mídia ++++++++++++++++++++++++++++++<br><br>";

$sql = "SELECT fil_cod FROM filme";	
$resultado = $dataBase->query($sql);
$i = 0;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$filme[$i] = $dados['fil_cod'];
	$i++;
}

for($i=0; $i<count($filme); $i++){
	$sql = "SELECT mid_cod FROM midia WHERE fil_cod = {$filme[$i]}";
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	if(empty($dados)){ echo retornaNomeFilme($filme[$i])."<br>"; }
}
?>