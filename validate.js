// Ambil form pertama
const form = document.getElementById('form-mahasiswa');
// Validasi form pertama
form.addEventListener('submit', function(event) {
    // Ambil elemen form dan input
const nama = document.getElementById('nama');
const nim = document.getElementById('nim');
const prodi = document.getElementById('prodi');
const nilaiMutu = document.getElementById('nilai_mutu');
const semester = document.getElementById('semester');
const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked')
const hobiSelected = document.querySelectorAll('input[name="hobi[]"]:checked').length;
const catatan = document.getElementById('catatan');

    let valid = true;

  // Cek Nama apakah kosong
    if (nama.value.trim() === '') {
        alert('Nama Mahasiswa tidak boleh kosong.');
        valid = false;
    }

  // Cek NIM (hanya boleh terdiri dari angka)
    if (!/^\d+$/.test(nim.value)) {
        alert('NIM hanya boleh terdiri dari angka.');
        valid = false;
    }

  // Cek Prodi apakah kosogn
    if (prodi.value.trim() === '') {
        alert('Program Studi tidak boleh kosong.');
        valid = false;
    }

  // Cek Nilai Mutu (harus positif dan maksimal 4)
    if (parseFloat(nilaiMutu.value) <= 0 || parseFloat(nilaiMutu.value) > 4) {
        alert('Nilai Mutu harus positif dan bernilai maksimal 4.');
        valid = false;
    }

  // Cek Jenis Kelamin apakah dipilih
    if (!jenisKelamin) {
        alert('Jenis Kelamin harus dipilih.');
        valid = false;
    }

  // Cek Hobi apakah dipilih
    if (hobiSelected === 0) {
        alert('Hobi harus dipilih.');
        valid = false;
    }

  // Cek Catatan apakah kosong
    if (catatan.value.trim() === '') {
        alert('Catatan tidak boleh kosong.');
        valid = false;
    }

  // Jika form valid, lanjutkan pengiriman data
    if (!valid) {
        event.preventDefault(); // Cegah pengiriman form jika tidak valid
    }
});