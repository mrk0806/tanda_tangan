<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "latihan");

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data tanda tangan dari database
$sql = "SELECT created_at as tgl_input, id, signature as gambar FROM signatures ORDER BY id DESC";
$result = $conn->query($sql);

// Periksa apakah kueri berhasil dieksekusi
if (!$result) {
    // Jika ada kesalahan dalam kueri
    echo "Error: " . $conn->error;
} else {
    // Tampilkan tanda tangan jika ada
    if ($result->num_rows > 0) {
        // Mulai tabel untuk menampilkan tanda tangan
        echo '<table style="border-collapse: collapse; width: 100%; text-align: center; border: 1px solid #000;">';
        echo '<tr>
                    <th style="border: 1px solid #000; padding: 8px;">ID</th>
                    <th style="border: 1px solid #000; padding: 8px;">Tanggal Input</th>
                    <th style="border: 1px solid #000; padding: 8px;">Tanda Tangan</th>
                </tr>';

        // Loop melalui setiap baris hasil kueri
        while ($row = $result->fetch_assoc()) {
            // Ambil data dari baris saat ini
            $tgl_input = $row["tgl_input"];
            $id = $row["id"];
            $gambar = $row["gambar"];

            // Tampilkan baris dalam tabel
            echo '<tr>';
            echo '<td style="border: 1px solid #000; padding: 8px;">' . $id . '</td>';
            echo '<td style="border: 1px solid #000; padding: 8px;">' . $tgl_input . '</td>';
            echo '<td style="border: 1px solid #000; padding: 8px;"><img src="' . $gambar . '" alt="Signature"></td>';
            echo '</tr>';
        }

        // Selesai dengan tabel
        echo '</table>';
    } else {
        // Jika tidak ada tanda tangan yang ditemukan
        echo "No signatures found.";
    }
}
