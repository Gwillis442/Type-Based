<?php
session_start();
require_once("../BackEnd/hum_conn_no_login.php");
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Type-Based</title>
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css"
        integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    <style>
        #username {
            float: right;
            white-space: nowrap;
            background-color: black;
            color: white;
            border-radius: 0px;
            padding: 5px;
            padding-right: 12.5px;
            padding-left: 12.5px;
            font-size: 20px;
        }

        .containerTitle {
            display: inline-block;
        }

        .w3-container-inner {}

        .container-element {}
    </style>
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

    $conn = hum_conn_no_login();
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Get the user stats
    $user_stats = get_user_stats($conn, $user_id);

    // Assign variables
    $totalGamesEasy = $user_stats['TOTAL_GAMES_EASY'] ?? 'N/A';
    $totalGamesMedium = $user_stats['TOTAL_GAMES_MEDIUM'] ?? 'N/A';
    $totalGamesHard = $user_stats['TOTAL_GAMES_HARD'] ?? 'N/A';
    $highScoreEasy = $user_stats['HIGH_SCORE_EASY'] ?? 'N/A';
    $highScoreMedium = $user_stats['HIGH_SCORE_MEDIUM'] ?? 'N/A';
    $highScoreHard = $user_stats['HIGH_SCORE_HARD'] ?? 'N/A';
    $wpm = $user_stats['WPM'] ?? 'N/A';
    ?>
    <?php
    // Close the connection
    oci_close($conn);
    ?>

    <body>

        <div class="w3-container w3-half">
            <div class="w3-container config-container">
                <h2 class="containerTitle">USER STATS</h2>
                <h2 id="username">
                    <i class="ri-user-3-fill"></i>
                    <?= htmlentities($username) ?>
                </h2>
                <div class="w3-container">
                    <table CELLSPACING="0px">
                        <tr>
                            <td style="font-size:12px;padding:5px">
                                <i class="ri-hashtag" style="font-size:12px"></i>
                                <span>Games Played</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="w3-container" style="display: flex; justify-content: space-between;">
                                    <div class="w3-container-inner">
                                        <span>Easy</span>
                                        <span class="container-element"><?= htmlentities($totalGamesEasy) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Medium</span>
                                        <span class="container-element"><?= htmlentities($totalGamesMedium) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Hard</span>
                                        <span class="container-element"><?= htmlentities($totalGamesHard) ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:12px;padding:5px">
                                <i class="ri-history-fill" style="font-weight:900;font-size:12px"></i>
                                <span>High Scores</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="w3-container" style="display: flex; justify-content: space-between;">
                                    <div class="w3-container-inner">
                                        <span>Easy</span>
                                        <span class="container-element"><?= htmlentities($highScoreEasy) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Medium</span>
                                        <span class="container-element"><?= htmlentities($highScoreMedium) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Hard</span>
                                        <span class="container-element"><?= htmlentities($highScoreHard) ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="display: flex; align-items: center;position:relative">
                                <i class="ri-percent-fill" style="margin-right: 5px;"></i>
                                <span style="margin-right: 10px;">Input Accuracy</span>
                                <h2 style="     margin: 0;
                                                font-size: 20px;
                                                float: right;
                                                position: absolute;
                                                right: 0;
                                                margin-right: 20px;
                                                "><?= htmlentities($wpm) ?>%</h2>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

        <div class="w3-container w3-half">
            <div class="w3-container button-container" style="margin-top:0px">

                <button id="menuPlayButton" onclick="startGame()" style="margin-top:0px">
                    <i class="ri-play-fill"></i>
                    <span>START GAME</span>
                </button>

                <div style="display: flex; justify-content: space-between;">
                    <button id="menuSignInButton" style="flex: 1; margin-right: 5px;" onclick="homeMenu()">
                        <i style="font-weight:900" class="ri-arrow-go-back-fill"></i>
                        <span style="font-size:20px;vertical-align: text-top;">BACK</span>
                    </button>
                    <button id="menuConfigButton"
                        style="flex: 1; margin-left: 5px;opacity:10%;pointer-events:none;opacity:0%!important;pointer-events:none!important"
                        onclick="viewData()">
                        <i style="font-weight:900" class="ri-arrow-go-back-fill"></i>
                        <span style="font-size:20px;vertical-align: text-top;">BACK</span>
                    </button>
                </div>

            </div>
        </div>

    </body>


    <script>
        window.onload = function () {
            document.body.style.opacity = "100%";
        }

        function homeMenu() {
            window.location.href = "Index.php";
        }

        function startGame() {
            setTimeout(() => window.location.href = 'game.php', 1);
        }

    </script>
</body>

</html>