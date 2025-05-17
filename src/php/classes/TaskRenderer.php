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
        /* JSON_HEX_TAG escapes <> and JSON_HEX_QUOT escapes double quotes
        used here to prevent the program breaking */
        $id = (int)$task['id'];
        $title = json_encode($task['title'],JSON_HEX_TAG | JSON_HEX_QUOT);
        $desc = json_encode($task['description'],JSON_HEX_TAG | JSON_HEX_QUOT);
        $status = json_encode((string)$task['is_completed'],JSON_HEX_TAG | JSON_HEX_QUOT);// Cast to string for form
        $due = json_encode($task['due_date'],JSON_HEX_TAG | JSON_HEX_QUOT);
        $priority = json_encode($task['task_priority'],JSON_HEX_TAG | JSON_HEX_QUOT);

        $onclick= "openEditForm($id, $title, $desc, $status, $due, $priority)";
        $safeOnclick = htmlspecialchars($onclick, ENT_QUOTES, 'UTF-8');

        // the "\" in "<button onclick=\"$safeOnclick\" treats safeOnClick as part of the string
        return "<button onclick=\"$safeOnclick\" class='text-blue-500 hover:text-blue-700'><i class='fa-solid fa-pen'></i></button>";
    }

    // delete button, pops a confirmation for the user before deletion
   public static function renderDeleteButton($taskID) {
    return 
    '<form onsubmit="handleDelete(event)" style="display:inline;">
        <input type="hidden" name="task_id" value="' . htmlspecialchars($taskID) . '">
        <button type="submit" class="text-red-500 hover:text-red-700">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>';
    }
}
?>
