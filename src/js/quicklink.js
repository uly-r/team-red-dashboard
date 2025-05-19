// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', () => {

    const addLinkBtn = document.getElementById("addLinkBtn"); // "+" button to open modal
    const addLinkModal = document.getElementById("addLinkModal"); // Modal container
    const cancelBtn = document.getElementById("cancelBtn"); // "Cancel" button in modal

    // Show modal when "+" button is clicked
    addLinkBtn.addEventListener('click', () => {
        
        addLinkModal.classList.remove('hidden');
    });

    // Hide modal when "Cancel" button is clicked
    cancelBtn.addEventListener('click', () => {
        
        addLinkModal.classList.add('hidden');
    });
});
