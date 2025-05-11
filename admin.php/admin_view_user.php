<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "db.php";

$result = mysqli_query($conn, "SELECT id, email, username, role FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Semua User</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #007BFF; color: white; }
        tr:hover { background-color: #f1f1f1; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>

<h2>Daftar Semua User</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row["id"] ?></td>
        <td><?= $row["email"] ?></td>
        <td><?= $row["username"] ?></td>
        <td><?= $row["role"] ?></td>
        <td><a href="admin_delete_user.php?id=<?= $row["id"] ?>" onclick="return confirm('Yakin ingin hapus user ini?')">Hapus</a></td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
