<?php require_once(__DIR__ . '/load_quicklinks.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/04a4e79b23.js" crossorigin="anonymous"></script>
  <title>Quick Links</title>
</head>

<body>
  <div class="bg-white rounded-xl p-4 shadow">
    <div class="flex justify-between items-center mb-3">
      <h2 class="text-lg font-semibold">Quick Links</h2>
      <button id="addLinkBtn" class="text-blue-500 text-xl">+</button>
    </div>

    <div id="quickLinksGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
      <?php if (!empty($links)): ?>
        <?php foreach ($links as $link): ?>

          <div class="flex items-center gap-2">
            <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" class="bg-gray-100 hover:bg-gray-200 p-3 rounded flex items-center gap-2 shadow-sm" title="<?= htmlspecialchars($link['title']) ?>">
            <i class="<?= htmlspecialchars($link['icon_class']) ?> <?= getIconStyles($link['icon_class']) ?>"></i>
            </a>

            <form action="/team-red/src/php/functions/quicklinks/delete_link.php" method="post" class="flex items-center">
              <input type="hidden" name="link_id" value="<?= htmlspecialchars($link['id']) ?>" />
              <button type="submit" class="text-red-500 hover:text-red-700 text-sm" title="Delete Link">✖</button>
            </form>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <p>No links found.</p>
      <?php endif; ?>
    </div>
  </div>



  <!-- Modal for Adding a New Link -->
  <div id="addLinkModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-xl w-80 shadow-xl border border-black">
      <h3 class="text-lg font-semibold mb-4">Add New Link</h3>
      <!--Form -->
      <form id="quickLinkForm" action="/team-red/src/php/functions/quicklinks/add_links.php" method="post">
        <input type="text" name="title" placeholder="Title (e.g., Google)" class="w-full mb-2 p-2 border rounded" required />
        <input type="text" name="url" placeholder="URL (https://...)" class="w-full mb-2 p-2 border rounded" required />
        <select name="icon" class="w-full mb-4 p-2 border rounded" required>
          <option value="fa-brands fa-youtube">Youtube</option>
          <option value="fa-brands fa-spotify">Spotify</option>
          <option value="fa-solid fa-envelope">Email</option>
          <option value="fa-brands fa-google">Google</option>
          <option value="fa-solid fa-book">Book</option>
          <option value="fa-brands fa-github">GitHub</option>
          <option value="fa-solid fa-calendar-days">Calendar</option>
          <option value="fa-solid fa-file-word">Word</option>
          <option value="fa-brands fa-linkedin">LinkedIn</option>
          <option value="fa-brands fa-whatsapp">WhatsApp</option>
          <option value="fa-brands fa-discord">Discord</option>
          <option value="fa-brands fa-x-twitter">X (Twitter)</option>
          <option value="fa-brands fa-reddit">Reddit</option>
        </select>
        <div class="flex justify-end gap-2">
          <button type="button" id="cancelBtn" class="text-red-500">Cancel</button>
          <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Add</button>
        </div>
      </form>
    </div>
  </div>

  <script src="../../../src/js/quicklink.js"></script>
</body>

</html>