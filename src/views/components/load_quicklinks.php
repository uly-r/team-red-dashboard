<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../php/functions/quicklinks/get_links.php';

$user_id = $_SESSION['user_id'] ?? null;
$links = [];

if ($user_id) {
    $links = getUserQuickLinks($user_id);
}

function getIconStyles($iconClass) {
    $styles = [
        'fa-youtube' => 'text-red-600 text-2xl',
        'fa-spotify' => 'text-green-500 text-2xl',
        'fa-envelope' => 'text-gray-600 text-2xl',
        'fa-google' => 'text-blue-500 text-2xl',
        'fa-book' => 'text-yellow-700 text-2xl',
        'fa-github' => 'text-black text-2xl',
        'fa-calendar-days' => 'text-indigo-500 text-2xl',
        'fa-file-word' => 'text-blue-700 text-2xl',
        'fa-linkedin' => 'text-blue-800 text-2xl',
        'fa-whatsapp' => 'text-green-600 text-2xl',
        'fa-discord' => 'text-indigo-400 text-2xl',
        'fa-x-twitter' => 'text-black text-2xl',
        'fa-reddit' => 'text-orange-500 text-2xl'
    ];

    foreach ($styles as $key => $value) {
        if (str_contains($iconClass, $key)) {
            return $value;
        }
    }

    return 'text-gray-700 text-2xl'; // Default styling
}
