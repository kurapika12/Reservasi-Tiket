<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Handle penghapusan pembeli
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM pembelian WHERE id = $id");
}

// Handle update status
if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $conn->query("UPDATE pembelian SET status_pembayaran = 'Selesai' WHERE id = $id");
}

// Ambil data pembeli
$pembeli_sql = "SELECT * FROM pembelian";
$pembeli_result = $conn->query($pembeli_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Pembeli</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
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
        <section id="pembeli">
            <h2>Daftar Pembeli</h2>
            <input type="text" id="search" placeholder="Cari nama pembeli..." onkeyup="searchPembeli()">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jumlah Tiket</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="pembeliTable">
                    <?php while ($row = $pembeli_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['jumlah_tiket']; ?></td>
                            <td>Rp <?= number_format($row['total_harga'], 2); ?></td>
                            <td><?= $row['metode_pembayaran']; ?></td>
                            <td><?= $row['status_pembayaran']; ?></td>
                            <td>
                                <a href="?update=<?= $row['id']; ?>">Tandai Selesai</a>
                                <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Hapus pembeli ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function searchPembeli() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#pembeliTable tr');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let match = false;
                for (let i = 1; i < cells.length - 1; i++) { // Mulai dari 1 untuk skip ID dan sampai sebelum aksi
                    if (cells[i].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                row.style.display = match ? '' : 'none';
            });
        }
    </script>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
