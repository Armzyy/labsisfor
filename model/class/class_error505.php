<?php
include "config.php";

function showerror505()
{
    $errorcode = $_GET['err'];
    if ($errorcode == 1049) {
        echo "<p>SQLSTATE[HY000] [1049] Unknown database.</p>";
    } else if ($errorcode == 2002) {
        echo "<p>SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for localhos failed: No such host is known.</p>";
    } else if ($errorcode == 1045) {
        echo "<p>SQLSTATE[HY000] [1045] Access denied for user.</p>";
    } else {
        echo "<p>SQLSTATE[HY000] [" . $errorcode . "] No such of code.</p>";
    }
}
