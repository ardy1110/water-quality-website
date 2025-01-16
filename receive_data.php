<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_data";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari ESP32
$turbidity = $_GET['turbidity'];
$ph = $_GET['ph'];

// Masukkan data ke dalam tabel
$sql = "INSERT INTO sensor_readings (turbidity, ph) VALUES ('$turbidity', '$ph')";

if ($conn->query($sql) === TRUE) {
    // Cek jumlah data dalam tabel
    $sql_count = "SELECT COUNT(*) as total FROM sensor_readings";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $total_data = $row['total'];

    // Jika jumlah data lebih dari 20, hapus data tertua
    if ($total_data > 20) {
        // Hapus data paling lama berdasarkan ID
        $sql_delete = "DELETE FROM sensor_readings ORDER BY id ASC LIMIT " . ($total_data - 20);
        $conn->query($sql_delete);
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
