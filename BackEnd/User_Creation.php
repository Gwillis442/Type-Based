<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * User_Creation.php
 * Creates a profile, account, stats row, and default config for a new player.
 */
session_start();
require_once("hum_conn_no_login.php");
require_once("csrf.php");
ini_set('display_errors', 0);

function create_User($conn, $username, $password, $email, $first_name, $last_name)
{
    $user_id = uniqid();

    $check_query = 'SELECT COUNT(*) AS count FROM user_account WHERE username = :username';
    $check_stmt = oci_parse($conn, $check_query);
    oci_bind_by_name($check_stmt, ':username', $username);
    oci_execute($check_stmt);
    $row = oci_fetch_assoc($check_stmt);

    if ($row && $row['COUNT'] > 0) {
        return "Username already exists. Please choose a different username.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_profile_query = 'INSERT INTO user_profile (user_id, first_name, last_name, email) VALUES (:user_id, :first_name, :last_name, :email)';
    $insert_profile_stmt = oci_parse($conn, $insert_profile_query);
    oci_bind_by_name($insert_profile_stmt, ':user_id', $user_id);
    oci_bind_by_name($insert_profile_stmt, ':first_name', $first_name);
    oci_bind_by_name($insert_profile_stmt, ':last_name', $last_name);
    oci_bind_by_name($insert_profile_stmt, ':email', $email);

    if (!oci_execute($insert_profile_stmt, OCI_COMMIT_ON_SUCCESS)) {
        $e = oci_error($insert_profile_stmt);
        return "Error creating user profile: " . htmlentities($e['message']);
    }

    $insert_stats_query = 'INSERT INTO typing_stats (user_id, wpm, total_games_easy, total_games_medium, total_games_hard, high_score_easy, high_score_medium, high_score_hard) VALUES (:user_id, 0, 0, 0, 0, 0, 0, 0)';
    $insert_stats_stmt = oci_parse($conn, $insert_stats_query);
    oci_bind_by_name($insert_stats_stmt, ':user_id', $user_id);

    if (!oci_execute($insert_stats_stmt, OCI_COMMIT_ON_SUCCESS)) {
        $e = oci_error($insert_stats_stmt);
        return "Error entering typing stats: " . htmlentities($e['message']);
    }

    $insert_config_query = 'INSERT INTO user_config (user_id, default_mode, sound, music, play_history) VALUES (:user_id, :default_mode, 1, 1, 1)';
    $insert_config_stmt = oci_parse($conn, $insert_config_query);
    $default_mode = 'easy';
    oci_bind_by_name($insert_config_stmt, ':user_id', $user_id);
    oci_bind_by_name($insert_config_stmt, ':default_mode', $default_mode);

    if (!oci_execute($insert_config_stmt, OCI_COMMIT_ON_SUCCESS)) {
        $e = oci_error($insert_config_stmt);
        return "Error creating user config: " . htmlentities($e['message']);
    }

    $insert_account_query = 'INSERT INTO user_account (user_id, username, password) VALUES (:user_id, :username, :password)';
    $insert_account_stmt = oci_parse($conn, $insert_account_query);
    oci_bind_by_name($insert_account_stmt, ':user_id', $user_id);
    oci_bind_by_name($insert_account_stmt, ':username', $username);
    oci_bind_by_name($insert_account_stmt, ':password', $hashed_password);

    if (oci_execute($insert_account_stmt, OCI_COMMIT_ON_SUCCESS)) {
        return true;
    }

    $e = oci_error($insert_account_stmt);
    return "Error creating user account: " . htmlentities($e['message']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!csrf_check()) {
        http_response_code(403);
        exit;
    }

    $conn = hum_conn_no_login();

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);

    $create = create_User($conn, $username, $password, $email, $first_name, $last_name);

    if ($create === true) {
        $query = 'SELECT user_id FROM user_account WHERE username = :username';
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row) {
            $_SESSION['user_id'] = $row['USER_ID'];
            $_SESSION['username'] = $username;
        }

        echo '<script>
                alert("User created successfully!");
                window.location.href = "../Index.php";
              </script>';
    } else {
        $safe = addslashes($create);
        echo "<script>alert('Error creating user: $safe');</script>";
    }

    oci_close($conn);
}
?>
