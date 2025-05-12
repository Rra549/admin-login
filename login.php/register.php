<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $verification_code = bin2hex(random_bytes(16));

    // Simpan data user ke database
    $stmt = mysqli_prepare($conn, "INSERT INTO users (email, username, password, verification_code) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $password, $verification_code);

    if (mysqli_stmt_execute($stmt)) {
        // Kirim email verifikasi (pastikan mail server aktif di localhost atau gunakan SMTP di produksi)
        $verification_link = "http://localhost/verify.php?code=$verification_code";
        $subject = "Verifikasi Akun Anda";
        $message = "Halo $username,\n\nSilakan klik link berikut untuk verifikasi akun Anda:\n$verification_link\n\nAtau masukkan kode ini secara manual di halaman verifikasi:\n$verification_code";
        $headers = "From: no-reply@frozenfood.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "<p style='color:green;'>Registrasi berhasil! Cek email untuk verifikasi.</p>";
        } else {
            echo "<p style='color:red;'>Registrasi berhasil tapi gagal mengirim email.</p>";
        }
    } else {
        echo "<p style='color:red;'>Gagal registrasi: " . mysqli_error($conn) . "</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #74ebd5, #ACB6E5);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
form {
    background-color: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
}
h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}
input[type="email"],
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
}
button {
    width: 100%;
    padding: 0.75rem;
    background-color: #007BFF;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>
    <form method="post">
        <h2>Form Registrasi</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
</body>
</html>
