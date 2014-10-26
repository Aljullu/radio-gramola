<?php
	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<script src="/js/sorttable.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Llista d'àlbums | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./artistes.php">Artistes</a> - <a href="./cancons.php">Cançons</a>
	<h1 class="page-title">Llista d'àlbums</h1>
	<div id="content">
		<table id="llista" class="sortable">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Artista</th>
					<th>Any</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = "SELECT albums.id, albums.nom, artistaid, any, artistes.nom AS artista
					FROM albums
					LEFT OUTER JOIN artistes
						ON artistaid = artistes.id
					ORDER BY artistes.nom";
				$infoalbum = mysql_query($query);
				while ($album = mysql_fetch_array($infoalbum)) {
						echo "<tr>";
						echo "<td><a href='/admin/modifica-album.php?album=".$album['id']."'><img src='http://phpmyadmin.mi-alojamiento.com/themes/pmahomme/img/b_edit.png'/>".$album['nom']."</a></td>";
						echo "<td>".$album['artista']."</td>";
						echo "<td>".$album['any']."</td>";
						echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>
