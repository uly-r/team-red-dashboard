<!-- Add task modal -->
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
                <label for="taskPriority" class="block">Task Priority:</label>
                <select class="w-full border rounded px-3 py-1" name="taskPriority" id="taskPriority" required>
                    <option value="">-select-</option>
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
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

<!-- Edit task modal -->
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
            <label for="taskPriority" class="block">Task Priority:</label>
            <select class="w-full border rounded px-3 py-1" name="taskPriority" id="taskPriority" required>
                <option value="">-select-</option>
                <option value="1">Low</option>
                <option value="2">Medium</option>
                <option value="3">High</option>
            </select>
        </div>
        <div>
            <label for="updadatedate_due" class="block">Due Date:</label>
            <input type="date" class="w-full border rounded px-3 py-1" name="date_due" id="updadatedate_due" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            <button type="button" onclick="closeEditForm()" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Close</button>
        </div>
    </form>
</div>


<script>

    //Edit forms
    function openEditForm(id, title, desc, status, date, priority) {
        /* This pre loads the currents tasks information into the form
        to allow the user to edit their according task while allowing them 
        to see what they entered previously 
        */
        document.getElementById("updateTaskForm").style.display = "flex";
        document.getElementById("updateTaskID").value = id;
        document.getElementById("updateTaskName").value = title;
        document.getElementById("updateTaskDesc").value = desc;
        document.getElementById("updateTaskStatus").value = status;
        document.getElementById("updadatedate_due").value = date;
        document.getElementById("taskPriority").value = priority;
    }

    function closeEditForm() {
        document.getElementById("updateTaskForm").style.display = "none";
    }

    //Add task forms
    function openAddForm() {
        document.getElementById("addTaskForm").style.display = "flex";
    }

    function closeAddForm() {
        document.getElementById("addTaskForm").style.display = "none";
    }

    
    function toggleFullTable() {
        const wrapper = document.getElementById("taskTableWrapper");
        const closeBtn = document.getElementById("closeFullscreenBtn");

        
        //toggles out full screen
        if (wrapper.classList.contains("fixed")) {
            wrapper.classList.remove("fixed", "inset-0", "z-50", "bg-white", "p-6", "overflow-auto");
            wrapper.classList.add("max-h-96", "overflow-y-auto");

            //hides button, not in full screen anymore
            closeBtn.classList.add("hidden");
        } else {
            //toggle in full screen
            wrapper.classList.add("fixed", "inset-0", "z-50", "bg-white", "p-6", "overflow-auto");
            wrapper.classList.remove("max-h-96", "overflow-y-auto");

            //removes hidden since we entered full screen
            closeBtn.classList.remove("hidden");
        }
    }
</script>
