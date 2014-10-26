<?php
	include '../functions.php';
	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
	
	if (isset($_POST['nom']) && ($_POST['nom'] != "")) {
	
		/* Mirem la URI */
		$uri = nameToUri($_POST['nom']);
	
		/* Busquem l'artista */
		$query = "SELECT * FROM `artistes` WHERE `nom` LIKE '".$_POST['artista']."'";
		$infoartista = mysql_query($query);
		$artista = mysql_fetch_array($infoartista);
	
		/* Si no existeix, el creem */
		if(!isset($artista['id']) || $artista['id'] == "") {
			$nom = nameToUri($_POST['artista']);
			$query = "INSERT INTO artistes (uri,nom) VALUES ('".$nom."','".$_POST['artista']."')";
			mysql_query($query);
		}
	
		/* Tornem a buscar l'artista */
		$query = "SELECT * FROM `artistes` WHERE `nom` LIKE '".$_POST['artista']."'";
		$infoartista = mysql_query($query);
		$artista = mysql_fetch_array($infoartista);
	
		$query="UPDATE albums SET uri = '".$uri."', nom = '".trim($_POST['nom'])."', artistaid = '".$artista['id']."', any = '".$_POST['any']."' WHERE id = ". $_POST['id'];
		if (!mysql_query($query,$con)) die("S'ha produït un error en afegir l'àlbum: " . mysql_error());
		$frase = "S'ha actualitzat correctament.";
	}
	
	$idalbum = $_GET['album'];
	$query = "SELECT albums.id, albums.uri, albums.nom, albums.any, artistes.uri AS artistauri, artistes.nom AS artista
		FROM albums
		LEFT OUTER JOIN artistes
			ON albums.artistaid = artistes.id
		WHERE albums.id=".$idalbum;
	$infoalbums = mysql_query($query);
	$album = mysql_fetch_array($infoalbums);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Modifica l'àlbum | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./albums.php">Torna a la llista</a>
	<h1 class="page-title">Modifica l'àlbum</h1>
	<div id="content">
		<?php echo "<p>".$frase."</p>" ?>
		<h2>Informació</h2>
		<form action="#" method="post" enctype="multipart/form-data">
		<input name="id" type="hidden" value="<?php echo $album['id'] ?>"/>
		<table>
			<tr>
				<td>Nom de l'àlbum:</td>
				<td><input name="nom" type="text" value="<?php echo $album['nom'] ?>"/></td>
			</tr>
			<tr>
				<td>Artista</td>
				<td><input name="artista" list="artistes" type="text" value="<?php echo $album['artista'] ?>"/></td>
			<?php /* Suggeriments */
				echo '<datalist id="artistes">';
				$query = "SELECT nom FROM artistes ORDER BY nom";
				$infoartista = mysql_query($query);
				while ($artista = mysql_fetch_array($infoartista)) {
					echo '<option label="'.$artista['nom'].'" value="'.$artista['nom'].'" />';
				}
				echo '</datalist>';
			?>
			</tr>
			<tr>
				<td>Any</td>
				<td><input name="any" type="text" value="<?php echo $album['any'] ?>" list="albums"/></td>
		</table>
		<input type="submit" value="Desa"/>
		</form>
	</div>
</div>
</body>
</html>
