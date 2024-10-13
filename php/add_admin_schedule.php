<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Kapal</title>
</head>
<body>
    <h2>Tambah Jadwal Kapal</h2>
    <form action="php/add_schedule.php" method="post">
        <label for="asal">Asal Kota/Pelabuhan:</label>
        <input type="text" id="asal" name="asal" required><br><br>

        <label for="tujuan">Tujuan Kota/Pelabuhan:</label>
        <input type="text" id="tujuan" name="tujuan" required><br><br>

        <label for="tanggal">Tanggal Pemberangkatan:</label>
        <input type="date" id="tanggal" name="tanggal" required><br><br>

        <label for="kelas">Kelas Kapal:</label>
        <input type="text" id="kelas" name="kelas" required><br><br>

        <label for="nama_kapal">Nama Kapal:</label>
        <input type="text" id="nama_kapal" name="nama_kapal" required><br><br>

        <label for="harga">Harga Tiket:</label>
        <input type="number" id="harga" name="harga" step="0.01" required><br><br>

        <button type="submit">Tambah Jadwal</button>
    </form>
</body>
</html>
