<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 12/2/2024 
*/

require_once("./hum_conn_no_login.php");
ini_set('display_errors', 1);

function check_high_score($conn, $user_id, $score_easy, $score_medium, $score_hard)
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

    if($score_easy > $row['HIGH_SCORE_EASY']) {
        return true;
    } else if($score_medium > $row['HIGH_SCORE_MEDIUM']) {
        return true;
    } else if($score_hard > $row['HIGH_SCORE_HARD']) {
        return true;
    } else {
        return false;
    }
}

function set_user_stats_easy($conn, $user_id, $wpm, $score_easy)
{
    // Prepare the SQL query to update user stats in typing_stats table
    $query = '
        UPDATE 
            typing_stats
        SET 
            wpm = :wpm, total_games_easy = :total_games_easy + 1, high_score_easy = :high_score_easy
        WHERE 
            user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':wpm', $wpm);
    if(check_high_score($conn, $user_id, $score_easy, null, null)) {
        oci_bind_by_name($stmt, ':high_score_easy', $score_easy);
    } else {
        oci_bind_by_name($stmt, ':high_score_easy', $row['HIGH_SCORE_EASY']);
    }
    oci_execute($stmt);
}

function set_user_stats_medium($conn, $user_id, $wpm, $high_score_medium)
{
    // Prepare the SQL query to update user stats in typing_stats table
    $query = '
        UPDATE 
            typing_stats
        SET 
            wpm = :wpm, total_games_medium = :total_games_medium + 1, high_score_medium = :high_score_medium
        WHERE 
            user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':wpm', $wpm);
    if(check_high_score($conn, $user_id, null, $score_medium, null)) {
        oci_bind_by_name($stmt, ':high_score_medium', $score_medium);
    } else {
        oci_bind_by_name($stmt, ':high_score_medium', $row['HIGH_SCORE_MEDIUM']);
    }

    oci_execute($stmt);
}

function set_user_stats_hard($conn, $user_id, $wpm, $high_score_hard)
{
    // Prepare the SQL query to update user stats in typing_stats table
    $query = '
        UPDATE 
            typing_stats
        SET 
            wpm = :wpm, total_games_hard = :total_games_hard + 1, high_score_hard = :high_score_hard
        WHERE 
            user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_bind_by_name($stmt, ':wpm', $wpm);
    if(check_high_score($conn, $user_id, null, null, $score_hard)) {
        oci_bind_by_name($stmt, ':high_score_hard', $score_hard);
    } else {
        oci_bind_by_name($stmt, ':high_score_hard', $row['HIGH_SCORE_HARD']);
    }
    oci_execute($stmt);
}

if($_Server['REQUEST_METHOD'] == 'POST')
{
    $conn = hum_conn_no_login();

    // Retrieve and sanitize form data
    $user_id = htmlspecialchars($_POST['user_id']);
    $wpm = htmlspecialchars($_POST['wpm']);
    $score_easy = htmlspecialchars($_POST['score_easy']);
    $score_medium = htmlspecialchars($_POST['score_medium']);
    $score_hard = htmlspecialchars($_POST['score_hard']);

    // Update the user stats
    if($score_easy != null) {
    set_user_stats_easy($conn, $user_id, $wpm, $score_easy);
    } else if($score_medium != null) {
    set_user_stats_medium($conn, $user_id, $wpm, $score_medium);
    } else if($score_hard != null) {
    set_user_stats_hard($conn, $user_id, $wpm, $score_hard);
    } else {
        echo "Error: No high score found";
    }

    // Close the connection
    oci_close($conn);
}

?>