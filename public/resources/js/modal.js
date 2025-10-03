document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("modal");
    const modalTrigger = document.getElementById("modal-trigger");
    const modalCancel = document.getElementById("modal-form-cancel");

    if (modalTrigger && modal) {
        modalTrigger.addEventListener("click", (e) => {
            e.preventDefault();
            console.log('Tombol diklik, membuka modal');
            modal.classList.add("show");
        });
    }

    if (modalCancel) {
        modalCancel.addEventListener("click", (e) => {
            e.preventDefault();
            modal.classList.remove("show");
        });
    }
});