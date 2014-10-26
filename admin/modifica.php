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
		$query = "SELECT * FROM `artistes` WHERE `uri` LIKE '".nameToUri($_POST['artista'])."'";
		$infoartista = mysql_query($query);
		$artista = mysql_fetch_array($infoartista);
		
		/* Si no existeix, el creem */
		if(!isset($artista['id']) || $artista['id'] == "") {
			$nom = nameToUri($_POST['artista']);
			$query = "INSERT INTO artistes (uri,nom) VALUES ('".$nom."','".htmlspecialchars($_POST['artista'], ENT_QUOTES)."')";
			mysql_query($query);
		}
	
		/* Tornem a buscar l'artista */
		$query = "SELECT * FROM `artistes` WHERE `uri` LIKE '".nameToUri($_POST['artista'])."'";
		$infoartista = mysql_query($query);
		$artista = mysql_fetch_array($infoartista);
	
		/* Busquem l'àlbum */
		$query = "SELECT * FROM `albums` WHERE `uri` LIKE '".nameToUri($_POST['album'])."'";
		$infoalbum = mysql_query($query);
		if($infoalbum) {
			$album = mysql_fetch_array($infoalbum);
		}
	
		/* Si no existeix, el creem */
		if(!isset($album['id']) || $album['id'] == "") {
			$nom = nameToUri($_POST['album']);
			$query = "INSERT INTO albums (uri,nom,artistaid) VALUES ('".$nom."','".htmlspecialchars($_POST['album'], ENT_QUOTES)."','".$artista['id']."')";
			mysql_query($query);
		}
	
		/* Tornem a buscar l'artista */
		$query = "SELECT * FROM `albums` WHERE `uri` LIKE '".nameToUri($_POST['album'])."'";
		$infoalbum = mysql_query($query);
		if($infoalbum) {
			$album = mysql_fetch_array($infoalbum);
		}
	
		$query="UPDATE llista
				SET uri = '".$uri."', nom = '".htmlspecialchars(trim($_POST['nom']), ENT_QUOTES)."', artistaid = '".$artista['id']."', albumid = '".$album['id']."', codi = '".$_POST['codi']."', durada = '".$_POST['durada']."', lletra = '".htmlspecialchars($_POST['lletra'], ENT_QUOTES)."', lletraviasona = '".trim($_POST['lletraviasona'])."', aprovada = ".$_POST['aprovada']."
				WHERE id = ". $_POST['id'];
		if (!mysql_query($query,$con)) die("S'ha produït un error en afegir la cançó: " . mysql_error());
		$frase = "La informació de la cançó s'ha actualitzat correctament.";
		
		$query = "DELETE
					FROM canconstemes
					WHERE idcanco = ". $_POST['id'];
		mysql_query($query);
		if(count($_POST['temes']) > 0) {
			foreach ($_POST['temes'] as $tema) {
				$query = "INSERT INTO canconstemes (idcanco, idtema)
							VALUES (".$_POST['id'].",".$tema.")";
				mysql_query($query);
			}
		}
		
		$frase = $frase . " La informació dels temes, també.";
		
		$query = "DELETE
					FROM canconsseries
					WHERE idcanco = ". $_POST['id'];
		mysql_query($query);
		if(count($_POST['serie']) > 0) {
			foreach ($_POST['serie'] as $serie) {
				$query = "INSERT INTO canconsseries (idcanco, idserie, temporada, capitol)
							VALUES (".$_POST['id'].",".$serie.",0,0)";
				mysql_query($query);
			}
		}
		
		$frase = $frase . " La informació de les sèries, també.";
	}
	
	$idcanco = $_GET['canco'];
	$query = "SELECT llista.id, llista.uri, llista.nom, codi, durada, lletra, lletraviasona, aprovada, artistes.uri AS artistauri, artistes.nom AS artista, albums.nom AS album
		FROM llista
		JOIN artistes
			ON llista.artistaid = artistes.id
		LEFT OUTER JOIN albums
			ON llista.albumid = albums.id
		LEFT OUTER JOIN canconsseries
			ON llista.id = canconsseries.idcanco
		WHERE llista.id=".$idcanco;
	$infocancons = mysql_query($query);
	$canco = mysql_fetch_array($infocancons);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Modifica la cançó | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./cancons.php">Torna a la llista</a>
	<h1 class="page-title">Modifica la cançó</h1>
	<div id="content">
		<?php echo "<p>".$frase."</p>" ?>
		<?php
			/* Busquem duplicats */
			$query = "SELECT id, nom FROM `llista` WHERE `nom` LIKE '".$canco['nom']."'";
			$infoduplicat = mysql_query($query);
			//$duplicat = mysql_fetch_array($infoduplicat);
		?>
		<?php if (isset($duplicat['id']) && $duplicat['id'] != "" && $duplicat['id'] != $canco['id']) { ?>
			<h2>Cançons semblants</h2>
			<p>La següent cançó s'assembla a la que esteu modificant, assegureu-vos que no és un duplicat.</p>
			<?php echo "<a href='http://www.radiogramola.cat/admin/modifica.php?canco=".$duplicat['id']."'>".$duplicat['nom']."</a>"; ?>
		<?php } ?>
		<h2>Informació</h2>
		<form action="#" method="post" enctype="multipart/form-data">
		<input name="id" type="hidden" value="<?php echo $canco['id'] ?>"/>
		<table>
			<tr>
				<td>Nom de la cançó:</td>
				<td><input name="nom" type="text" value="<?php echo $canco['nom'] ?>"/></td>
			</tr>
			<tr>
				<td>Artista</td>
				<td><input name="artista" list="artistes" type="text" value="<?php echo $canco['artista'] ?>"/></td>
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
				<td>Àlbum</td>
				<td><input name="album" type="text" value="<?php echo $canco['album'] ?>" list="albums"/></td>
			<?php /* Suggeriments */
				echo '<datalist id="albums">';
				$query = "SELECT nom FROM albums ORDER BY nom";
				$infoartista = mysql_query($query);
				while ($album = mysql_fetch_array($infoartista)) {
					echo '<option label="'.$album['nom'].'" value="'.$album['nom'].'" />';
				}
				echo '</datalist>';
			?>
			</tr>
			<tr>
				<td>Durada</td>
				<td><input name="durada" type="text" value="<?php echo $canco['durada'] ?>"/></td>
			</tr>
			<tr>
				<td>Codi</td>
				<td><input name="codi" type="text" value="<?php echo $canco['codi'] ?>"/> <small>(<a style="display: inline;" href="http://www.youtube.com/watch?v=<?php echo $canco['codi']; ?>">mostra</a>)</small></td>
			</tr>
			<tr>
				<td>
					Temes<br/>
				</td>
				<td>
					<select name="temes[]" multiple>
						<?php
							$query = "SELECT id, nom
										FROM temes
										ORDER BY nom";
							$infotemes = mysql_query($query);
							while ($temes = mysql_fetch_array($infotemes)) {
								$selected = "";
								$query = "SELECT idtema
											FROM canconstemes
											WHERE idcanco = ".$canco['id']." 
											AND idtema = ".$temes['id'];
								$infocanconstemes = mysql_query($query);
								
								if (mysql_num_rows($infocanconstemes)) $selected = "selected";
						?>
							<option <?php echo $selected; ?> value="<?php echo $temes['id'] ?>"><?php echo $temes['nom'] ?></option>
						<?php
							}
						?>
					</select>
			<tr>
				<td>
					Sèries<br/>
				</td>
				<td>
					<select name="serie[]" multiple>
						<?php
							$query = "SELECT id, nom
										FROM series
										ORDER BY nom";
							$infoseries = mysql_query($query);
							while ($series = mysql_fetch_array($infoseries)) {
								$selected = "";
								$query = "SELECT idserie
											FROM canconsseries
											WHERE idcanco = ".$canco['id']." 
											AND idserie = ".$series['id'];
								$infocanconsseries = mysql_query($query);
							echo $query;
								if (mysql_num_rows($infocanconsseries)) $selected = "selected";
						?>
							<option <?php echo $selected; ?> value="<?php echo $series['id'] ?>"><?php echo $series['nom'] ?></option>
						<?php
							}
						?>
					</select>
			<tr>
				<td>Lletra</td>
				<td><textarea  cols="60" rows="30" name="lletra"><?php echo $canco['lletra']; ?></textarea></td>
			</tr>
			<tr>
				<td>Lletra Viasona</td>
				<td><input name="lletraviasona" type="text" value="<?php echo $canco['lletraviasona'] ?>"/></td>
			</tr>
			<tr>
				<td>Aprovada</td>
				<td><input name="aprovada" type="text" value="<?php echo $canco['aprovada'] ?>"/></td>
			</tr>
		</table>
		<input type="submit" value="Desa"/>
		</form>
	</div>
</div>
</body>
</html>
