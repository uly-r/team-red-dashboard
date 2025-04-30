<?php
require_once __DIR__ . '../../../includes/db_connect.php';
function getUserQuickLinks($user_id) {
    global $conn;
    $sql = "SELECT * FROM quick_links WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error); // Log error
        return []; // Silent return
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $links = [];
    while ($row = $result->fetch_assoc()) {
        $links[] = $row;
    }
    $stmt->close();
    return $links;
}