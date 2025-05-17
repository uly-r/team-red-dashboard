<?php
require_once __DIR__ . '/../../php/includes/db_connect.php';
require_once __DIR__ . '/../../php/classes/TaskManager.php';
require_once __DIR__ . '/../../php/classes/TaskRenderer.php';
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
        <button onclick="toggleFullTable()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition mb-3">Toggle View Mode</button>
    </div>

    <div id="taskTableWrapper" class="max-h-96 overflow-y-auto border border-gray-200 rounded-md transition-all duration-300">
        <button id="closeFullscreenBtn" onclick="toggleFullTable()" class="hidden mb-4 text-gray-700 hover:text-black font-bold text-xl">&times; Close View Mode</button>
        <div id="taskFilterTabs" class="hidden mb-4 flex gap-4">
             <button onclick="openAddForm()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"> Add Task</button>
             <button onclick="setFilter('all')" class="btn">View All</button>
             <button onclick="setFilter('completed')" class="btn">Completed</button>
             <button onclick="setFilter('not_completed')" class="btn">Not Completed</button>
        </div>

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
        <tbody id="taskTableBody" class="bg-white divide-y divide-gray-200">
                <?php include __DIR__ . '/render-task-table.php'; ?>
            </tbody>
        </table>
    </div>

<?php include 'task-modals-and-scripts.php'; ?>
</div>
</body>
</html>

