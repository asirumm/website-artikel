//  Sidebar
  function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
      if (sidebar.classList.contains('close')) {
          sidebar.classList.remove('close'); // Buka sidebar
      } else {
          sidebar.classList.add('close'); // Tutup sidebar
      }
}

// table search
document.getElementById("search").addEventListener("keyup", function() {
    const keyword = this.value.toLowerCase(); // ambil keyword dan jadikan lowercase
    const rows = document.querySelectorAll("#table tbody tr");

    rows.forEach(row => {
        // Gabungkan semua teks dari kolom
        const text = row.innerText.toLowerCase();
        // Cek apakah ada keyword di text
        row.style.display = text.includes(keyword) ? "" : "none";
    });
});

