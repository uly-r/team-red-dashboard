<?php
require_once '../../php/includes/db_connect.php';
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $taskID = $_POST['task_id'];

    try {
        // delete if it belongs to the logged-in user
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $taskID, $user_id);
        $stmt->execute();

        //goes back to the previous page
        echo "
            <script>
                alert('Task deleted');
                window.location.href = '" . $_SERVER['HTTP_REFERER'] . "'; 
            </script>
        ";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    //goes back to the previous page with an error alert
    echo "
        <script>
            alert('An error has occured.');
            window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
        </script>
    ";
}
?>
