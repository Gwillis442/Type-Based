<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * set_User_Stats.php
 * Updates high score, games played, and accuracy for the signed-in player.
 */
session_start();
require_once("./hum_conn_no_login.php");
ini_set('display_errors', 1);

function check_high_score($conn, $user_id, $score, $difficulty)
{
    $query = '
        SELECT high_score_easy, high_score_medium, high_score_hard
        FROM typing_stats
        WHERE user_id = :user_id';

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);

    if (!oci_execute($stmt)) {
        return false;
    }

    $row = oci_fetch_assoc($stmt);
    if (!$row) {
        return false;
    }

    if ($difficulty === 'easy' && $score > $row['HIGH_SCORE_EASY']) {
        return true;
    }
    if ($difficulty === 'medium' && $score > $row['HIGH_SCORE_MEDIUM']) {
        return true;
    }
    if ($difficulty === 'hard' && $score > $row['HIGH_SCORE_HARD']) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        exit;
    }

    $conn = hum_conn_no_login();
    $user_id = $_SESSION['user_id'];
    $score = filter_input(INPUT_POST, 'score', FILTER_VALIDATE_INT);
    $wpm = filter_input(INPUT_POST, 'wpm', FILTER_VALIDATE_INT);
    $difficulty = strtolower(trim($_POST['difficulty'] ?? ''));

    // Normalize possible values
    if ($difficulty === 'med' || $difficulty === 'medium') {
        $difficulty = 'medium';
    } elseif ($difficulty === 'easy') {
        $difficulty = 'easy';
    } elseif ($difficulty === 'hard') {
        $difficulty = 'hard';
    } else {
        error_log("Rejected invalid difficulty: " . $difficulty);
        http_response_code(400);
        exit;
    }

    if ($score === false || $score === null) {
        $score = 0;
    }
    if ($wpm === false || $wpm === null) {
        $wpm = 0;
    }

    if (check_high_score($conn, $user_id, $score, $difficulty)) {
        $update_query = 'UPDATE typing_stats SET high_score_' . $difficulty . ' = :score WHERE user_id = :user_id';
        $update_stmt = oci_parse($conn, $update_query);
        oci_bind_by_name($update_stmt, ':score', $score);
        oci_bind_by_name($update_stmt, ':user_id', $user_id);
        oci_execute($update_stmt);
    }

    $increment_query = 'UPDATE typing_stats SET total_games_' . $difficulty . ' = total_games_' . $difficulty . ' + 1 WHERE user_id = :user_id';
    $increment_stmt = oci_parse($conn, $increment_query);
    oci_bind_by_name($increment_stmt, ':user_id', $user_id);
    oci_execute($increment_stmt);

    $wpm_query = 'UPDATE typing_stats SET wpm = :wpm WHERE user_id = :user_id';
    $wpm_stmt = oci_parse($conn, $wpm_query);
    oci_bind_by_name($wpm_stmt, ':user_id', $user_id);
    oci_bind_by_name($wpm_stmt, ':wpm', $wpm);
    oci_execute($wpm_stmt);


    $acc_query = 'UPDATE typing_stats SET accuracy_' . $difficulty . ' = :accuracy, avg_wpm_' . $difficulty . ' = :wpm WHERE user_id = :user_id';
    $acc_stmt = oci_parse($conn, $acc_query);
    oci_bind_by_name($acc_stmt, ':accuracy', $wpm);
    oci_bind_by_name($acc_stmt, ':wpm', $wpm);
    oci_bind_by_name($acc_stmt, ':user_id', $user_id);
    oci_execute($acc_stmt);

    oci_close($conn);
}
?>
