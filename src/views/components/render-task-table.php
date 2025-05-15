<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';
require_once __DIR__ . '/../../php/classes/TaskManager.php';
require_once __DIR__ . '/../../php/classes/TaskRenderer.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];


$taskManager = new TaskManager($conn, $user_id);
//filter is what the user selects, default is all
$tasks = $taskManager->fetchUserTasksByFilter($_GET['filter'] ?? 'all');

while ($row = $tasks->fetch_assoc()) {
    $isCompleted = (int)$row['is_completed'];
    echo "<tr>
        <td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['title']) . "</td>
        <td class='px-6 py-4'>" . htmlspecialchars($row['description']) . "</td>
        <td class='px-6 py-4'>" . htmlspecialchars($row['due_date']) . "</td>
        <td class='px-6 py-4'>
            <span class='inline-block px-2 py-1 text-sm rounded " . 
                ($isCompleted ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . "'>" .
                TaskRenderer::getStatusLabel($isCompleted) .
            "</span>
        </td>
        <td class='px-6 py-4'>" . TaskRenderer::getPriorityLabel($row['task_priority']) . "</td>
        <td class='px-6 py-4 space-x-2'>";
            if (!$isCompleted) {
                echo TaskRenderer::renderEditButton($row);
            }
            echo TaskRenderer::renderDeleteButton($row['id']);
    echo "</td></tr>";
}
?>
