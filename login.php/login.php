<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE email = ? AND is_verified = 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $id; // Tambahkan ini
            $_SESSION["role"] = 'admin';
            echo "<p style='color:green;'>Login berhasil. Selamat datang, $username!</p>";
            header("Location: index.php");
            exit;
        } else {
            echo "<p style='color:red;'>Password salah.</p>";
        }
    } else {
        echo "<p style='color:red;'>Email tidak ditemukan atau belum diverifikasi.</p>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
input[type="password"],
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
p {
    text-align: center;
    margin-top: 1rem;
}
</style>

</head>
<body>
<h2>Form Login</h2>
<form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>

    <ul class="">
            <li><a href="register.php">Register</a></li>
            <li><a href="verify.php">Verify</a></li>
            <li><a href="Lupa_password.php">Lupa Password</a></li>
    </ul>
</form>
</body>
</html>
