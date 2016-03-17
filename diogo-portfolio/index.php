<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Diogo Cezar - Portfólio</title>
    <link href="icone/icone.ico" rel="shortcut icon">
    <link href="css/portfolio.css" rel="stylesheet" type="text/css"/>
    <link href="css/portfolio-images.css" rel="stylesheet" type="text/css"/>
    <link href="css/portfolio-tecnologias.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css"/>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/slider.js" type="text/javascript"></script>
    <script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto();
        });
    </script>
</head>
<body>
	<div id="container">
		<?php
        include('./works/works.php');
        ?>
    	<div id="seta-esquerda" class="scrollButtons left"></div>
        <div id="centro">
            <div id="slider">    
                <div style="overflow: hidden;" class="scroll">
                    <div class="scrollContainer">
                    	<?php
							$work = $_GET['work'];
							$max = count($works);
							for($i=1;$i<=$max;$i++){
								$arrayWorks[] = $i;	
							}
							shuffle($arrayWorks);
							
							if(!empty($work) && ($work<=$max && $work>1)){
								$posicao_antiga = array_search($work,$arrayWorks);
								$aux = $arrayWorks[0];
								$arrayWorks[0] = $work;
								$arrayWorks[$posicao_antiga] = $aux;
							}
							
							foreach($arrayWorks as $key){
							$i = $key;
						?>
                        <div class="panel" id="panel_<?= $i ?>">
                                <div class="inside">
                                  <div id="infos">
                                    <h1><?= $works[$key]['titulo'] ?></h1>
                                    <div id="imagem_<?= $i ?>"></div>
                                    <div id="detalhes">
                                        <p>Categoria: <?= $works[$key]['categoria'] ?></p>
                                        <?php if(!empty($works[$key]['cliente'])){ ?>
                                        <p>Cliente: <?= $works[$key]['cliente'] ?></p>
                                        <?php } ?>
                                        <?php if(!empty($works[$key]['descricao'])){ ?>
                                        <p>Descrição: <?= $works[$key]['descricao'] ?></p>
                                        <?php } ?>
                                        <?php if(empty($works[$key]['naoveja'])){ ?>
                                        <div id="veja" onClick="$.prettyPhoto.open('works/images/work<?= $i ?>-full.jpg', '<?= $works[$key]['titulo'] ?>', '<?= $works[$key]['descricao'] ?>');"></div>
                                        <?php } ?>
										<?php if(!empty($works[$key]['site'])){ ?>
                                        <div id="site" onclick="javascript:window.open('<?= $works[$key]['site'] ?>');"></div>
                                        <?php } ?>
                                    </div>
                                  </div>
                                  <?php
								  $arrayTecnologias = $works[$key]['tecnologias'];
								  if(!empty($arrayTecnologias)){
								  ?>
                                  <div id="tecnologias">
                                      <div id="label-tecnologia">Tecnologias utilizadas:</div>
                                      <?php foreach($arrayTecnologias as $tecnologia){ ?>
                                      <div id="<?= $tecnologia?>"></div>
                                      <?php } ?>
                                  </div>
                                  <?php } ?>
                                </div>
                            </div>
							<?php
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="seta-direita" class="scrollButtons right"></div>
        <div id="status">0/0</div>
        <div id="menu">
        	<ul>
            	<li><a href="../blog">blog</a></li>
                <li><a href="../blog/quem-sou-eu/">perfil</a></li>
            	<li><a href="../curriculo/diogo-cezar.pdf">currículo</a></li>
            	<li><a href="../blog/musica">música</a></li>
            	<li><a href="../blog/links">links</a></li>
                <li><a href="../blog/contato">contato</a></li>
            </ul>
        </div>
</div>
</body>
</html>