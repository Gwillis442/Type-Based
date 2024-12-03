<?php 
    session_start(); 
    require_once("./BackEnd/hum_conn_no_login.php");
    ini_set('display_errors', 1);
    error_reporting(E_ALL); // Enable all error reporting
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Stats</title>
</head>
<body>
    <?php
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

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<p>User not logged in. Please log in to view your stats.</p>";
        exit();
    }

    $conn = hum_conn_no_login();
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Get the user stats
    $user_stats = get_user_stats($conn, $user_id);

    // Assign variables
    $wpm = $user_stats['WPM'] ?? 'N/A';
    $totalGamesEasy = $user_stats['TOTAL_GAMES_EASY'] ?? 'N/A';
    $totalGamesMedium = $user_stats['TOTAL_GAMES_MEDIUM'] ?? 'N/A';
    $totalGamesHard = $user_stats['TOTAL_GAMES_HARD'] ?? 'N/A';
    $highScoreEasy = $user_stats['HIGH_SCORE_EASY'] ?? 'N/A';
    $highScoreMedium = $user_stats['HIGH_SCORE_MEDIUM'] ?? 'N/A';
    $highScoreHard = $user_stats['HIGH_SCORE_HARD'] ?? 'N/A';
    ?>

    
    <h2>User Stats for: <?= htmlentities($username) ?></h2>
    <p>WPM: <?= htmlentities($wpm) ?></p>
    <p>Total Games (Easy): <?= htmlentities($totalGamesEasy) ?></p>
    <p>Total Games (Medium): <?= htmlentities($totalGamesMedium) ?></p>
    <p>Total Games (Hard): <?= htmlentities($totalGamesHard) ?></p>
    <p>High Score (Easy): <?= htmlentities($highScoreEasy) ?></p>
    <p>High Score (Medium): <?= htmlentities($highScoreMedium) ?></p>
    <p>High Score (Hard): <?= htmlentities($highScoreHard) ?></p>
    <?php
    // Close the connection
    oci_close($conn);
    ?>
</body>
</html>