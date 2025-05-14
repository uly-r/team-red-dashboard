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
    <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Edit Profile</h2>

        <form action="components/update_profile.php" method="POST" class="space-y-4">
            <!-- Username -->
            <div>
                <label for="username" class="block text-gray-700 dark:text-gray-200">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>"
                    class="w-full mt-1 p-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full mt-1 p-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-gray-700 dark:text-gray-200">Current Password (required to change password)</label>
                <input type="password" name="current_password" id="current_password"
                    class="w-full mt-1 p-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-gray-700 dark:text-gray-200">New Password</label>
                <input type="password" name="new_password" id="new_password"
                    class="w-full mt-1 p-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-500 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</html>