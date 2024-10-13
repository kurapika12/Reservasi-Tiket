<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        echo "Password dan konfirmasi password tidak cocok.";
        exit;
    }

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Memasukkan data ke tabel users
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../index.html");
        exit; // Hentikan eksekusi
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Username atau password tidak valid.";
}

$conn->close();
?>