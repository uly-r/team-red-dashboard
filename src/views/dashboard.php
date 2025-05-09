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

<body class="bg-cream h-screen w-full">

       
            <!--  -->
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
                    <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Profile</a>
                    <a href="../php/auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div><!-- Finish Icon --> 
                <!-- Header -->
                <h1 class="text-2xl font-semibold text-gray-800" id="Header">Personal Dashboard</h1>
                <div class="flex gap-5">
                    <button class="text-gray-800 p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </button>
                    <div class="relative">
                        <!-- Settings Icon Button -->
                        <button onclick="toggleSettingsDropdown()" class="text-gray-600 p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="settingsDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded shadow-md z-50">
                            <button onclick="toggleTheme()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Toggle Theme
                            </button>
                        </div>
                    </div>

                </div>
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
                    <div class="bg-white rounded-xl p-4 shadow">News</div> <!-- Customize width with Tailwind (e.g., w-full, w-3/4, etc.) -->
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