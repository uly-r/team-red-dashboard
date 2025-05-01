function toggleDropdown() {
    const menu = document.getElementById('dropdownMenu');
    menu.classList.toggle('hidden');
}

// Optional: Hide dropdown when clicking outside
window.addEventListener('click', function (e) {
    const menu = document.getElementById('dropdownMenu');
    const button = document.querySelector('[onclick="toggleDropdown()"]');
    if (!menu.contains(e.target) && !button.contains(e.target)) {
        menu.classList.add('hidden');
    }
});