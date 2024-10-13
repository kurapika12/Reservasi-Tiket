<?php
session_start();

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$admin_username = $_POST['admin_username'];
$admin_password = $_POST['admin_password'];

// Memeriksa apakah admin ada di database
$sql = "SELECT id, password FROM users WHERE username = ? AND role = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    
    // Memeriksa password
    if (password_verify($admin_password, $hashed_password)) {
        $_SESSION['admin_id'] = $id;
        $_SESSION['admin_username'] = $admin_username;
        header("Location: ../pages/admin_dashboard.html"); // Halaman dashboard admin
    } else {
        echo "Password salah. <a href='../admin_login.html'>Kembali</a>";
    }
} else {
    echo "Admin tidak ditemukan. <a href='../admin_login.html'>Kembali</a>";
}

$stmt->close();
$conn->close();
?>
