<?php
session_start();
include 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "frozen_food");
    if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE email = ? AND role = 'admin'");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashed_password)) {
            $_SESSION["admin_id"] = $id;
            $_SESSION["admin_username"] = $username;
            $_SESSION["user_id"] = $id; // Tambahkan ini
            $_SESSION["role"] = 'admin';
            header("Location: admin.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Admin tidak ditemukan.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <style>
        body { font-family: sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background: #eee; }
        .container { background: white; padding: 20px; border-radius: 10px; max-width: 700px; margin: auto; }
        form { background:white; padding:20px; border-radius:10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { display:block; margin-bottom:10px; padding:8px; width:100%; }
        .error { color:red; }
        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 0 20px; background-color: #333; }
        .nav-links { display: flex; gap: 20px; }
        .nav-links li { list-style: none;}
        .nav-links a { color: white; text-decoration: none; font-weight: bold; }
        .hamburger {  display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { height: 3px; width: 25px; background: white; margin: 4px 0; border-radius: 2px; }
        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-links { display: none; flex-direction: column; position: absolute; top: 70px; right: 20px; background-color: #333; padding: 10px; border-radius: 5px; }
            .nav-links.active { display: flex; }
            .hamburger { display: flex; }
        }
    </style>
</head>
<body>
    <div class="container">
    <nav class="navbar">
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <ul class="nav-links">
       <!--<ul id="nav-links"> -->
            <li><a href="">Beranda</a></li>
            <li><a href="">Produk</a></li>
            <li><a href="">Manajemen</a></li>
            <li><a href="">About As</a></li>
            <li><a href="">Kontak</a></li>
       </ul>
    </ul>
    </nav>

    <form method="post">
        <h2>Login Admin</h2>
        <input type="email" name="email" placeholder="Email admin" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p class="error"><?php echo $error; ?></p>
    </form>
    </div>
</body>
</html>
