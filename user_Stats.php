<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Stats</title>
    <?php 
    session_start(); 
    require_once("./BackEnd/hum_conn_no_login.php");
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
        // Prepare the SQL query to fetch user ID from users table
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
    
        $row = oci_fetch_assoc($stmt);
    
        return $row['USER_ID'];
    }

    ?>
    <script>
        window.onload = function() {
            // Get the user ID from the session
            <?php $conn = hum_conn_no_login(); ?>
            var username = '<?php echo $_SESSION['username']; ?>';
            var user_id = '<?php echo get_user_id($conn, $_SESSION['username']); ?>';
            
        };
        
           
    </script>

    <h1>User Stats</h1>
    <div> 
        <p>WPM: <span id="wpm"></span></p>
        <p>Total Games (Easy): <span id="total_games_easy"></span></p>
        <p>Total Games (Medium): <span id="total_games_medium"></span></p>
        <p>Total Games (Hard): <span id="total_games_hard"></span></p>
        <p>High Score (Easy): <span id="high_score_easy"></span></p>
        <p>High Score (Medium): <span id="high_score_medium"></span></p>
        <p>High Score (Hard): <span id="high_score_hard"></span></p>
    </div>
    <?php
    // Close the connection
    oci_close($conn);
    ?>
</body>
</html>