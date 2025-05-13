<?php
class TaskRenderer {
    public static function getStatusLabel($is_completed) {
        //converts 0 or 1 to completed(1) or not completed(0)
        return $is_completed == 1 ? 'Completed' : 'Not Completed';
    }

    public static function getPriorityLabel($priority) {
        //converts int to string
        return match ($priority) {
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            default => 'Unknown'
        };
    }

    public static function renderEditButton($task) {
        //this loads the current task information into the form
        $id = (int)$task['id'];
        $title = json_encode($task['title']);
        $desc = json_encode($task['description']);
        $status = json_encode((string)$task['is_completed']);// Cast to string for form
        $due = json_encode($task['due_date']);
        $priority = json_encode($task['task_priority']);

        return "
            <button onclick='openEditForm($id, $title, $desc, $status, $due, $priority)'
                class='text-blue-500 hover:text-blue-700'>
                <i class='fa-solid fa-pen'></i>
            </button>";
    }

    // delete button, pops a confirmation for the user before deletion
    public static function renderDeleteButton($taskID) {
        return '
            <form action="components/delete-task.php" method="POST" style="display:inline;">
                <input type="hidden" name="task_id" value="' . htmlspecialchars($taskID) . '">
                <button type="submit" onclick="return confirm(\'Delete this task?\');" 
                    class="text-red-500 hover:text-red-700">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>';
    }
}
?>
