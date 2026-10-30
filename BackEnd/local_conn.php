<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * local_conn.php
 * Opens the SQLite file used when the project is not on nrs-projects.
 */
function local_conn()
{
    $dir = __DIR__ . "/../data";
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $path = $dir . "/typebased.sqlite";
    $db = new PDO("sqlite:" . $path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $schema = file_get_contents(__DIR__ . "/../Database/local_schema.sql");
    $db->exec($schema);
    return $db;
}
