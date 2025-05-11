<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "db.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Jangan izinkan admin hapus dirinya sendiri
    if ($id == $_SESSION["admin_id"]) {
        die("Tidak bisa hapus akun admin yang sedang login.");
    }

    mysqli_query($conn, "DELETE FROM users WHERE id = $id");
}

header("Location: admin_view_users.php");
exit;
