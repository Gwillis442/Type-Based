<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/7/2024 
*/
session_start();
require_once("hum_conn_no_login.php");
ini_set('display_errors', 1);

    function user_Authentication($conn, $username, $password)
    {
        $query = 'SELECT * FROM user_account WHERE username = :username AND password = :password';
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_bind_by_name($stmt, ':password', $password);
        oci_execute($stmt, OCI_DEFAULT);
        $row = oci_fetch_assoc($stmt);
        if ($row) {
            return true; // User found
        } else {
            return false; // User not found
        }
    }


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $conn = hum_conn_no_login();
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(user_Authentication($conn, $username, $password))
    {
        $_SESSION['username'] = $username; // Set session variable
        header("Location: ../Index.php"); // Redirect to Index.php
        exit();
    } else {
        echo "Invalid username or password";
    }

    oci_close($conn);
}


?>
