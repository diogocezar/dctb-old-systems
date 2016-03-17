<?php
/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

$id = $_GET['id'];

$saidaManifesto = $controlador['saidamanifesto'];
$saidaManifesto->__toFillGeneric();
$saidaManifesto->__get_db($id);

$entregas = $controlador['entregas'];
$entregas->__toFillGeneric();

$conhecimentos = $entregas->getCon($id);

$conhecimento = $controlador['conhecimento'];
$conhecimento->__toFillGeneric();
$resultado = $conhecimento->getListRelOutMan($conhecimentos);

$reportPdf = $controlador['reportpdf'];
$reportPdf->styleFooter('Arial', '', 5,  0, 0,  10,-15, 128);
$reportPdf->styleHeader('Arial', '', 8, 0, 100, 5, 10, 45);
$reportPdf->__start_ReportPDF('MEC - MANIFESTO DE ENTREGA DE CONHECIMENTO', 'Página', 'Arial', '', 4, 0, 4);

$reportPdf->turnOnDecoration('B');
$reportPdf->makeCell(utf8_decode("NÚMERO DO MANIFESTO: TESTE"), 0);
$reportPdf->turnOffDecoration();

$reportPdf->ln();
$reportPdf->ln();

$titles = array('NUM'              => 20,
				'FILIAL EMISSORA'  => 30,
                'DESTINATÁRIO'     => 30,
				'ENDEREÇO'         => 53,
				'DESTINO'          => 10,
				'UF'               => 5,
				'VOLUMES'          => 10,
				'PESO'             => 7,
				'VLR. NOTA FISCAL' => 15,
				'VLR. FRETE'       => 15
				);

$reportPdf->turnOnDecoration('B');
$reportPdf->makeCell("CONHECIMENTOS", 0);
$reportPdf->turnOffDecoration();

$reportPdf->ln();

$reportPdf->printTitles($titles);


$totalizador['qtd'] = 0;
$totalizador['vol'] = 0;
$totalizador['pes'] = 0;
$totalizador['nfs'] = 0;
$totalizador['fre'] = 0;

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$endereco = "";
	$endereco .= $dados['rua'].", ".$dados['numero'];
	if(!empty($dados['complemento'])){ $endereco .= " - ".$dados['complemento']; }

	$line = array($dados['numconhecimento'],
				  $dados['razaosocial'],
	              $dados['nome'],
				  $endereco,
				  $dados['cidade'],
				  $dados['estado'],
				  $dados['volumes'],
				  $dados['peso'],
				  formataDinheiro($dados['valornotafiscal']),
				  formataDinheiro($dados['valorfrete'])
				  );
	$reportPdf->printLines($line);
	
	$totalizador['qtd']++;
	$totalizador['vol'] += $dados['volumes'];
	$totalizador['pes'] += $dados['peso'];
	$totalizador['nfs'] += $dados['valornotafiscal'];
	$totalizador['fre'] += $dados['valorfrete'];
}

$reportPdf->ln();
$reportPdf->ln();


$titlesTotalizadores = array("QTDADE" =>                  30,
							 "TOTAL DE VOLUMES"        => 20,
							 "TOTAL DE PESO (KGS)"     => 20,
							 "TOTAL VLR. NOTA FISCAL"  => 20,
							 "TOTAL VLR. FRETE"        => 20);

$reportPdf->setCell_width(100);

$reportPdf->turnOnDecoration('B');
$reportPdf->makeCell("TOTALIZADORES", 0);
$reportPdf->turnOffDecoration();

$reportPdf->setCell_width(20);

$reportPdf->ln();

$reportPdf->printTitles($titlesTotalizadores);

$lineTotalizadores = array($totalizador['qtd'],
						   $totalizador['vol'],
						   $totalizador['pes'],
						   formataDinheiro($totalizador['nfs']),
						   formataDinheiro($totalizador['fre']));

$reportPdf->printLines($lineTotalizadores);

$reportPdf->ln();
$reportPdf->ln();

$reportPdf->setCell_width(0);

$reportPdf->turnOnDecoration('B');
$reportPdf->makeCell(utf8_decode("AGREGADO: TESTE"), 0);
$reportPdf->turnOffDecoration();

$reportPdf->ln();
$reportPdf->ln();

$reportPdf->turnOnDecoration('B');
$reportPdf->makeCell(utf8_decode("CONFERÊNCIA DE CARGA"), 0, 0);
$reportPdf->turnOffDecoration();

$reportPdf->ln();
$reportPdf->ln();
$reportPdf->setCell_width(50);
$height  = $reportPdf->getCell_height();
$reportPdf->Cell(50, $height, utf8_decode("VISTO OPERACIONAL"), 'T');
$reportPdf->Cell(5);
$reportPdf->Cell(50, $height, utf8_decode("VISTO AGREGADO - MOTORISTA"), 'T');
$reportPdf->ln();
$reportPdf->Cell(50, $height, utf8_decode("DATA: __/__/____"));
$reportPdf->Cell(5);
$reportPdf->Cell(50, $height, utf8_decode("DATA: __/__/____"));

//$reportPdf->makeCell(utf8_decode("VISTO OPERACIONAL"), 0, 'T');
//$reportPdf->makeCell(utf8_decode("VISTO AGREGADO - MOTORISTA"), 0, 'T');

$reportPdf->Output();
?>