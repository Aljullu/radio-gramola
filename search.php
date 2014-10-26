<?php
	include 'functions.php';
	$con = connecta();
	
	$searchedWord = nameToUri($_GET['s']);
	
	// Cançons
	$query = "SELECT llista.uri AS nom, artistes.uri AS artista
		FROM llista, artistes
		WHERE llista.uri LIKE '". $searchedWord ."'
			AND aprovada = 1
			AND llista.artistaid = artistes.id";
	$infocanco = mysql_query($query);
	if(mysql_num_rows($infocanco) != 0) {
		$first = true;
		while ($canco = mysql_fetch_array($infocanco)) {
			header("Location: http://www.radiogramola.cat/d/".$canco['artista']."/".$canco['nom']);
		}
	}
	else {
		// Artistes
		$query = "SELECT artistes.uri AS nom
			FROM artistes
			WHERE artistes.uri LIKE '". $searchedWord ."'";
		$infoartista = mysql_query($query);
		if(mysql_num_rows($infoartista) != 0) {
			$first = true;
			while ($artista = mysql_fetch_array($infoartista)) {
				header("Location: http://www.radiogramola.cat/d/".$artista['nom']);
			}
		}
		else {
			header("Location: http://www.radiogramola.cat/llista-cancons.php?s=".$_GET['s']);
		}
	}
?>
