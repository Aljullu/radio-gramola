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
	$infocanco = mysqli_query($con, $query);
	if(mysqli_num_rows($infocanco) != 0) {
		$first = true;
		while ($canco = mysqli_fetch_array($infocanco)) {
			header("Location: ". $baseUrl ."/d/".$canco['artista']."/".$canco['nom']);
		}
	}
	else {
		// Artistes
		$query = "SELECT artistes.uri AS nom
			FROM artistes
			WHERE artistes.uri LIKE '". $searchedWord ."'";
		$infoartista = mysqli_query($con, $query);
		if(mysqli_num_rows($infoartista) != 0) {
			$first = true;
			while ($artista = mysqli_fetch_array($infoartista)) {
				header("Location: ". $baseUrl ."/d/".$artista['nom']);
			}
		}
		else {
			header("Location: ". $baseUrl ."/llista-cancons.php?s=".$_GET['s']);
		}
	}
?>
