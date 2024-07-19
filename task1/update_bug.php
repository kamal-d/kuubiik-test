<?php
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $engComment = $_POST['engComment'] ?? '';
    $bugStatus = $_POST['bugStatus'] ?? '';
    $bugId = $_POST['bugId'] ?? '';
    
    require_once 'db.php';
    
    $db = new Database();
    $insertId = $db->update("bugs", [
                    "status" => $bugStatus,
                    "engineer_comment" => $engComment
                ], "id =".$bugId);
    $db->close();
    echo $bugId;
}
?>