<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Membuat QR Code
require '../vendor/autoload.php'; // Pastikan path ini sesuai dengan autoload Composer Anda

// Pindahkan use statements ke atas
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$asal = $_POST['asal'] ?? '';
$tujuan = $_POST['tujuan'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$nama_kapal = $_POST['nama_kapal'] ?? '';
$jumlah_tiket = $_POST['jumlah_tiket'] ?? 0;
$nama_pelabuhan = $_POST['nama_pelabuhan'] ?? 'Bungkutoko';
$metode_pembayaran = $_POST['metode_pembayaran'] ?? '';
$nama = $_POST['nama'] ?? 'Pengunjung'; // Nama pembeli

// Cari jadwal kapal berdasarkan input
$sql = "SELECT id, harga FROM jadwal WHERE asal = ? AND tujuan = ? AND tanggal = ? AND kelas = ? AND nama_kapal = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $asal, $tujuan, $tanggal, $kelas, $nama_kapal);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah jadwal ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_jadwal = $row['id'];
    $harga = $row['harga'];
    $total_harga = $harga * $jumlah_tiket;

    // Simpan informasi pembelian ke tabel
    $sql_insert = "INSERT INTO pembelian (id_jadwal, nama, jumlah_tiket, total_harga, metode_pembayaran) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("isids", $id_jadwal, $nama, $jumlah_tiket, $total_harga, $metode_pembayaran);

    if ($stmt_insert->execute()) {
        echo "Pembelian berhasil! Total harga: Rp " . number_format($total_harga, 2);


        // Buat data untuk QR code (misalnya, informasi tiket)
        $qrData = "ID Jadwal : $id_jadwal\nNama Kapal : $nama_kapal\nNama : $nama\nAsal : $asal\nTujuan : $tujuan\nKelas Kapal : $kelas\nNama Pelabuhan : $nama_pelabuhan\nMetode Pembayaran : $metode_pembayaran\nJumlah Tiket : $jumlah_tiket\nTotal Harga : Rp " . number_format($total_harga, 2);
        
$qrCode = QrCode::create($qrData)
    ->setSize(300)
    ->setMargin(10);

$writer = new PngWriter();
$result = $writer->write($qrCode);


        // Simpan QR Code sebagai file PNG
        $fileName = "../qrcodes/ticket_" . time() . ".png"; // Sesuaikan direktori sesuai kebutuhan
        $result->saveToFile($fileName);

        // Tampilkan link untuk mengunduh QR Code
        echo "<br><a href='$fileName' download>Unduh QR Code Tiket Anda</a>";
    } else {
        echo "Error: " . $stmt_insert->error;
    }
} else {
    echo "Jadwal tidak ditemukan.";
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>