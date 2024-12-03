<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/6/2024 
*/
session_start();
require_once("./hum_conn_no_login.php");
ini_set('display_errors', 1);

function get_user_stats($conn, $user_id)
{
    // Prepare the SQL query to fetch user stats from typing_stats table
    $query = '
        SELECT 
            ts.wpm, ts.total_games_easy, ts.total_games_medium, ts.total_games_hard,
            ts.high_score_easy, ts.high_score_medium, ts.high_score_hard
        FROM 
            typing_stats ts
        WHERE 
            ts.user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_execute($stmt);

    return oci_fetch_assoc($stmt);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = hum_conn_no_login();

    // Retrieve and sanitize form data
    $user_id = htmlspecialchars($_POST['user_id']);

    // Get the user stats
    $user_stats = get_user_stats($conn, $user_id);

    // Display the user stats
    if ($user_stats) {
        header('Content-Type: application/json');
        echo json_encode($user_stats);
    } else {
        echo json_encode(['error' => 'No stats found for this user.']);
    }

    // Close the connection
    oci_close($conn);
}
?>