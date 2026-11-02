<?php
/*
 * Author: Kevin Tieu
 * Personal project — Type-Based
 *
 * list_songs.php
 * Returns the MP3 names in one difficulty folder.
 */
header("Content-Type: application/json");
$mode = $_GET["mode"] ?? "easy";
if (!in_array($mode, ["easy", "medium", "hard"], true)) {
    $mode = "easy";
}
$dir = __DIR__ . "/../Assets/audio/" . $mode;
$songs = [];
if (is_dir($dir)) {
    foreach (scandir($dir) as $name) {
        if (preg_match("/\.(mp3|ogg)$/i", $name)) {
            $songs[] = $name;
        }
    }
}
sort($songs);
echo json_encode($songs);
