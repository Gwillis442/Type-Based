<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * reset_request.php
 * Accepts a password reset request for an existing username.
 */

session_start();
require_once("../BackEnd/hum_conn_no_login.php");

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    if ($username) {
        $message = "Reset request recorded for " . htmlentities($username) . ".";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset password</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <h1>Reset password</h1>
    <form method="post">
        <label>Username <input type="text" name="username" required></label>
        <button type="submit">Request reset</button>
    </form>
    <p><?php echo $message; ?></p>
    <p><a href="../Index.php">Back</a></p>
</body>
</html>
