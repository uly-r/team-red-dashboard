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
    <title>Personal Dashboard - Edit Profile</title>
    <script>
        function enableEdit(fieldId) {
            const input = document.getElementById(fieldId);
            input.removeAttribute('readonly');
            input.classList.remove('bg-gray-100');
            input.focus();
        }
    </script>
</head>

<body class="h-screen flex items-center justify-center bg-gradient-to-br from-gray-800 via-zinc-700 to-neutral-700 text-white">
    <div class="backdrop-blur-md bg-white/10 text-white p-8 rounded-xl shadow-xl max-w-md w-full
            ring-1 ring-white/20 transition-transform duration-300 hover:scale-[1.01]">

        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Edit Profile</h2>

        <form action="components/update_profile.php" method="POST" class="space-y-4">
            <!-- Username -->
            <div>
                <label for="username" class="block text-gray-700 dark:text-gray-200">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>"
                    class="w-full mt-1 p-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full mt-1 p-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
            </div>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-gray-700 dark:text-gray-200">Current Password (required to change password)</label>
                <input type="password" name="current_password" id="current_password"
                    class="w-full mt-1 p-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
            </div>

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-gray-700 dark:text-gray-200">New Password</label>
                <input type="password" name="new_password" id="new_password"
                    class="w-full mt-1 p-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold transition duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</html>