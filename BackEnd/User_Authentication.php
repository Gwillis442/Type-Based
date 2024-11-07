<?php
/*
    by: Chan Rain, Garrett Willis, Kevin Tieu
    last modified: 11/6/2024 
*/
require_once("hum_conn_no_login.php");


    function user_Authentication($conn, $username, $password)
    {
        $query = 'SELECT * FROM users WHERE username = :username AND password = :password';
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':username', $username);
        oci_bind_by_name($stmt, ':password', $password);
        oci_execute($stmt, OCI_DEFAULT);
        $row = oci_fetch_assoc($stmt);
        if($row)
        {
            return true;
        }
        return false;
    }


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $conn = hum_conn_no_login();
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(user_Authentication($conn, $username, $password))
    {
        echo "Welcome $username";
    } else {
        echo "Invalid username or password";
    }

    oci_close($conn);
}


?>

