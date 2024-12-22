# UAS-PemWeb
1.1 Manipulasi DOM dengan JavaScript (15%)
Buat form input dengan minimal 4 elemen input (teks, checkbox, radio, dll.)
-> Sudah diimplementasikan pada form di halaman dashboard (teks, checkbox, number, radio, textarea, option)

Tampilkan data dari server ke dalam sebuah tabel HTML.
-> Sudah diimplementasikan pada tabel di halaman dashboard dan data_mahasiswa


1.2 Event Handling (15%)
Tambahkan minimal 3 event yang berbeda untuk meng-handle form pada 1.1.
-> Sudah diimplementasikan di validate.js

Implementasikan JavaScript untuk validasi setiap input sebelum diproses oleh PHP.
-> Sudah diimplementasikan di validate.js


2.1 Pengelolaan Data dengan PHP (20%)
Gunakan metode POST atau GET pada formulir.
-> Sudah diimplementasikan pada form tambah data mahasiswa dan form modal update

Parsing data dari variabel global dan lakukan validasi di sisi server.
-> Sudah diimplementasikan pada form tambah data mahasiswa dan form modal update

Simpan ke basis data termasuk jenis browser dan alamat IP pengguna.
-> Sudah diimplementasikan pada form tambah data mahasiswa dan form modal update


2.2 Objek PHP Berbasis OOP (10%)
Buat sebuah objek PHP berbasis OOP yang memiliki minimal dua metode dan gunakan objek tersebut dalam skenario tertentu.
-> Sudah diimplementasikan di dashboard.php untuk bagian class mahasiswa dan database


3.1 Pembuatan Tabel Database (5%)
-> Sudah diimplementasikan di uas.sql (berisi pembuatan database dan table mahasiswa) dan login.sql (berisi tabel pengguna untuk sistem login)


3.2 Konfigurasi Koneksi Database (5%)
-> Sudah diimplementasikan di index.php, dashboard.php, dan data_mahasiswa.php


3.3 Manipulasi Data pada Database (10%)
-> Sudah diimplementasikan di dashboard.php untuk operasi tambah, update, dan hapus data mahasiswa


4.1 State Management dengan Session (10%)
Gunakan session_start() untuk memulai session.
-> Sudah diimplementasikan di index.php, logout.php, dan dashboard.php

Simpan informasi pengguna ke dalam session.
-> Sudah diimplementasikan di index.php baris 43 dan 44 (menyimpan username dan password)


4.2 Pengelolaan State dengan Cookie dan Browser Storage (10%)
Buat fungsi untuk menetapkan, mendapatkan, dan menghapus cookie.
-> Sudah diimplementasikan di login.js

Gunakan browser storage untuk menyimpan informasi secara lokal.
-> Sudah diimplementasikan di login.js


Bagian Bonus: Hosting Aplikasi Web (Bobot: 20%)
(5%) Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?
-> Untuk menghosting aplikasi web, langkah-langkah yang perlu dilakukan adalah memilih dan menyewa layanan hosting web yang cocok, kemudian sewa domain sesuai dengan keinginan. Setelah itu, jika tidak ada proses propagasi dns, kita bisa langsung mengupload file aplikasi web kita ke file manager hosting. Terakhir, konfigurasi database pada hosting yang dipilih agar aplikasi web kita bisa terhubung ke database.

(5%) Pilih penyedia hosting web yang menurut Anda paling cocok untuk aplikasi web Anda.
-> Untuk aplikasi web CRUD seperti yang saya buat, shared hosting sudah cukup untuk menanganinya. Sementara itu, saya akan memilih penyedia hosting yang sudah pernah pakai dan dapat dipercaya yaitu rumahweb dan niagahoster.

(5%) Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?
-> Saya akan memastikan bahwa layanan web yang saya pakai sudah menyediakan layanan SSL dan SSH. Selain itu, di rumahweb, disediakan layanan security 360 (Sistem keamanan dari CloudLinux sebagai proactive defense yang mampu mendeteksi dan mematikan ancaman keamanan seperti malware, virus, dan DDoS). Terakhir, saya akan memastikan bahwa setiap input ke database harus melalui sanitasi dan validasi terlebih dahulu. Sebagai tambahan, saya juga bisa menggunakan password hashing yang lebih kuat seperti bcrypt atau argon2 untuk menyimpan password secara aman dibandingkan dengan md5.

(5%) Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.
-> Konfigurasi server yang saya terapkan antara lain adalah: 1. Memilih apache sebagai server karena apache cocok untuk aplikasi berbasis PHP dan memiliki banyak modul untuk berbagai kebutuhan. 2. Menggunakan MySQL sebagai database server. 3. Menggunakan fungsi escape_string untuk memastikan tidak ada karakter yang mengganggu query (mengamankan data input dari SQL injection). 4. Melakukan validasi dan sanitasi input sebelum diproses.
