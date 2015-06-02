<?php

	require_once "Album.php";
	$album = new Album();

$album->excluiAlbum($_GET['toExclude']);