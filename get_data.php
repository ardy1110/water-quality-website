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

// Ambil data terbaru dari tabel (misalnya 10 entri terakhir)
$sql = "SELECT 
            DATE_FORMAT(timestamp, '%d %b %Y') as tanggal, 
            TIME(timestamp) as pukul, 
            turbidity, 
            ph 
        FROM 
            sensor_readings 
        ORDER BY 
            id DESC 
        LIMIT 10";
$result = $conn->query($sql);

$data = array(); // Membuat array kosong untuk menampung data

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row; // Tambahkan setiap baris ke dalam array
    }
}

echo json_encode($data); // Kirim data dalam format JSON

$conn->close();
?>
