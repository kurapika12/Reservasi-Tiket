<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Handle penghapusan jadwal
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM jadwal WHERE id = $id");
}

// Ambil data jadwal
$jadwal_sql = "SELECT * FROM jadwal";
$jadwal_result = $conn->query($jadwal_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Jadwal</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
    <div class="logo">
        <img src="../images/boat.png" alt="Logo" />
    </div>
    <nav>
        <ul>
            <li><a href="../pages/admin.html">Kelola Jadwal</a></li>
            <li><a href="admin_pembeli.php">Daftar Pembeli</a></li>
            <li><a href="admin_jadwal.php">Daftar Jadwal</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    </header>
    <main>
        <section id="jadwal">
            <h2>Daftar Jadwal</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Nama Kapal</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $jadwal_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['asal']; ?></td>
                            <td><?= $row['tujuan']; ?></td>
                            <td><?= $row['tanggal']; ?></td>
                            <td><?= $row['kelas']; ?></td>
                            <td><?= $row['nama_kapal']; ?></td>
                            <td>Rp <?= number_format($row['harga'], 2); ?></td>
                            <td>
                                <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Hapus jadwal ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
