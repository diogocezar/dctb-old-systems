<?
	function conectNumberLines( &$sql ){
		$conexao = pg_connect("host=localhost port=5432 dbname=sifin user=sifin password=s1f1n");
		return pg_num_rows( pg_query( $sql  ) );
	}

	function conectArray( &$sql ){
		$conexao = pg_connect("host=localhost port=5432 dbname=sifin user=sifin password=s1f1n");
		return pg_fetch_array( pg_query( $sql ) );
	}

	function update( &$sql ){		
		$conexao = pg_connect("host=localhost port=5432 dbname=sifin user=sifin password=s1f1n");
		$result = pg_query( $sql );
		return pg_num_rows($result);
	}

	function executa( $SQL ){
		$conexao = pg_connect("host=localhost port=5432 dbname=sifin user=sifin password=s1f1n");
		$result = pg_query( $conexao , $SQL );
		$rows = pg_num_rows($result);
		for ($i = 0; $i < $rows; $i++){
			$data = pg_fetch_row($result,$i);
			$vetor[$i] = $data;
		}
		return $vetor;
	}

?>