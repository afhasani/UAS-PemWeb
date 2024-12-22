// Fungsi untuk membuat cookie
function setCookie(name, value, days) {
    // Tentukan kapan cookie akan kadaluarsa
    const expires = new Date();
    // Tambahkan jumlah hari yang diinginkan ke waktu sekarang
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
    // Simpan cookie dengan nama, nilai, waktu kadaluarsa, dan path-nya
    document.cookie = `${name}=${value}; expires=${expires.toUTCString()}; path=/`;
}

// Fungsi untuk mendapatkan nilai dari cookie tertentu
function getCookie(name) {
    // Format cookie yang akan dicari, misalnya "remember_me="
    const nameEQ = name + "=";
    // Ambil semua cookie, lalu pecah menjadi array berdasarkan tanda ";"
    const ca = document.cookie.split(';');
    // Cek satu per satu cookie
    for (let i = 0; i < ca.length; i++) {
        // Hilangkan spasi di awal dan akhir cookie
        let c = ca[i].trim();
        // Jika nama cookie cocok, kembalikan nilainya
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    // Jika cookie tidak ditemukan, kembalikan null
    return null;
}

// Fungsi untuk menghapus cookie
function eraseCookie(name) {
    // Trik untuk menghapus cookie: buat cookie baru dengan nama yang sama tapi sudah kedaluwarsa
    document.cookie = name + '=; Max-Age=-99999999;';
}

// Fungsi yang dijalankan saat halaman selesai dimuat
window.onload = function() {
    // Cek apakah cookie "remember_me" ada dan nilainya "true"
    const rememberMeChecked = getCookie('remember_me');
    if (rememberMeChecked === 'true') {
        // Jika ya, ambil username dan password dari localStorage
        const storedUsername = localStorage.getItem('username');
        const storedPassword = localStorage.getItem('password');
        
        // Kalau username dan password ditemukan
        if (storedUsername && storedPassword) {
            // Masukkan nilai username dan password ke form
            document.getElementById('username').value = storedUsername;
            document.getElementById('password').value = storedPassword;
            // Centang otomatis checkbox "Remember Me"
            document.getElementById('remember_me').checked = true;
        }
    }
};

// Fungsi yang dijalankan saat form dikirim
document.querySelector('form').addEventListener('submit', function(event) {
    // Cek apakah checkbox "Remember Me" dicentang
    const rememberMe = document.getElementById('remember_me').checked;

    if (rememberMe) {
        // Kalau dicentang, simpan username dan password di localStorage
        localStorage.setItem('username', document.getElementById('username').value);
        localStorage.setItem('password', document.getElementById('password').value);
        // Buat cookie "remember_me" dengan nilai "true" yang berlaku 7 hari
        setCookie('remember_me', 'true', 7);
    } else {
        // Kalau tidak dicentang, hapus cookie dan data dari localStorage
        eraseCookie('remember_me');
        localStorage.removeItem('username');
        localStorage.removeItem('password');
    }
});
