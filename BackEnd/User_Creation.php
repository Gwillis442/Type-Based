<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/13/2024 
*/
session_start();
require_once("hum_conn_no_login.php");
ini_set('display_errors', 1);

function create_User($conn, $username, $password, $email, $first_name, $last_name)
{
    //Generate a unique user_id
    $user_id = uniqid();
    // Check if the username already exists
    $check_query = 'SELECT COUNT(*) AS count FROM user_account WHERE username = :username';
    $check_stmt = oci_parse($conn, $check_query);
    oci_bind_by_name($check_stmt, ':username', $username);
    oci_execute($check_stmt);
    $row = oci_fetch_assoc($check_stmt);

    if ($row['COUNT'] > 0) {
        return "Username already exists. Please choose a different username.";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the user_profile table
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

    // Insert the new user into the user_account table
    $insert_account_query = 'INSERT INTO user_account (user_id, username, password) VALUES (:user_id, :username, :password)';
    $insert_account_stmt = oci_parse($conn, $insert_account_query);
    oci_bind_by_name($insert_account_stmt, ':user_id', $user_id);
    oci_bind_by_name($insert_account_stmt, ':username', $username);
    oci_bind_by_name($insert_account_stmt, ':password', $hashed_password);

    if (oci_execute($insert_account_stmt, OCI_COMMIT_ON_SUCCESS)) {
        return true;
    } else {
        $e = oci_error($insert_account_stmt);
        return false;
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = hum_conn_no_login();

    // Retrieve and sanitize form data
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);

    // Create the user
    $create = create_user($conn, $username, $password, $email, $first_name, $last_name);
    if ($create === true) {
        $_SESSION['username'] = $username; // Set session variable
        echo '<script>
                alert("User created successfully!");
                window.location.href = "../Index.php";
            </script>';

    } else {
        echo "<script>

            alert('Error creating user: $create');
            </script>";
    }

    // Close the connection
    oci_close($conn);
}
?>