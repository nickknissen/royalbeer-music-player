<?php

$fileContent = file_get_contents('./tracks.json');
$tracks = json_decode($fileContent, true);

$selectedTracks = array_filter($tracks, function ($track) {
	return in_array($track["id"], $_GET["id"]);
});

echo json_encode(array_values($selectedTracks));
