<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form pencarian
$asal = $_POST['asal'] ?? '';
$tujuan = $_POST['tujuan'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$kelas = $_POST['kelas'] ?? '';

// Query untuk mencari jadwal kapal
$sql = "SELECT * FROM jadwal WHERE asal LIKE ? AND tujuan LIKE ? AND tanggal = ? AND kelas LIKE ?";
$stmt = $conn->prepare($sql);
$asal = "%$asal%"; // Menambahkan wildcard untuk pencarian
$tujuan = "%$tujuan%";
$kelas = "%$kelas%";
$stmt->bind_param("ssss", $asal, $tujuan, $tanggal, $kelas);
$stmt->execute();
$result = $stmt->get_result();

// Menampilkan hasil pencarian
if ($result->num_rows > 0) {
    echo "<h2>Hasil Pencarian:</h2>";
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
$stmt->close();
$conn->close();
?>
