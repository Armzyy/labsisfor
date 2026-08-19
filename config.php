<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// masukkan DB
$servername = "localhost";
$database = "labsisfor";
$username = "root";
$password = "";

try {
    $db = @mysqli_connect($servername, $username, $password, $database);
    if (!$db) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $errordb) {
    $errordatabase = $errordb->getMessage();

    $_SESSION['dberror'] = $errordatabase;

    if (strpos($errordatabase, "1049") !== false) {
        header('location: 505?err=DB-error-1049&msg=' . urlencode($errordatabase) . '&php=' . phpversion());
    } else if (strpos($errordatabase, "2002") !== false) {
        header('location: 505?DB-error-err=2002&msg=' . urlencode($errordatabase) . '&php=' . phpversion());
    } else if (strpos($errordatabase, "1045") !== false) {
        header('location: 505?DB-error-err=1045&msg=' . urlencode($errordatabase) . '&php=' . phpversion());
    } else {
        header('location: 505?DB-error-err=1045&msg=' . urlencode($errordatabase) . '&php=' . phpversion());
    }
    exit();
}

date_default_timezone_set("Asia/Jakarta");
$jamsaatini = date('H:i:s A');

include 'model/class/SQLGLOBAL.php';
include_once 'model/class/SQLFUNCTIONGLOBAL.php';
include 'model/class/ALERTGLOBAL.php';
include_once 'model/class/FUNCTIONSGLOBAL.php';

if (isset($_SESSION['session_username'])) {
    $S_username = $_SESSION['session_username'];
    $S_rolestatus = $_SESSION['session_role'];
}
