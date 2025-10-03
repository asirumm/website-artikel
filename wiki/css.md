# CSS Framework dan Komponen

css pada project ini hasil buatan saya, tidak menggunakan framework umum yang ada,
gunanya agar lebih bebas dan lebih ringan. Framework css ini cukup sederhana, saya
membaginya dalam beberapa wilayah css seperti (basic-component.css, data-display-component.cs dsb)
ini stylenya sesuai nama, semisalnya button yang merupakan hal basic maka ditaruh pada
basic-component. Begitupun untuk menampilkan data seperti table maka ada di data-display-component.css

Nilai base ada di root.css dan selanjutnya anda bisa override di base css dari domain
contohnya domain admin anda ingin ganti warna utama silahkan override.

## Aturan main
Sampai dengan saat ini 3 oct 2025, saya menggunakan aturan setiap halaman maka
menggunakan 1 file css sendiri, untuk memudahkan developer baru
paham. Dan saya terbiasa untuk menggunakan inner css style walau itu seperti
sass atau scss.

```
#sidebar.close{
    width: 60px;

    .logo{
        opacity: 0;
        transform: translateX(-10px);
        width: 0;
    }
}
```

Selanjutnya untuk komponen ada pada halaman komponen/folder komponen-view bisa anda lihat.