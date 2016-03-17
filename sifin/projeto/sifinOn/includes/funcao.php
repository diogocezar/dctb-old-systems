<?
	//CAIXA ALTA.
	function caixaAlta( $string ){ return strtoupper( &$string ); }
	
	//CAIXA BAIXA
	function caixaBaixa( $string ){ return strtolower( &$string ); }

	//RETIRAR CARACTERES DOS CAMPOS NUMERICOS
	function limpaNumero( $valor ){
		return ereg_replace("[^0-9]", "", $valor);
	}
	
	//RETORNA O NAVEGADOR COM INSTRUCOES
	function retorna( $pagina, $aviso, $campo, $vars ){
		$_SESSION['aviso'] = $aviso ;
		header ( "Location: $pagina?foco=$campo$vars" );
		exit;
	}

	//RETORNA O NAVEGADOR COM ID DA CONSULTA
	function retornaId( $pagina, $aviso, $campo, $vars ){
		$_SESSION['aviso'] = $aviso ;
		header ( "Location: $pagina&foco=$campo$vars" );
		exit;
	}

	//VALIDA CAMPOS OBRIGATORIOS
	function validaNulo( $vars, $campo ){
		if ( !NULL == $_POST[$campo] ){ 
			return $vars."&$campo=".$_POST[$campo]; 
		}
		$_SESSION['erro'] = true;
		return $vars;
	}
	
	//RETORNA CONTEUDO DO ARQUIVO
	function get_include_contents( $filename ){
		if ( is_file( $filename ) ) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}

	//VALIDACAO DO CPF
	function validaCpf( $cpf ) {
        $cleaned = '';
        for ( $i = 0; $i < strlen( $cpf ); $i++ ){
            $num = substr( $cpf, $i, 1 );
            if (ord($num) >= 48 && ord($num) <= 57) { $cleaned .= $num; }
        }
        $cpf = $cleaned;
        $cpf = preg_replace("/[^\d]/", '', $cpf);
        if ( strlen( $cpf ) != 11 ) { return false; }
		elseif ( in_array( $cpf, array("00000000000", "11111111111", "22222222222", "33333333333", "44444444444", "55555555555", "66666666666", "77777777777", "88888888888", "99999999999", "12345678909") ) ) {
            return false;
        } else {
            $number[0]  = intval(substr($cpf, 0, 1));
            $number[1]  = intval(substr($cpf, 1, 1));
            $number[2]  = intval(substr($cpf, 2, 1));
            $number[3]  = intval(substr($cpf, 3, 1));
            $number[4]  = intval(substr($cpf, 4, 1));
            $number[5]  = intval(substr($cpf, 5, 1));
            $number[6]  = intval(substr($cpf, 6, 1));
            $number[7]  = intval(substr($cpf, 7, 1));
            $number[8]  = intval(substr($cpf, 8, 1));
            $number[9]  = intval(substr($cpf, 9, 1));
            $number[10] = intval(substr($cpf, 10, 1));
            $sum = 10*$number[0]+9*$number[1]+8*$number[2]+7*$number[3]+
                6*$number[4]+5*$number[5]+4*$number[6]+3*$number[7]+
                2*$number[8];
            $sum -= ( 11 * ( intval( $sum/11 ) ) );
            if ($sum == 0 || $sum == 1) { $result1 = 0; }
			else { $result1 = 11 - $sum; }
            if ($result1 == $number[9]) {
                $sum  = $number[0]*11+$number[1]*10+$number[2]*9+$number[3]*8+
                    $number[4]*7+$number[5]*6+$number[6]*5+$number[7]*4+
                    $number[8]*3+$number[9]*2;
                $sum -= ( 11 * ( intval( $sum/11 ) ) );
                if ( $sum == 0 || $sum == 1 ){ $result2 = 0; } 
				else { $result2 = 11-$sum; }
                if ( $result2 == $number[10] ){ return true; }
				else { return false; }
            } else { return false; }
        }
    }

	//VALIDACAO CNPJ
	function validaCnpj( $cnpj ){
        $cleaned = '';
        for ( $i = 0 ; $i < strlen( $cnpj ); $i++ ){
            $num = substr($cnpj, $i, 1);
            if ( ord( $num ) >= 48 && ord( $num ) <= 57 ){ $cleaned .= $num; }
        }
        $cnpj = $cleaned;
        if ( strlen( $cnpj ) != 14 ) { return false; }
		elseif ( $cnpj == '00000000000000' ){ return false; }
		else {
            $number[0]  = intval(substr($cnpj, 0, 1));
            $number[1]  = intval(substr($cnpj, 1, 1));
            $number[2]  = intval(substr($cnpj, 2, 1));
            $number[3]  = intval(substr($cnpj, 3, 1));
            $number[4]  = intval(substr($cnpj, 4, 1));
            $number[5]  = intval(substr($cnpj, 5, 1));
            $number[6]  = intval(substr($cnpj, 6, 1));
            $number[7]  = intval(substr($cnpj, 7, 1));
            $number[8]  = intval(substr($cnpj, 8, 1));
            $number[9]  = intval(substr($cnpj, 9, 1));
            $number[10] = intval(substr($cnpj, 10, 1));
            $number[11] = intval(substr($cnpj, 11, 1));
            $number[12] = intval(substr($cnpj, 12, 1));
            $number[13] = intval(substr($cnpj, 13, 1));
            $sum = $number[0]*5+$number[1]*4+$number[2]*3+$number[3]*2+
        	        $number[4]*9+$number[5]*8+$number[6]*7+$number[7]*6+
    	            $number[8]*5+$number[9]*4+$number[10]*3+$number[11]*2;
            $sum -= ( 11 * ( intval( $sum/11 ) ) );
            if ( $sum == 0 || $sum == 1 ){ $result1 = 0; }
			else { $result1 = 11-$sum; }
            if ( $result1 == $number[12] ) {
                $sum  = $number[0]*6+$number[1]*5+$number[2]*4+$number[3]*3+
                	    $number[4]*2+$number[5]*9+$number[6]*8+$number[7]*7+
                    	$number[8]*6+$number[9]*5+$number[10]*4+$number[11]*3+
	                    $number[12]*2;
            	$sum -= ( 11 * ( intval( $sum/11 ) ) );
                if ($sum == 0 || $sum == 1) { $result2 = 0; }
				else { $result2 = 11-$sum; }
                if ( $result2 == $number[13] ) { return true; }
				else { return false; }
            } else { return false; }
        }
    }

	//VALIDACAO DO CAMPO CEP
	function validaCep( $cep ){
		$valor = $_POST[$cep] ;
		$valor = str_replace(".","",$valor);
		$valor = str_replace("-","",$valor);
		if ( ereg("/^[0-9]{8}$/", $valor ) ){
			return true;
		}
		return false;
	}
	
	//VALIDACAO DO CAMPO TELEFONE
	function validaTelefone( $campo ){
		$valor = $_POST[$campo] ;
		$valor = str_replace("(","",$valor);
		$valor = str_replace(")","",$valor);
		$valor = str_replace("-","",$valor);
		$valor = str_replace(" ","",$valor);
		if ( ereg("/^[0-9]{10}$/", $valor ) ){ return true; }
		return false;
	}

	//VALIDACAO DO ESTADO
	function validaEstado( $campo ){
		$valor = $_POST[$campo] ;
		$valor = caixaAlta( $valor );
		$estados = array("AC","AL","AP","AM","BA","CE","ES","GO","MA","MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO","DF");
		if( !in_array( $valor, $estados ) ){ return true; }
		return false;
	}

	//DATA BR
	function dataBr( $data ){
		return substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4);
	}

	//MASCARA CPF / CNPJ
	function mascaraCpfCnpj( $valor ){
		$tamanho = strlen( $valor );
		switch ( $tamanho ){
			case 11:
				return substr( $valor, 0, 3 ).".".substr( $valor, 3, 3 ).".".substr( $valor, 6, 3 )."-".substr( $valor, 9, 2 );
				break;
			case 14:
				return substr( $valor, 0, 2 ).".".substr( $valor, 2, 3 ).".".substr( $valor, 5, 3 )."/".substr( $valor, 8, 4 )."-".substr( $valor, 12, 2 );
				break;
			default:
				return " #ERRO MASCARA CPF / CNPJ# ";
				break;
		}
	}

	//MASCARA CEP
	function mascaraCep( $valor ){
		$tamanho = strlen( $valor );
		switch ( $tamanho ){
			case 8:
				return substr( $valor, 0, 2 ).".".substr( $valor, 2, 3 )."-".substr( $valor, 5, 3 );
				break;
			default:
				return " #ERRO MASCARA CEP# ";
				break;
		}
	}

	//MASCARA FONE
	function mascaraFone( $valor ){
		$tamanho = strlen( $valor );
		switch ( $tamanho ){
			case 10:
				return "(".substr( $valor, 0, 2 ).") ".substr( $valor, 2, 4 )."-".substr( $valor, 6, 4 );
				break;
			default:
				return " #ERRO MASCARA CEP# ";
				break;
		}
	}

	//VALIDA EMAIL
	function validaEmail( $campo ) {
		$email = $_POST[$campo];
		if ( eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$", $email, $check) ) {
			return true;
		}
		return false;
	}

?>