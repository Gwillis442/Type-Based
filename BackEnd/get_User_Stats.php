<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * get_User_Stats.php
 * Returns the signed-in player's typing stats as JSON.
 */
session_start();
require_once("./hum_conn_no_login.php");
ini_set('display_errors', 0);

function get_user_stats($conn, $user_id)
{
    $query = '
        SELECT 
            wpm, total_games_easy, total_games_medium, total_games_hard,
            high_score_easy, high_score_medium, high_score_hard
        FROM typing_stats
        WHERE user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);

    if (!oci_execute($stmt)) {
        return false;
    }

    return oci_fetch_assoc($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = hum_conn_no_login();

    // Prefer the logged-in session user; fall back only if explicitly supplied
    $user_id = $_SESSION['user_id'] ?? filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING);

    if (empty($user_id)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No user identified.']);
        exit;
    }

    $user_stats = get_user_stats($conn, $user_id);

    header('Content-Type: application/json');
    if ($user_stats) {
        echo json_encode($user_stats);
    } else {
        echo json_encode(['error' => 'No stats found for this user.']);
    }

    oci_close($conn);
}
?>
