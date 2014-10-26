<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Actualització de la programació</title>
</head>
<body>
<div id="wrapper">
	<h1 class="page-title">Actualitzacio de la programació</h1>
	<div id="content">
		<p>S'està iniciant...</p>
			<?php
				$nomtaulaprogramacio = "programacio";
				$condllista = " classic = 0";
				/*
				$nomtaulaprogramacio = "programacioclassic";
				$condllista = " classic = 1";
				*/
				include '../functions/gauss.php';
				/* Connectem amb la BD i seleccionem la taula */
				$con = mysql_connect("localhost","myrad571","BO26a1Wz");
				if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
				mysql_select_db("psicoajuradio", $con);
				mysql_set_charset('utf8',$con);
	
				/* Buidem l'anterior llista */
				$query = "TRUNCATE TABLE ".$nomtaulaprogramacio;
				mysql_query($query);
	
				echo "<p>S'ha buidat la taula anterior.</p>";
	
				$horaemissio = 0;
	
				/* Calculem el número de cançons */
				$query = "SELECT MAX(id) FROM llista WHERE ".$condllista; 
				$result = mysql_query($query);
				$comptadorcancons = mysql_fetch_array($result);
				//echo "<p>La màxima ID és: ".$comptadorcancons[0];
	
				/* Agafem la puntuació màxima i mínima */
				$query = "SELECT MAX(posmes) FROM llista WHERE ".$condllista;
				$result = mysql_query($query);
				$result2 = mysql_fetch_array($result);
				$maxposmes = $result2[0];
				$maxposmes = $maxposmes/2; // solucionar problema d'spam
				$query = "SELECT MAX(negmes) FROM llista WHERE ".$condllista;
				$result = mysql_query($query);
				$result2 = mysql_fetch_array($result);
				$maxnegmes = $result2[0];
				$query = "SELECT MAX(pos) FROM llista WHERE ".$condllista;
				$result = mysql_query($query);
				$result2 = mysql_fetch_array($result);
				$maxpos = $result2[0];
				$maxpos = $maxpos/2; // solucionar problema d'spam
				$query = "SELECT MAX(neg) FROM llista WHERE ".$condllista;
				$result = mysql_query($query);
				$result2 = mysql_fetch_array($result);
				$maxneg = $result2[0];
				//echo "<p>La puntuació màxima en positiu és ".$maxpos." i en negatiu ".$maxneg.".</p>";
	
				/* Creem un array per guardar les últimes cançons reproduides */
				$ultimes = array();
				
				/* Creem la llista */
				$horaemissio = 0;
				while(true) {
					/* Buidem info de l'anterior iteració */
					unset($duradaarray);
					unset($infocanco);
	
					/* Busquem una cançó a l'atzar */
					$id = rand(1,$comptadorcancons[0]);
	
					/* Agafem les dades de la cançó */
					$query = "SELECT *
							  FROM llista
							  WHERE id='".$id."'
								AND ".$condllista;
					$infocancons = mysql_query($query);
					$infocanco[] = mysql_fetch_array($infocancons);
					
					if ($infocanco[0]['aprovada'] == true) { // comprova que amb la ID triada hi hagués una cançó i que estigués aprovada
						/* Mirem si la saltem o no */
						$puntuaciopos = $infocanco[0]['pos']/($maxpos + 1); // Retorna un número entre 0 i 1
						$puntuacioneg = $infocanco[0]['neg']/($maxneg + 1); // Retorna un número entre 0 i 1
						//$puntuacioposmes = $infocanco[0]['posmes']/($maxposmes + 1); // Retorna un número entre 0 i 1
						//$puntuacionegmes = $infocanco[0]['negmes']/($maxnegmes + 1); // Retorna un número entre 0 i 1
						/*$puntuacio = $puntuaciopos*100 - $puntuacioneg*50
								 + $puntuacioposmes*200 - $puntuacionegmes*100 + 50;*/
						$puntuacio = ($puntuaciopos - $puntuacioneg)*100 + 20;

						if(randg(0,100) < $puntuacio) {
				
							/* Actualitzem l'array de les reproduïdes */
							if (!(array_search($infocanco[0]['artista'],$ultimes))) {
								$ultimes[0] = $ultimes[1];
								$ultimes[1] = $ultimes[2];
								$ultimes[2] = $ultimes[3];
								$ultimes[3] = $ultimes[4];
								$ultimes[4] = $ultimes[5];
								$ultimes[5] = $ultimes[6];
								$ultimes[6] = $ultimes[7];
								$ultimes[7] = $ultimes[8];
								$ultimes[8] = $ultimes[9];
								$ultimes[9] = $ultimes[10];
								$ultimes[10] = $ultimes[11];
								$ultimes[11] = $ultimes[12];
								$ultimes[12] = $ultimes[13];
								$ultimes[13] = $ultimes[14];
								$ultimes[14] = $ultimes[15];
								$ultimes[15] = $ultimes[16];
								$ultimes[16] = $ultimes[17];
								$ultimes[17] = $ultimes[18];
								$ultimes[18] = $ultimes[19];
								$ultimes[19] = $ultimes[20];
								$ultimes[20] = $infocanco[0]['artista'];
			
								echo "«".$infocanco[0]['nom']."» - ".round($puntuacio)." -- (".$infocanco[0]['pos']."-".$infocanco[0]['neg'].")<br/>";
								/* Agafem la durada */
								$duradaarray[] = explode(":",$infocanco[0]['durada']);

								/* Calculem l'hora d'emissió */
								$horaemissio += $duradaarray[0][0] * 3600 + $duradaarray[0][1] * 60 + $duradaarray[0][2];

								/* Inserim la id i l'hora d'emissió */
								$query = "INSERT INTO ".$nomtaulaprogramacio." (idcanco, hora) VALUES (".$id.",".$horaemissio.")";
								mysql_query($query);
								if ($horaemissio > 86400) break;
							}
						}
					}
				}
	
				mysql_close($con);
			?>
		<p>S'han afegit les noves cançons</p>
		<p>Procés finalitzat</p>
	</div>
</body>
</html>
