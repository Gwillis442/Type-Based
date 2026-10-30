<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * csrf.php
 * Issues and checks a per-session form token.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

function csrf_check()
{
    $sent = $_POST['csrf_token'] ?? '';
    $saved = $_SESSION['csrf_token'] ?? '';
    return $sent !== '' && hash_equals($saved, $sent);
}
