<?php
// Mulai session untuk logout
session_start();

// Hapus session
session_unset();
session_destroy();

// Hapus cookie "remember me" jika ada
if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/");  // Hapus cookie
}

// Redirect ke halaman login
header("Location: index.php");
exit();
?>
