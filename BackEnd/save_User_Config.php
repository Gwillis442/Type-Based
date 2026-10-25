<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * save_User_Config.php
 * Writes the signed-in player's mode, sound, music, and history settings.
 */

session_start();
require_once("./hum_conn_no_login.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$conn = hum_conn_no_login();
$user_id = $_SESSION['user_id'];
$mode = $_POST['mode'] ?? 'easy';
$sound = !empty($_POST['sound']) ? 1 : 0;
$music = !empty($_POST['music']) ? 1 : 0;
$history = !empty($_POST['history']) ? 1 : 0;

$query = 'UPDATE user_config SET default_mode = :mode, sound = :sound, music = :music, play_history = :history WHERE user_id = :user_id';
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ':mode', $mode);
oci_bind_by_name($stmt, ':sound', $sound);
oci_bind_by_name($stmt, ':music', $music);
oci_bind_by_name($stmt, ':history', $history);
oci_bind_by_name($stmt, ':user_id', $user_id);
oci_execute($stmt);
oci_close($conn);
?>
