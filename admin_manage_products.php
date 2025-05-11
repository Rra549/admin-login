<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk Frozen Food</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #e6ffcc;
            background-image: url("dried-multicolor-cherries-berries-concrete-background.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            display: flex;
            align-items: center;
            text-align: center;
            align-content: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #333;
            height: 70px;
            position: relative;
        }
        /* .logo {
            font-size: 28px;           Besar tulisan 
            font-weight: bold;         Tebal 
            color: rgb(red, green, blue);            Warna putih 
            font-family: 'Arial', sans-serif;  Jenis font 
            letter-spacing: 1px;       Jarak antar huruf 
            text-transform: uppercase;  Huruf besar semua 
            margin-left: 15px;  jarak luar logo 
        }

        .logo:hover {
            color: #00bfff;  Warna biru muda saat disentuh 
            transition: 0.3s; /* waktu transition 
        }

        @media (max-width: 600px) {
            .logo {
                width: 80px;
            }
        } */
        header h1 {
            font-size: 30px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        } 
        
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: column;
            padding: 0 20px;
            gap: 0;
            margin-top: 0;
            background-color: #333;
        } 

        .nav-links {
            display: flex;
            gap: 20px;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            margin-left: 5px;
            position: fixed;
        }

        .hamburger span {
            display: flex;
            height: 3px;
            width: 25px;
            background: white;
            margin: 4px 0;
            border-radius: 2px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: left;
                padding: 0 20px;
                position: relative;
                left: 258px;
                bottom: 60px; 
            } 
            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 45px;
                right: -2p0x;
                background-color: #333;
                padding: 10px;
                border-radius: 5px;
                align-items: center;
            }

            .nav-links.active {
                display: flex;
            }

            .hamburger {
                display: flex;
            }
        }

        img.product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        header {
            background-color: #333;
            color: white;
            padding: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .center-text.h1 {
            position: center;
            font-size: 24px;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
            color: white;
            display: inline;
            left: 0;
            transform: translateX();
            margin: 50px 50px 50px 50px;
        }
        .text-center:hover {
            color: blue; /* Warna biru muda saat disentuh */
            transition: 0.3s;
            font-weight: bold;
        }
        .btn {
            background-color: blue;
            color: white;
            padding: 8px 12px;
            border: 5px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: green;
            color: white;
        }
        button {
            background-color: blue;
            color: black;
            padding: 8px 12px;
            border: 5px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: green;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-decoration-break: slice;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: purple;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: white;
            position: relative;
            bottom: 0;
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
    <div class="container">
            <h1 class="h1">Daftar Produk Frozen Food</h1>
        </div>
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
        </div>
        </nav>
    </header><br>
    <button><a href="add_product.php" class="btn">Tambah Produk</a></button>
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary text-center">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td class="text-center"><?php echo $row['id']; ?></td>
            <td class="text-center"><?php if (!empty($row['image'])) : ?> <img src="uploads/<?= htmlspecialchars($row['image']); ?>" alt="Produk" class="product-image">
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?> </td>
            <td class="text-center"><?php echo $row['name']; ?></td>
            <td class="text-center"><?php echo $row['description']; ?></td>
            <td class="text-center"><?php echo $row['price']; ?></td>
            <td class="text-center"><?php echo $row['stock']; ?></td>
            <td>
                <button><a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a></button>
                <button><a href="hapus_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Yakin ingin menghapus mahasiswa ini?');">Hapus</a></button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table><br>
    <button><a href="admin.php" class="btn">Kembali</a></button>
    <footer>
        <p>&copy; 2025 Frozen Food. Semua hak dilindungi.</p>
    </footer>

    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            const hamburger = document.querySelector('.hamburger');
            navLinks.classList.toggle('active');
            hamburger.classList.toggle('active');
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>