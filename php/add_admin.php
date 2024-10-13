<!-- <?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Data admin
$username = 'admin'; // Ganti dengan username admin
$password = password_hash('jualtiket', PASSWORD_DEFAULT); // Ganti dengan password admin yang diinginkan

// Query untuk menambahkan admin
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Admin berhasil ditambahkan.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?> -->
