<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<div class="bg-white rounded-xl p-4 shadow">
  <div class="flex justify-between items-center mb-3">
    <h2 class="text-lg font-semibold">Quick Links</h2>  
    <button id="addLinkBtn" class="text-blue-500 text-xl">+</button>
  </div>

  <div id="quickLinksGrid" class="grid grid-cols-3 gap-4">
    <!-- Links will be inserted here via PHP or JS -->
  </div>
</div>
    <!-- Modal for Adding a New Link -->
    <div id="addLinkModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-xl w-80 shadow-xl border border-black">
    <h3 class="text-lg font-semibold mb-4">Add New Link</h3>

    <form id="quickLinkForm" action="../../../src/php/functions/quicklink/add_links.php" method="post">
      <input type="text" name="url" placeholder="URL (https://...)" class="w-full mb-2 p-2 border rounded" required />
      <select name="icon" class="w-full mb-4 p-2 border rounded">
        <!-- Populate with predefined icons -->
        <option value="globe">🌐 Globe</option>
        <option value="book">📘 Book</option>
        <option value="link">🔗 Link</option>
        <!-- Add more options -->
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