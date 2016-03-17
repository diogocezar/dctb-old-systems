<?php

$cor = '#'.$_GET['cor'];

if(empty($_GET['cor'])){ $cor = '#000000'; }

echo "Cor escolhida: $cor <br><hr>";

$sufixo  = substr($cor, 2, 4);

for($i=16; $i<256; $i=$i+16){
	
	$corLaco = '#'.dechex($i).$sufixo;
	
	echo "Cor: $corLaco  ";

	echo "<font color=\"".$corLaco."\">TESTANDO A COR DA FONTE</font><br>";


}
?>