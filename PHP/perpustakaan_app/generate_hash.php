<?php
// Password yang ingin Anda gunakan untuk user baru
// Ganti 'password_anda_di_sini' dengan password yang Anda inginkan
$password_plain = 'ppkpi';

// Hasilkan hash menggunakan algoritma BCRYPT
$hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);

echo "Password Plain: " . $password_plain . "<br>";
echo "Hashed Password: " . $hashed_password . "<br>";
?>
