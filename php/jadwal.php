<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jadwal Kapal - Website Penjualan Tiket</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../images/foto_alam.JPG" alt="Logo">
        </div>
        <nav>
        <ul>
        <li><a href="../pages/about.html">Tentang Kami</a></li>
        <li><a href="../pages/reservasi.html">Reservasi Tiket</a></li>
        <li><a href="../php/jadwal.php">Jadwal Kapal</a></li>
          <li><a href="../php/logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>

    <main>
        <section class="schedule-section">
            <h2>Daftar Jadwal Kapal</h2>
            <?php
            // Koneksi ke database
            $conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

            // Cek koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mendapatkan semua jadwal kapal
            $sql = "SELECT * FROM jadwal"; // Pastikan nama tabel sesuai
            $result = $conn->query($sql);

            // Menampilkan hasil
            if ($result->num_rows > 0) {
                echo "<table border='1'>
                        <tr>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Kelas</th>
                            <th>Nama Kapal</th>
                            <th>Harga</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['asal']}</td>
                            <td>{$row['tujuan']}</td>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['kelas']}</td>
                            <td>{$row['nama_kapal']}</td>
                            <td>{$row['harga']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "Tidak ada jadwal yang ditemukan.";
            }

            // Menutup koneksi
            $conn->close();
            ?>
        </section>
    </main>
</body>
</html>