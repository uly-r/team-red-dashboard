<?php
require_once '../../src/php/includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../public/assets/styles.css" rel="stylesheet">
    <title>Edit Profile</title>
    <script>
        function enableEdit(fieldId) {
            const input = document.getElementById(fieldId);
            input.removeAttribute('readonly');
            input.classList.remove('bg-gray-100');
            input.focus();
        }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <form action="../views/components/update_profile.php" method="POST" class="bg-white dark:bg-gray-700 p-6 rounded shadow-md w-[500px] mx-auto mt-10 space-y-6 text-black dark:text-white" enctype="multipart/form-data">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Edit Profile</h2>
        <!-- Username -->
        <div class="relative">
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required
                class="mt-1 w-full border rounded px-3 py-2 pr-10 bg-gray-100 dark:bg-gray-600 dark:text-white" readonly>
            <button type="button" onclick="openEditPopup('username', '<?= htmlspecialchars($user['username']) ?>')" class="absolute top-8 right-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </button>
        </div>
        <!-- Email -->
        <div class="relative">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required
                class="mt-1 w-full border rounded px-3 py-2 pr-10 bg-gray-100 dark:bg-gray-600 dark:text-white" readonly>
            <button type="button" onclick="openEditPopup('email', '<?= htmlspecialchars($user['email']) ?>')" class="absolute top-8 right-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </button>
        </div>
        <!-- New Password -->
        <div class="relative">
            <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">New Password</label>
            <input type="password" name="new_password" id="new_password"
                class="mt-1 w-full border rounded px-3 py-2 pr-10 bg-gray-100 dark:bg-gray-600 dark:text-white" readonly>
            <button type="button" onclick="openEditPopup('password', '')" class="absolute top-8 right-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </button>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-500">Save Changes</button>
    </form>
    <!-- Edit Field Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white dark:bg-gray-700 p-6 rounded shadow-lg w-96 relative">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Edit Field</h3>
            <form id="editForm" method="POST" action="../views/components/update_profile.php">
                <input type="hidden" name="field_name" id="modalField">
                <label for="modalValue" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">New Value</label>
                <input type="text" name="new_value" id="modalValue" class="w-full border px-3 py-2 rounded mb-4 dark:bg-gray-600 dark:text-white" required>
                <div id="currentPasswordField" class="hidden">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="w-full border px-3 py-2 rounded mb-4 dark:bg-gray-600 dark:text-white">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded dark:bg-gray-600 dark:text-gray-200">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-500">Update</button>
                </div>
            </form>
            <button class="absolute top-2 right-2 text-gray-500 hover:text-red-500 dark:hover:text-red-400" onclick="closeModal()">×</button>
        </div>
    </div>
</body>
<script>
        function openEditPopup(fieldName, currentValue) {
            const modal = document.getElementById('editModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalField = document.getElementById('modalField');
            const modalValue = document.getElementById('modalValue');
            const currentPasswordField = document.getElementById('currentPasswordField');
            modalTitle.textContent = `Edit ${capitalize(fieldName)}`;
            modalField.value = fieldName;
            modalValue.value = currentValue;
            modalValue.type = fieldName === 'password' ? 'password' : fieldName === 'email' ? 'email' : 'text';
            currentPasswordField.classList.toggle('hidden', fieldName !== 'password');
            if (fieldName === 'password') {
                modalValue.placeholder = 'Enter new password';
                document.getElementById('current_password').required = true;
            } else {
                modalValue.placeholder = '';
                document.getElementById('current_password').required = false;
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('modalValue').value = '';
            document.getElementById('current_password').value = '';
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    </script>

</html>