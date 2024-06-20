<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "latihan");

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data tanda tangan dari POST
$signature = $_POST['signature'];

// Insert data tanda tangan ke dalam database
// var_dump($signature);exit;
$sql = "INSERT INTO signatures (signature) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $signature);
if ($stmt->execute()) {
    echo $signature;

    // echo "Signature saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
