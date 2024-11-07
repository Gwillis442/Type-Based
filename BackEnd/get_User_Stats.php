<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/6/2024 
*/
require_once("./hum_conn_no_login.php");
ini_set('display_errors', 1);

function get_user_stats($conn, $user_id)
{
    // Prepare the SQL query to fetch user stats from typing_stats and math_stats tables
    $query = '
        SELECT 
            ts.wpm, ts.accuracy, ts.total_games_easy, ts.total_games_medium, ts.total_games_hard,
            ts.high_score_easy, ts.high_score_medium, ts.high_score_hard,
            ms.accuracy, ms.total_games_easy, ms.total_games_medium, ms.total_games_hard,
            ms.high_score_easy, ms.high_score_medium, ms.high_score_hard
        FROM 
            typing_stats ts
        LEFT JOIN 
            math_stats ms ON ts.user_id = ms.user_id
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
        echo "<h2>User Stats for User ID: $user_id</h2>";
        echo "<p>WPM: " . htmlentities($user_stats['WPM']) . "</p>";
        echo "<p>Accuracy: " . htmlentities($user_stats['ACCURACY']) . "</p>";
        echo "<p>Total Games (Easy): " . htmlentities($user_stats['TOTAL_GAMES_EASY']) . "</p>";
        echo "<p>Total Games (Medium): " . htmlentities($user_stats['TOTAL_GAMES_MEDIUM']) . "</p>";
        echo "<p>Total Games (Hard): " . htmlentities($user_stats['TOTAL_GAMES_HARD']) . "</p>";
        echo "<p>High Score (Easy): " . htmlentities($user_stats['HIGH_SCORE_EASY']) . "</p>";
        echo "<p>High Score (Medium): " . htmlentities($user_stats['HIGH_SCORE_MEDIUM']) . "</p>";
        echo "<p>High Score (Hard): " . htmlentities($user_stats['HIGH_SCORE_HARD']) . "</p>";
        echo "<p>Math Accuracy: " . htmlentities($user_stats['ACCURACY']) . "</p>";
        echo "<p>Math Total Games (Easy): " . htmlentities($user_stats['TOTAL_GAMES_EASY']) . "</p>";
        echo "<p>Math Total Games (Medium): " . htmlentities($user_stats['TOTAL_GAMES_MEDIUM']) . "</p>";
        echo "<p>Math Total Games (Hard): " . htmlentities($user_stats['TOTAL_GAMES_HARD']) . "</p>";
        echo "<p>Math High Score (Easy): " . htmlentities($user_stats['HIGH_SCORE_EASY']) . "</p>";
        echo "<p>Math High Score (Medium): " . htmlentities($user_stats['HIGH_SCORE_MEDIUM']) . "</p>";
        echo "<p>Math High Score (Hard): " . htmlentities($user_stats['HIGH_SCORE_HARD']) . "</p>";
    } else {
        echo "<p>No stats found for User ID: $user_id</p>";
    }

    // Close the connection
    oci_close($conn);
}
?>