<?php
require_once("./hum_conn_no_login.php");

function create_user($conn, $username, $password, $email)
{
    // Check if the username already exists
    $check_query = 'SELECT COUNT(*) AS count FROM user_account WHERE user_name = :username';
    $check_stmt = oci_parse($conn, $check_query);
    oci_bind_by_name($check_stmt, ':username', $username);
    oci_execute($check_stmt);
    $row = oci_fetch_assoc($check_stmt);

    if ($row['COUNT'] > 0) {
        return "Username already exists. Please choose a different username.";
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $insert_query = 'INSERT INTO user_account (user_name, password, email) VALUES (:username, :password, :email)';
    $insert_stmt = oci_parse($conn, $insert_query);
    oci_bind_by_name($insert_stmt, ':username', $username);
    oci_bind_by_name($insert_stmt, ':password', $hashed_password);
    oci_bind_by_name($insert_stmt, ':email', $email);

    if (oci_execute($insert_stmt, OCI_COMMIT_ON_SUCCESS)) {
        return "Account created successfully!";
    } else {
        $e = oci_error($insert_stmt);
        return "Error creating account: " . htmlentities($e['message']);
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = hum_conn_no_login();

    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);

    // Create the user
    $message = create_user($conn, $username, $password, $email);
    echo "<p>$message</p>";

    // Close the connection
    oci_close($conn);
}
?>