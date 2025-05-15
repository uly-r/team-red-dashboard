<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';
require_once __DIR__ . '/../../php/classes/TaskManager.php';
require_once __DIR__ . '/../../php/classes/TaskRenderer.php';

$user_id = $_SESSION['user_id'];
$taskManager = new TaskManager($conn, $user_id);
$tasks = $taskManager->fetchUserTasks();
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
<div class="bg-white/80 border border-slate-300 rounded-2xl shadow-xl p-8 w-full max-w-6xl transition hover:shadow-2xl hover:border-slate-400">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Task Tracker</h2>
        <button onclick="toggleFullTable()" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">Toggle View Mode</button>
    </div>

    <div id="taskTableWrapper" class="max-h-96 overflow-y-auto border border-gray-200 rounded-md transition-all duration-300">
        <button id="closeFullscreenBtn" onclick="toggleFullTable()" class="hidden mb-4 text-gray-700 hover:text-black font-bold text-xl">&times; Close View Mode</button>
        <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Task Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php while ($row = $tasks->fetch_assoc()): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($row['title']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($row['description']) ?></td>
                        <td class="px-6 py-4"><?= htmlspecialchars($row['due_date']) ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 text-sm rounded 
                                <?= $row['is_completed'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= TaskRenderer::getStatusLabel($row['is_completed']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4"><?= TaskRenderer::getPriorityLabel($row['task_priority']) ?></td>
                        <td class="px-6 py-4 space-x-2">
                            <?= TaskRenderer::renderEditButton($row); ?>
                            <?= TaskRenderer::renderDeleteButton($row['id']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


<!-- include the add and edit form, and the scripts needed-->
<?php include 'task-modals-and-scripts.php'; ?>
</div>
</body>
</html>
