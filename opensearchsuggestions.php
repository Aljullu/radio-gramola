<?php
	include 'functions.php';

	$con = connecta();

	// Cançons
	$query = "SELECT llista.nom
		FROM llista
		WHERE llista.nom LIKE '%". $_GET['s'] ."%'
			AND aprovada = 1";
	$infocanco = mysql_query($query);
	echo '["'.$_GET['s'].'", [';
	$first = true;
	while ($canco = mysql_fetch_array($infocanco)) {
		if ($first) {
			$first = false;
		}
		else {
			echo ', ';
		}
		echo '"'. stripslashes($canco['nom']) .'"';
	}
	
	// Artistes
	$query = "SELECT artistes.nom
		FROM artistes
		WHERE artistes.nom LIKE '%". $_GET['s'] ."%'";
	$infoartista = mysql_query($query);
	while ($artista = mysql_fetch_array($infoartista)) {
		if ($first) {
			$first = false;
		}
		else {
			echo ', ';
		}
		echo '"'. stripslashes($artista['nom']) .'"';
	}
	
	// Àlbums
	$query = "SELECT albums.nom
		FROM albums
		WHERE albums.nom LIKE '%". $_GET['s'] ."%'";
	$infoalbum = mysql_query($query);
	while ($album = mysql_fetch_array($infoalbum)) {
		if ($first) {
			$first = false;
		}
		else {
			echo ', ';
		}
		echo '"'. stripslashes($album['nom']) .'"';
	}

	echo ']]';
?>
