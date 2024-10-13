<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_pembeli = $_POST['nama_pembeli'];
$asal = $_POST['asal'];
$tujuan = $_POST['tujuan'];
$tanggal = $_POST['tanggal'];
$kelas = $_POST['kelas'];
$laki_laki = $_POST['laki_laki'];
$perempuan = $_POST['perempuan'];
$bayi = $_POST['bayi'];
$total_tiket = $laki_laki + $perempuan + $bayi;

// Proses pembelian tiket
$sql = "INSERT INTO pembelian (nama_pembeli, asal, tujuan, tanggal, kelas, laki_laki, perempuan, bayi, total_tiket)
        VALUES ('$nama_pembeli', '$asal', '$tujuan', '$tanggal', '$kelas', '$laki_laki', '$perempuan', '$bayi', '$total_tiket')";

if ($conn->query($sql) === TRUE) {
    echo "Pembelian tiket berhasil! <br>";
    echo "<a href='download_ticket.php?id=" . $conn->insert_id . "'>Unduh Tiket</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>