<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../public/assets/styles.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <div class="bg-white rounded-xl p-4 shadow flex flex-col items-center">
        <form class="m-4 font-bold text-xl mb-8" id="weatherForm">
            <input type="text" id="cityInput" placeholder="Enter City:" class="w-50 p-2">
            <button type="submit" class="bg-stone-950 text-white px-4 py-2 rounded">Go</button>
        </form>
        <div class="flex flex-col gap-4 text-xl items-center" id="card">
            
        </div>
    </div>

    <script src="../../../src/js/weather.js"></script>
</body>

</html>

<?php

?>