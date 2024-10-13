<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'ticket_reservation');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        // Memeriksa password dengan password_verify
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: ../pages/admin.html");
            } else {
                header("Location: ../pages/about.html");
            }
            exit;
        } else {
            echo "Password salah. <a href='../index.html'>Kembali</a>";
        }
    } else {
        echo "User tidak ditemukan. <a href='../index.html'>Kembali</a>";
    }

    $stmt->close();
}

$conn->close();