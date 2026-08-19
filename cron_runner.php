<?php
// Standalone Cron Runner Endpoint
define('CRON_SECRET_TOKEN', 'labsisfor_cron_secret_key_2026');

$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($token) || !hash_equals(CRON_SECRET_TOKEN, $token)) {
    http_response_code(403);
    die("Access denied: Invalid or missing token.");
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/model/class/cron.php';

echo "Cron job executed successfully at " . date('Y-m-d H:i:s');
?>
