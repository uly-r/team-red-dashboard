<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.html"); // adjust path if needed
    exit();
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../public/assets/styles.css" rel="stylesheet">
    <title>Personal Dashboard</title>
</head>

<body class="bg-gradient-to-br from-slate-100 via-slate-200 to-slate-300 min-h-screen text-gray-800">


    <div class="flex justify-between items-center mb-6 w-full p-5">
        <!-- Start Icon -->
        <div class="relative">
            <button class="text-gray-600 p-3" onclick="toggleDropdown()">
                <!-- Profile icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownMenu" class="hidden absolute mt-2 w-48 bg-white border border-gray-200 rounded shadow-md z-50">
                <!-- Tail -->
                <div class="absolute -top-1 left-6 w-3 h-3 bg-white rotate-45 border-l border-t border-gray-200 z-[-1]"></div>

                <!-- Content -->
                <div class="px-4 py-2 text-sm text-gray-800 border-b">
                    Welcome, <?= htmlspecialchars($_SESSION['username']); ?>
                </div>
                <a href="editprofile.php" rel="noopener noreferrer" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profile</a>
                <a href="../php/auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div><!-- Finish Icon -->


        <!-- Header (Centered) -->
        <h1 class="absolute left-1/2 transform -translate-x-1/2 text-2xl font-semibold text-gray-800">Personal Dashboard</h1>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-3 gap-6 p-5">
        <!-- Left Column -->
        <div class="flex flex-col gap-6">
            <?php include '../views/components/task.php'; ?>
            <?php include '../views/components/quicklinks_card.php'; ?>
            <!-- <div class="bg-white rounded-xl p-4 shadow">Quick Links</div> -->
        </div>
        <!-- Middle Column -->
        <div class="flex flex-col gap-6">
            <?php include '../views/components/calender.php'; ?>
            <?php include '../views/components/notes.php'; ?>
        </div>
        <!-- Right Column -->
        <div class="flex flex-col gap-6">
            <?php include '../views/components/weather.php'; ?> <!-- Customize width with Tailwind (e.g., w-full, w-3/4, etc.) -->
            <?php include '../views/components/countdown.php'; ?> <!-- Countdown -->
        </div>
    </div>
    `
    <script src="../../src/js/weather.js"></script>
    <script src="../../src/js/quicklink.js"></script>
    <script src="../../src/js/settings_dropdown.js"></script>
    <script src="../../src/js/themes.js"></script>

</body>

</html>