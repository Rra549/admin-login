<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $email = trim($_POST["email"]);

    $stmt = mysqli_prepare($conn, "SELECT verification_code, is_verified FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $verification_code, $is_verified);
        mysqli_stmt_fetch($stmt);

        if ($is_verified == 1) {
            $message = "<p style='color:green;'>Akun sudah diverifikasi. Silakan <a href='login.php'>login</a>.</p>";
        } else {
            $verification_link = "http://localhost/verify.php?code=$verification_code";
            $subject = "Kirim Ulang Kode Verifikasi";
            $body = "Klik link berikut untuk verifikasi akun Anda:\n$verification_link\n\nAtau masukkan kode ini: $verification_code";
            $headers = "From: no-reply@frozenfood.com";

            if (mail($email, $subject, $body, $headers)) {
                $message = "<p style='color:green;'>Email verifikasi telah dikirim ulang. Silakan cek inbox Anda.</p>";
            } else {
                $message = "<p style='color:red;'>Gagal mengirim email. Coba lagi nanti.</p>";
            }
        }
    } else {
        $message = "<p style='color:red;'>Email tidak ditemukan.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kirim Ulang Verifikasi</title>
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
input[type="email"] {
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
    background-color: #ffc107;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color: #e0a800;
}
p {
    text-align: center;
    margin-top: 1rem;
}
</style>
</head>
<body>
    <form method="post">
        <h2>Kirim Ulang Verifikasi</h2>
        <input type="email" name="email" placeholder="Masukkan email Anda" required>
        <button type="submit"  a href="resend_verification.php">Kirim Ulang</button>
        <p><a href="resend_verification.php">Belum menerima email verifikasi?</a></p>

        <?php if (!empty($message)) echo $message; ?>
    </form>
</body>
</html>
