<?php
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bugTitle = $_POST['title'] ?? '';
    $bugComment = $_POST['comment'] ?? '';
    $bugUrgency = $_POST['urgency'] ?? '';
    
    require_once 'db.php';
    
    $db = new Database();
    // var_dump($db); die();
    $insertId = $db->insert("bugs", [
                    "title" => $bugTitle,
                    "comment" => $bugComment,
                    "urgency" => $bugUrgency,
                    "status" => "open"
                ]);
    $db->close();
    
    // echo "<div id='response'>Bug reported successfully! id ".md5($insertId)."</div>";
    echo md5($insertId);
}
?>