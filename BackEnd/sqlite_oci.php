<?php
/*
 * by: Chan Rain, Garrett Willis, Kevin Tieu
 * Type-Based
 *
 * sqlite_oci.php
 * Lets the existing Oracle-style calls run against the local SQLite file.
 */
if (!defined("OCI_DEFAULT")) {
    define("OCI_DEFAULT", 0);
}
if (!defined("OCI_COMMIT_ON_SUCCESS")) {
    define("OCI_COMMIT_ON_SUCCESS", 1);
}

class LocalStatement
{
    public $sql;
    public $binds = [];
    public $error = null;
    public $row = null;
    public $pdo;
    public $stmt;

    function __construct($pdo, $sql)
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
    }
}

function oci_parse($conn, $sql)
{
    return new LocalStatement($conn, $sql);
}

function oci_bind_by_name($stmt, $name, &$value)
{
    $stmt->binds[$name] = &$value;
    return true;
}

function oci_execute($stmt, $mode = 0)
{
    try {
        $stmt->stmt = $stmt->pdo->prepare($stmt->sql);
        foreach ($stmt->binds as $name => &$value) {
            $stmt->stmt->bindValue($name, $value);
        }
        $ok = $stmt->stmt->execute();
        $stmt->row = $stmt->stmt->fetch(PDO::FETCH_ASSOC);
        return $ok;
    } catch (Exception $e) {
        $stmt->error = $e->getMessage();
        return false;
    }
}

function oci_fetch_assoc($stmt)
{
    if (!$stmt->row) {
        return false;
    }
    $upper = [];
    foreach ($stmt->row as $key => $value) {
        $upper[strtoupper($key)] = $value;
    }
    $stmt->row = $stmt->stmt->fetch(PDO::FETCH_ASSOC);
    return $upper;
}

function oci_error($stmt = null)
{
    $message = ($stmt && $stmt->error) ? $stmt->error : "database error";
    return ["message" => $message];
}

function oci_close($conn)
{
    return true;
}
