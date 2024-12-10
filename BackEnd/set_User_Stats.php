<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 12/2/2024 
*/
session_start();
require_once("./hum_conn_no_login.php");
ini_set('display_errors', 1);
ini_set('display_errors', 1);

function check_high_score($conn, $user_id, $score, $difficulty)
{
    // Prepare the SQL query to fetch user stats from typing_stats table
    $query = '
        SELECT 
            ts.high_score_easy, ts.high_score_medium, ts.high_score_hard
        FROM 
            typing_stats ts
        WHERE 
            ts.user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);


    if ($difficulty === 'easy' && $score > $row['HIGH_SCORE_EASY']) {
        return true;
    } else if ($difficulty === 'medium' && $score > $row['HIGH_SCORE_MEDIUM']) {
        return true;
    } else if ($difficulty === 'hard' && $score > $row['HIGH_SCORE_HARD']) {
        return true;
    } else {
        return false;
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $conn = hum_conn_no_login();
    $user_id = $_SESSION['user_id'];
    $score = $_POST['score'];
    $difficulty = $_POST['difficulty'];
    $wpm = $_POST['wpm'];

    // Update the user stats
    if (check_high_score($conn, $user_id, $score, $difficulty)) {
        // Update the high score
        $update_query = 'UPDATE typing_stats SET high_score_' . $difficulty . ' = :score WHERE user_id = :user_id';
        $update_stmt = oci_parse($conn, $update_query);
        oci_bind_by_name($update_stmt, ':score', $score);
        oci_bind_by_name($update_stmt, ':user_id', $user_id);
        oci_execute($update_stmt);
    }

    // Increment the total games played
    $increment_query = 'UPDATE typing_stats SET total_games_' . $difficulty . ' = total_games_' . $difficulty . ' + 1 WHERE user_id = :user_id';
    $increment_stmt = oci_parse($conn, $increment_query);
    oci_bind_by_name($increment_stmt, ':user_id', $user_id);
    if (oci_execute($increment_stmt)) {
        error_log("Total games played incremented successfully");
    } else {
        $e = oci_error($increment_stmt);
        error_log("Error incrementing total games played: " . $e['message']);
    }

    // Update wpm 
    $wpm_query = 'UPDATE typing_stats SET wpm = :accuracy WHERE user_id = :user_id';
    $wpm_stmt = oci_parse($conn, $wpm_query);
    oci_bind_by_name($wpm_stmt, ':user_id', $user_id);
    oci_bind_by_name($wpm_stmt, ':accuracy', $wpm);
    if (oci_execute($wpm_stmt)) {
        error_log("WPM updated successfully");
    } else {
        $e = oci_error($wpm_stmt);
        error_log("Error updating WPM: " . $e['message']);
    } 

    // Close the connection
    oci_close($conn);
}

?>