<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * user_Stats.php
 * Shows the signed-in player's scores, games played, and accuracy.
 */
session_start();
require_once("../BackEnd/hum_conn_no_login.php");
ini_set('display_errors', 0);

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
    <style>html, body { opacity: 1 !important; background: #f2f3f5; }</style>
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

<body style="opacity: 1;">
    <?php
    /*
     * Loads one player's saved stats.
     * conn - the database connection
     * user_id - the player id
     * return the stats row, or false
     */
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

    $user_id = $_SESSION['user_id'] ?? 0;
    $username = $_SESSION['username'] ?? 'Guest';
    $user_stats = [];
    $conn = null;
    try {
        $conn = hum_conn_no_login();
        $loaded = get_user_stats($conn, $user_id);
        if (is_array($loaded)) {
            $user_stats = $loaded;
        }
    } catch (Throwable $e) {
        $user_stats = [];
    }

    // Assign variables
    $totalGamesEasy = $user_stats['TOTAL_GAMES_EASY'] ?? 'N/A';
    $totalGamesMedium = $user_stats['TOTAL_GAMES_MEDIUM'] ?? 'N/A';
    $totalGamesHard = $user_stats['TOTAL_GAMES_HARD'] ?? 'N/A';
    $highScoreEasy = $user_stats['HIGH_SCORE_EASY'] ?? 'N/A';
    $highScoreMedium = $user_stats['HIGH_SCORE_MEDIUM'] ?? 'N/A';
    $highScoreHard = $user_stats['HIGH_SCORE_HARD'] ?? 'N/A';
    $wpm = $user_stats['WPM'] ?? 'N/A';
    $accuracyEasy = $user_stats['ACCURACY_EASY'] ?? 'N/A';
    $accuracyMedium = $user_stats['ACCURACY_MEDIUM'] ?? 'N/A';
    $accuracyHard = $user_stats['ACCURACY_HARD'] ?? 'N/A';
    ?>
    <?php
    if ($conn) {
        oci_close($conn);
    }
    ?>

    <body>

        <div class="w3-container w3-half">
            <div class="w3-container config-container">
                <h2 class="containerTitle">USER STATS</h2>
                <h2 id="username">
                    <i class="ri-user-3-fill"></i>
                    <?= htmlentities($username) ?>
                </h2>
                <?php if ($user_id == 0) { ?>
                    <p id="noUserNote">No user found.</p>
                <?php } ?>
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
                                        <span class="container-element" id="gamesEasy"><?= htmlentities($totalGamesEasy) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Medium</span>
                                        <span class="container-element" id="gamesMedium"><?= htmlentities($totalGamesMedium) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Hard</span>
                                        <span class="container-element" id="gamesHard"><?= htmlentities($totalGamesHard) ?></span>
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
                                        <span class="container-element" id="scoreEasy"><?= htmlentities($highScoreEasy) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Medium</span>
                                        <span class="container-element" id="scoreMedium"><?= htmlentities($highScoreMedium) ?></span>
                                    </div>
                                    <div class="w3-container-inner">
                                        <span>Hard</span>
                                        <span class="container-element" id="scoreHard"><?= htmlentities($highScoreHard) ?></span>
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
                                                " id="accuracyValue"><?= htmlentities($wpm) ?>%</h2>
                            </td>
                        </tr>
                        <tr>
                            <td style="display: flex; align-items: center;position:relative">
                                <i class="ri-close-circle-line" style="margin-right: 5px;"></i>
                                <span style="margin-right: 10px;">Wrong Keys Pressed</span>
                                <h2 style="margin: 0; font-size: 20px; position: absolute; right: 0; margin-right: 20px;" id="wrongKeysValue">0</h2>
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


        /*
         * Deletes the temporary guest round.
         * return nothing
         */
        function clearGuestRound() {
            localStorage.removeItem("guestRound");
        }

        /*
         * Shows the guest round in the stats table.
         * return nothing
         */
        function showGuestRound() {
            var raw = localStorage.getItem("guestRound");
            if (!raw || !document.getElementById("noUserNote")) return;
            var round = JSON.parse(raw);
            var mode = round.mode || "easy";
            var games = document.getElementById("games" + mode.charAt(0).toUpperCase() + mode.slice(1));
            var high = document.getElementById("score" + mode.charAt(0).toUpperCase() + mode.slice(1));
            if (games) games.textContent = "1";
            if (high) high.textContent = round.score;
            var accuracy = document.getElementById("accuracyValue");
            if (accuracy) accuracy.textContent = round.accuracy + "%";
            var wrong = document.getElementById("wrongKeysValue");
            if (wrong) wrong.textContent = round.wrongKeys || 0;
        }
        showGuestRound();

        /*
         * Returns to the main menu and clears the guest round.
         * return nothing
         */
        function homeMenu() {
            leaving = true;
            clearGuestRound();
            window.location.href = "../Index.php";
        }

        var leaving = false;

        /*
         * Starts a round: picks a word and sends the letters in order.
         * return nothing
         */
        function startGame() {
            leaving = true;
            clearGuestRound();
            setTimeout(() => window.location.href = 'game.php', 1);
        }


    </script>
</body>

</html>