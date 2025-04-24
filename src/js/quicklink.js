document.addEventListener('DOMContentLoaded', () => {
    console.log("DOM is ready");
    const addLinkBtn = document.getElementById("addLinkBtn");
    const addLinkModal = document.getElementById("addLinkModal");
    const cancelBtn = document.getElementById("cancelBtn");

    addLinkBtn.addEventListener('click', () => {
        console.log("Add Link clicked");
        addLinkModal.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        console.log("Cancel clicked");
        addLinkModal.classList.add('hidden');
    });
});
