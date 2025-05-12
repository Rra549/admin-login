<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $verification_code = trim($_POST["verification_code"]);

    // Update akun jika kode verifikasi cocok
    $stmt = mysqli_prepare($conn, "UPDATE users SET is_verified = 1, verification_code = NULL WHERE verification_code = ?");
    mysqli_stmt_bind_param($stmt, "s", $verification_code);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) == 1) {
        echo "<p style='color:green;'>Verifikasi berhasil! Anda sekarang bisa login.</p>";
    } else {
        echo "<p style='color:red;'>Kode verifikasi tidak valid atau sudah digunakan.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} elseif (isset($_GET["code"])) {
    // Jika verifikasi via URL link (GET)
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $verification_code = trim($_GET["code"]);

    $stmt = mysqli_prepare($conn, "UPDATE users SET is_verified = 1, verification_code = NULL WHERE verification_code = ?");
    mysqli_stmt_bind_param($stmt, "s", $verification_code);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) == 1) {
        echo "<p style='color:green;'>Verifikasi melalui link berhasil! Anda sekarang bisa login.</p>";
    } else {
        echo "<p style='color:red;'>Link verifikasi tidak valid atau sudah digunakan.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Akun</title>
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
input[type="text"] {
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
    background-color: #28a745;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #218838;
}
p {
    text-align: center;
    margin-top: 1rem;
}
</style>
</head>
<body>
    <form method="post">
        <h2>Verifikasi Akun</h2>
        <p>Masukkan kode verifikasi yang dikirim ke email Anda:</p>
        <input type="text" name="verification_code" placeholder="Kode Verifikasi" required>
        <button type="submit">Verifikasi</button>
    </form>
</body>
</html>
