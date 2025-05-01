<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.html"); // adjust path if needed
    exit();
}
require_once '../php/includes/db_connect.php';
$user_id = $_SESSION['user_id'];

function renderDeleteButton($taskID)
{
    /*
     this shows the delete button which when clicked, pops up an alert
     which then the user confirms to delete their task
     the request is then sent to delete-task.php
*/
    return '
        <form action="components/delete-task.php" method="POST">
            <input type="hidden" name="task_id" value="' . htmlspecialchars($taskID) . '">
            <button type="submit" onclick="return confirm(\'Delete this task?\');">Delete</button>
        </form>
    ';
}

function getTaskStatusLabel($taskStatus)
{
    //convert 0 or 1 to completed or not completed status
    return $taskStatus == 1 ? 'Completed' : 'Not Completed';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task page</title>
</head>

<body>

    <div class="bg-white rounded-xl p-4 shadow flex flex-col items-start">
        <div>
            <h2>Task Tracker</h2>
        </div>

        <div>
            <!--Start of table-->
            <table class="table table-striped table-hover" id="taskTable"> <!--Add later-->
                <thead>
                    <tr>
                        <th scope="col">Task Name</th>
                        <th scope="col">Task Description</th>
                        <th scope="col">Date Due</th>
                        <th scope="col">Task Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //get the users tasks using their user_id
                    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    //prints out tasks
                    while ($row = $result->fetch_assoc()) {
                        $taskID = $row['id'];
                        $taskName = $row['title'];
                        $taskDesc = $row['description'];
                        $dateDue = $row['due_date'];
                        $taskStatus = $row['is_completed'];
                    ?>
                        <!-- This is the row that is printed for each task-->
                        <tr>
                            <td id="taskName-<?= $taskID ?>"><?= htmlspecialchars($taskName) ?></td>
                            <td id="taskDesc-<?= $taskID ?>"><?= htmlspecialchars($taskDesc) ?></td>
                            <td id="dateDue-<?= $taskID ?>"><?= htmlspecialchars($dateDue) ?></td>
                            <td id="taskStatus-<?= $taskID ?>"><?= getTaskStatusLabel($taskStatus); ?> </td>
                            <td>edit button here</td> <!-- Will add this later-->
                            <td><?= renderDeleteButton($taskID); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--End of table-->
        </div>

        <br>

        <!-- Add Task Form -->
        <!-- Will make this nicer later, plan on making it a pop up, instead of a on page display-->
        <div>
            <form action="components/add-task.php" method="POST">
                <div>
                    <label for="taskName">Task Name:</label>
                    <input type="text" class="form-control" id="taskName" name="task_name" required>
                </div>

                <div>
                    <label for="taskDesc">Task Description:</label>
                    <input type="text" class="form-control" id="taskDesc" name="task_description" required>
                </div>

                <div>
                    <label for="taskStatus">Task Status:</label>
                    <select class="form-control" name="task_status" id="taskStatus" required>
                        <option value="">-select-</option>
                        <option value="False">Not Completed</option>
                        <option value="True">Completed</option>
                    </select>
                </div>

                <div>
                    <label for="shootdate">Desired Date:</label>
                    <input required type="date" name="date_due" id="shootdate" title="Choose your desired date" min="<?php echo date('Y-m-d'); ?>" />
                </div>

                <div style="margin-top:10px;">
                    <button type="submit">Add Task</button>
                </div>
            </form>
        </div>

    </div>

</body>

</html>