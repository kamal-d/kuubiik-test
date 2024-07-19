<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
require_once 'db.php';
$db = new Database();
while (true) {
    $bugs = $db->select("bugs", "*", "status = 'closed'");
    $response = [];
    foreach ($bugs as $bug) {
        $response[] = md5($bug['id']);
    }
    echo "data: " . json_encode($response) . "\n\n";
    if (ob_get_contents()) {
        ob_end_flush();
    }
    flush();
    sleep(5);
}