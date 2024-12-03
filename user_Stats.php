<!DOCTYPE html>
<html>
    <head>
    <title>User Stats</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <?php 
    session_start(); 
    require_once("./hum_conn_no_login.php");
    ini_set('display_errors', 1);
    ?>
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

    function get_user_id($conn, $username)
    {
        // Prepare the SQL query to fetch user id from users table
        $query = '
            SELECT 
                u.user_id
            FROM 
                users u
            WHERE 
                u.username = :username';
    
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
    
        return oci_fetch_assoc($stmt);
    }
    ?>
    <script>
        window.onload = function () {
            <?php 
            $conn = hum_conn_no_login();
            $username = $_SESSION['username'];
            $user_id = get_user_id($conn, $username);
            $user_stats = get_user_stats($conn, $user_id);
            ?>
            var userStats = <?php echo json_encode($user_stats); ?>;
            var wpm = userStats.wpm;
            var totalGamesEasy = userStats.total_games_easy;
            var totalGamesMedium = userStats.total_games_medium;
            var totalGamesHard = userStats.total_games_hard;
            var highScoreEasy = userStats.high_score_easy;
            var highScoreMedium = userStats.high_score_medium;
            var highScoreHard = userStats.high_score_hard;
        }
    </script>

    <div class="container">
        <h1>User Stats</h1>
        <div class="stats">
            <h2>WPM: <span id="wpm"><?php echo $wpm; ?></span></h2>
            <h2>Total Games (Easy): <span id="totalGamesEasy"><?php echo $totalGamesEasy; ?></span></h2>
            <h2>Total Games (Medium): <span id="totalGamesMedium"><?php echo $totalGamesMedium; ?></span></h2>
            <h2>Total Games (Hard): <span id="totalGamesHard"><?php echo $totalGamesHard; ?></span></h2>
            <h2>High Score (Easy): <span id="highScoreEasy"><?php echo $highScoreEasy; ?></span></h2>
            <h2>High Score (Medium): <span id="highScoreMedium"><?php echo $highScoreMedium; ?></span></h2>
            <h2>High Score (Hard): <span id="highScoreHard"><?php echo $highScoreHard; ?></span></h2>
        </div>

</body>
</html>