<?php

define("SISTEMAS_INTERNOS", 0);
define("SISTEMAS_EXTERNOS", 1);

if(!file_exists("sistemas.json"))
	die('Erro ao exibir lista de sistemas.');

$sistemas = json_decode(file_get_contents("sistemas.json"));

function imprimeLogoSistema($url)
{
	if(!file_exists($url))
		return "images/ajuda.jpg";

	return $url;
}

function imprimeSistemas($tipo)
{
	global $sistemas;

	// Externo ou Interno
	$lista = ($tipo == SISTEMAS_EXTERNOS)? $sistemas->externos : $sistemas->internos;

	echo '<ul class="listaSistemas" id="' . (($tipo == SISTEMAS_EXTERNOS)? 'sistemasExternos' : 'sistemasInternos') . '">';

	foreach($lista as $sistema)
	{
		?>
		<li>
			<img class="logo" src="<?php echo imprimeLogoSistema($sistema->logo); ?>" style="height: 70px; width: 70px" />
			<h5 style="<?php echo property_exists($sistema, 'nome_style')? $sistema->nome_style : ''; ?>"><?php echo $sistema->nome; ?></h5>	
			<h6 style="<?php echo property_exists($sistema, 'descricao_style')? $sistema->descricao_style : ''; ?>"><?php echo $sistema->descricao; ?></h6>	
			<footer>	
				<?php 

				// Botões
				foreach($sistema->urls as $urlObj)
				{
					foreach($urlObj as $nome => $url)
					{
						$nome = str_replace("_", " ", $nome);
						$style = "";
						$alvo = "";

						if($url == "#")
							$style = " desativado";
						else if ($url == "inativo")
							$style = " inativo";
						else
							$alvo = "target=\"_blank\"";

						?><a class="botao<?php echo $style; ?>" href="<?php echo $url; ?>" <?php echo $alvo; ?>><?php echo $nome; ?></a><?php
					}
				}

				?>
			</footer>
		</li>
		<?php
	}

	echo '</ul>';
}

?><!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title>Sistemas de Gestão SDA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css" charset="utf-8" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@400;700&display=swap" rel="stylesheet">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
		<!-- <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/mordernizr.js"></script> -->
	</head>

	<body>
		<div class="cabecalho"></div>
			<div class="content">
				<div class="logo-header">
					<a href="https://sda.ce.gov.br" id="logo"><img src="images/sda.png"/></a>
					<button><a href="http://sistemas4.sda.ce.gov.br/intranet/" target="_blank">Intranet</a></button>
					
					<?php 
					if($_SERVER['REMOTE_ADDR'] == '10.85.0.10' || substr($_SERVER['REMOTE_ADDR'], 0, 7) == '172.28.')
					{
						?>
					<?php
					}
					echo '<!-- ' . $_SERVER['REMOTE_ADDR'] . ' -->';
					?>
				</div>

				<div class="title-header">
					<h1>Sistemas da SDA</h1>
				</div>
			
				<div class="title-labels">
					<h4>Sistemas Externos</h4>
				</div>
		
				<div class="separador"></div>

					<?php imprimeSistemas(SISTEMAS_EXTERNOS); ?>
			
				<div class="title-labels">
					<h4>Sistemas Internos</h4>
				</div>
			
				<div class="separador"></div>
					<?php imprimeSistemas(SISTEMAS_INTERNOS); ?>
			</div>
			
		<footer>
			<div class="footer">Todos os Direitos Reservados a Secretaria do Desenvolvimento Agrário do Ceará</div>
		</footer>
		</div>
	</body>
</html>
