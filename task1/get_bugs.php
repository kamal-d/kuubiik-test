<?php
    require_once 'db.php';
    $db = new Database();
    $bugs = $db->select("bugs");
    $db->close();

    $html = '<table class="table-auto">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th class="px-4 py-2">Title</th>';
    $html .= '<th class="px-4 py-2">Comment</th>';
    $html .= '<th class="px-4 py-2">Urgency</th>';
    $html .= '<th class="px-4 py-2">Status</th>';
    $html .= '<th class="px-4 py-2">Actions</th>'; 
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';
    foreach ($bugs as $bug) {
        $html .= '<tr>';
        $html .= '<td class="border px-4 py-2">' . $bug['title'] . '</td>';
        $html .= '<td class="border px-4 py-2">' . $bug['comment'] . '</td>';
        $html .= '<td class="border px-4 py-2">' . $bug['urgency'] . '</td>';
        $html .= '<td class="border px-4 py-2">' . $bug['status'] . '</td>';
        $html .= '<td class="border px-4 py-2"><button class="bug">Update</button></td>'; 
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';

    echo $html;
?>