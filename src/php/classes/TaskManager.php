<?php
class TaskManager {
    private $conn;
    private $user_id;

    public function __construct($conn, $user_id) {
        $this->conn = $conn;
        $this->user_id = $user_id;
    }

    public function addTask($post) {
        //Add or remove fields more easily
        $fields = [
        //Left is the actual name of the column, middle is the values from _POST, right is default values (error case) 
            'user_id'       => $this->user_id,
            'title'         => $post['task_name'] ?? 'dflt',
            'description'   => $post['task_description'] ?? 'dflt',
            'due_date'      => $post['date_due'] ?? 'dflt',
            'is_completed'  => $post['task_status'] ?? 0,
            'task_priority' => $post['taskPriority'] ?? 1
        ];

         //This gets the key of the array, so the left side of $fields
        $columns = array_keys($fields);

        //Creates an array of '?' for the size of $fields
        $placeholders = array_fill(0, count($fields), '?');

        //extracts the values of the array (right hand of $fields (information from _POST))
        $values = array_values($fields);

        //goes through the array $values, then returns either i if its a numeric type otherwise returns a string, used for binding
        $types = implode('', array_map(fn($v) => is_numeric($v) ? 'i' : 's', $values));

        //makes an SQL stmt with the column names, and the amount of placeholders from earlier
        $sql = "INSERT INTO tasks (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        //types is the expected type ex: isssii,  "..." unpacks the information from values
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

  public function deleteTask($task_id) {
    $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $this->user_id);
    $stmt->execute();
    $deleted = $stmt->affected_rows > 0;    //checks to see if something was deleted or not
    $stmt->close();
    return $deleted;   //returns the value true or false
        }

    public function updateTask($post) {
        if (!isset($post['task_id'])) return false;
        $task_id = $post['task_id'];

        //Add or remove fields more easily
        $fields = [
        //Left is the actual name of the column, middle is the values from _POST, right is default values (error case) 
            'user_id'       => $this->user_id,
            'title'         => $post['task_name'] ?? 'dflt',
            'description'   => $post['task_description'] ?? 'dflt',
            'due_date'      => $post['date_due'] ?? 'dflt',
            'is_completed'  => $post['task_status'] ?? 0,
            'task_priority' => $post['taskPriority'] ?? 1
        ];

        $set_clause = [];
        $values = [];
        $types = '';

        foreach ($fields as $col => $val) {
            //save left side of $fields
            $set_clause[] = "$col = ?";
            //the information from $_POST
            $values[] = $val;
            // save the type, used to bind the expected type
            $types .= is_numeric($val) ? 'i' : 's';
        }

        // Add the WHERE condition values
        $values[] = $task_id;
        $values[] = $this->user_id;
        $types .= 'ii';

        //makes an SQL stmt with the column names ex:  title = ?, description = ?, due_date = ?, is_completed = ?, task_priority = ?
        $sql = "UPDATE tasks SET " . implode(', ', $set_clause) . " WHERE id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function fetchUserTasks() {
        // gets all the data from the logged in user
        $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function fetchUserTasksByFilter($filter = 'all') {
        //switch is used by the script in view mode to execute the filter
        switch ($filter) {
            case 'completed':
                $sql = "SELECT * FROM tasks WHERE user_id = ? AND is_completed = 1";
                break;
            case 'not_completed':
                $sql = "SELECT * FROM tasks WHERE user_id = ? AND is_completed = 0";
                break;
            default:
                $sql = "SELECT * FROM tasks WHERE user_id = ?";
                break;
        }

        //executes the corresponding statment
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>