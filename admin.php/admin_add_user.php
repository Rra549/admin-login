<?php
include "db.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (email, username, password, is_verified, role) VALUES (?, ?, ?, 1, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $hashed_password, $role);

        if (mysqli_stmt_execute($stmt)) {
            $success = "User berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan user. Mungkin email sudah terdaftar.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User - Admin</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #28a745; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; font-size: 16px; }
        button:hover { background-color: #218838; }
        .success { color: green; }
        .error { color: red; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<form method="post">
    <h2>Tambah User Baru</h2>
    
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>
    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    
    <select name="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Tambah User</button>
</form>

</body>
</html>
