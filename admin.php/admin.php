<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';


?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; max-width: 700px; margin: auto; }
        h1 { text-align: center; }
        /*ul { list-style: none; padding: 0; }
        li { margin: 10px 0; }
        a { text-decoration: none; color: #007BFF; font-weight: bold; }
        a:hover { text-decoration: underline; } */
        .logout { float: right; color: red; }
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
        <h1>Selamat Datang, <?php echo $_SESSION["admin_username"]; ?>!</h1>
        <a href="admin_logout.php" class="logout">Logout</a>
        <p>Ini adalah halaman admin. Anda bisa mengelola data pengguna di sini</p>

        <nav class="navbar">
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="nav-links">
        <!--<ul id="nav-links"> -->
                <li><a href="admin_add_user.php">➕ Tambah User Baru</a></li>
                <li><a href="admin_view_user.php">👥 Lihat Semua User</a></li>
                <li><a href="admin_manage_products.php">Kelola Produk</a></li>
                <li><a href="admin_orders.php">Lihat Pesanan</a></li>
                <li><a href="#"></a><li>
                </ul>
        </ul>
        </nav>
    </div>
</body>
</html>
