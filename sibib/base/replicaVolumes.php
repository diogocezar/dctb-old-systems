<?php
set_time_limit(0);

mysql_connect('localhost','root','') or die(mysql_error());
mysql_select_db('sibib') or die(mysql_error());

$sql = "SELECT * FROM ACERVO WHERE qtd_volumes > 1 ORDER BY titulo, volume";
$resultado = mysql_query($sql) or die(mysql_error());

while($dados = mysql_fetch_array($resultado)){
	$qtd_volumes = $dados['qtd_volumes'];
	$volume = $qtd_volumes;
	for($i=1; $i<$qtd_volumes; $i++){
		$id_tipo_acervo = $dados['id_tipo_acervo'];
		$id_autor = $dados['id_autor'];
		$id_editora = $dados['id_editora'];
		$numero = $dados['numero'];
		$volume_p = $volume--;
		$titulo = $dados['titulo'];
		$qtd_volumes = $dados['qtd_volumes'];
		$status = 'DISPONÍVEL';
		
		$sql_verifica = "SELECT count(*) as c FROM acervo WHERE numero = $numero AND volume = $volume_p";
		$resultado_verifica = mysql_query($sql_verifica) or die(mysql_error());
		$verifica = mysql_fetch_array($resultado_verifica);
		if(empty($verifica['c'])){		
			$sql_insert = "INSERT INTO acervo (id_tipo_acervo, id_autor, id_editora, numero, volume, titulo, qtd_volumes, status) values ('$id_tipo_acervo', '$id_autor', '$id_editora', '$numero', '$volume_p', '$titulo', '$qtd_volumes', '$status')";
			echo $sql_insert."<br>";
			mysql_query($sql_insert) or die(mysql_error());
		}
	}
}

echo "<script>alert('Todos volumes pendentes foram replicados.');history.go(-1);</script>";

?>