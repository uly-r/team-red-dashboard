<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.html");
    exit();
}
require_once '../php/includes/db_connect.php';
$user_id = $_SESSION['user_id'];

function renderDeleteButton($taskID)
{
    return '
        <form action="components/delete-task.php" method="POST" style="display:inline;">
            <input type="hidden" name="task_id" value="' . htmlspecialchars($taskID) . '">
            <button type="submit" onclick="return confirm(\'Delete this task?\');" 
                class="text-red-500 hover:text-red-700">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    ';
}

function getTaskStatusLabel($taskStatus)
{
    return $taskStatus == 1 ? 'Completed' : 'Not Completed';
}

function renderEditButton($task)
{
    $id = (int)$task['id'];
    $title = json_encode($task['title']);
    $desc = json_encode($task['description']);
    $status = json_encode((string)$task['is_completed']); // Cast to string for form
    $due = json_encode($task['due_date']);

    return "
        <button onclick='openForm($id, $title, $desc, $status, $due)' 
            class='text-blue-500 hover:text-blue-700'>
            <i class='fa-solid fa-pen'></i>
        </button>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../public/assets/task-form.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/04a4e79b23.js" crossorigin="anonymous"></script>
    <title>Task page</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-6xl">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Task Tracker</h2>
        </div>
        <div>
            <table class="min-w-full divide-y divide-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Task Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $taskID = $row['id'];
                        $taskName = $row['title'];
                        $taskDesc = $row['description'];
                        $dateDue = $row['due_date'];
                        $taskStatus = $row['is_completed'];
                    ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['title']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['description']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($row['due_date']) ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-sm rounded 
                                <?= $row['is_completed'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= getTaskStatusLabel($row['is_completed']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <?= renderEditButton($row); ?>
                                <?= renderDeleteButton($row['id']); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>
        <div>
            <button onclick="openAddForm()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Add Task
            </button>
            <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50" id="addTaskForm" style="display: none;">
                <form action="components/add-task.php" method="POST" class="bg-white p-6 rounded-xl shadow-md space-y-4 w-96">
                    <h2 class="text-xl font-semibold">Add Task</h2>
                    <div>
                        <label for="taskName" class="block">Task Name:</label>
                        <input type="text" class="w-full border rounded px-3 py-1" id="taskName" name="task_name" required>
                    </div>
                    <div>
                        <label for="taskDesc" class="block">Task Description:</label>
                        <input type="text" class="w-full border rounded px-3 py-1" id="taskDesc" name="task_description" required>
                    </div>
                    <div>
                        <label for="taskStatus" class="block">Task Status:</label>
                        <select class="w-full border rounded px-3 py-1" name="task_status" id="taskStatus" required>
                            <option value="">-select-</option>
                            <option value="0">Not Completed</option>
                            <option value="1">Completed</option>
                        </select>
                    </div>
                    <div>
                        <label for="shootdate" class="block">Desired Date:</label>
                        <input required type="date" name="date_due" id="shootdate" class="w-full border rounded px-3 py-1" min="<?php echo date('Y-m-d'); ?>" />
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
                        <button type="button" onclick="closeAddForm()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50" id="updateTaskForm" style="display: none;">
            <form action="components/update-task.php" method="POST" class="bg-white p-6 rounded-xl shadow-md space-y-4 w-96">
                <h2 class="text-xl font-semibold">Edit Task</h2>
                <input type="hidden" name="task_id" id="updateTaskID">
                <div>
                    <label for="updateTaskName" class="block">Task Name:</label>
                    <input type="text" class="w-full border rounded px-3 py-1" id="updateTaskName" name="task_name" required>
                </div>
                <div>
                    <label for="updateTaskDesc" class="block">Task Description:</label>
                    <input type="text" class="w-full border rounded px-3 py-1" id="updateTaskDesc" name="task_description" required>
                </div>
                <div>
                    <label for="updateTaskStatus" class="block">Task Status:</label>
                    <select class="w-full border rounded px-3 py-1" name="task_status" id="updateTaskStatus" required>
                        <option value="">-select-</option>
                        <option value="1">Completed</option>
                        <option value="0">Not Completed</option>
                    </select>
                </div>
                <div>
                    <label for="updadatedate_due" class="block">Due Date:</label>
                    <input type="date" class="w-full border rounded px-3 py-1" name="date_due" id="updadatedate_due" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    <button type="button" onclick="closeForm()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Close</button>
                </div>
            </form>
        </div>
        <script>
            function openForm(id, title, desc, status, date) {
                document.getElementById("updateTaskForm").style.display = "flex";
                document.getElementById("updateTaskID").value = id;
                document.getElementById("updateTaskName").value = title;
                document.getElementById("updateTaskDesc").value = desc;
                document.getElementById("updateTaskStatus").value = status;
                document.getElementById("updadatedate_due").value = date;
            }
            function closeForm() {
                document.getElementById("updateTaskForm").style.display = "none";
            }
            function openAddForm() {
                document.getElementById("addTaskForm").style.display = "flex";
            }
            function closeAddForm() {
                document.getElementById("addTaskForm").style.display = "none";
            }
        </script>
    </div>
</body>
</html>