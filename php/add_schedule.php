<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$tanggal = $_POST['tanggal'];
$kelas = $_POST['kelas'];
$nama_kapal = $_POST['nama_kapal'];
$harga = $_POST['harga'];

// Memasukkan data ke tabel jadwal
$sql = "INSERT INTO jadwal (asal, tujuan, tanggal, kelas, nama_kapal, harga) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssd", $asal, $tujuan, $tanggal, $kelas, $nama_kapal, $harga);

if ($stmt->execute()) {
    header("Location: ../pages/admin.html"); // Arahkan kembali ke halaman admin
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
