<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * User_Authentication.php
 * Checks a username and password and starts a session on success.
 */
session_start();
require_once("hum_conn_no_login.php");
ini_set('display_errors', 0);

function user_Authentication($conn, $username, $password)
{
    $query = 'SELECT password FROM user_account WHERE username = :username';
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':username', $username);

    if (!oci_execute($stmt, OCI_DEFAULT)) {
        return false;
    }

    $row = oci_fetch_assoc($stmt);
    if (!$row) {
        return false;
    }

    return password_verify($password, $row['PASSWORD']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = hum_conn_no_login();
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (user_Authentication($conn, $username, $password)) {
        $query = 'SELECT user_id FROM user_account WHERE username = :username';
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $row['USER_ID'];
            $_SESSION['username'] = $username;
            header("Location: ../Index.php");
            exit();
        }
    }

    $_SESSION['login_failed'] = true;
    header("Location: ../Index.php");
    exit();
}
?>
