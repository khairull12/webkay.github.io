<?php
// Koneksi ke database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter tanggal dari request
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// Query untuk mengambil data agenda berdasarkan rentang tanggal
$query = "SELECT * FROM agenda WHERE tanggal BETWEEN '$start_date' AND '$end_date' ORDER BY tanggal DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Tampilkan data dalam bentuk tabel
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Agenda</th><th>Tanggal</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["agenda"] . "</td>";
        echo "<td>" . $row["tanggal"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada data agenda dalam rentang tanggal tersebut.";
}

$conn->close();
?>