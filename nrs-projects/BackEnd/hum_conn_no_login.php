<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * hum_conn_no_login.php
 * Opens the Humboldt Oracle connection used on nrs-projects.
 * This file lived at BackEnd/hum_conn_no_login.php.
 */
    function hum_conn_no_login()
    {
        $os_username = substr($_SERVER["CONTEXT_PREFIX"], 2);
        $ora_php_username = "{$os_username}_php";
        $conn_username = "{$ora_php_username}[{$os_username}]";
        $ora_php_password = trim(file_get_contents("/home/{$os_username}/.oraauth"));
        $connectn = oci_connect($conn_username, $ora_php_password, null, "AL32UTF8", OCI_DEFAULT);
        if (! $connectn)
        {
            ?>
            <p> Could not log into Oracle, sorry! </p>
            <?php
            require_once("328footer-plus-end.html");
            exit;
        }
        return $connectn;
    }
?>
