<?php
// Definisikan grid sebagai array multi-dimensi
$grid = [
    ["#", "#", "#", "#", "#", "#", "#"],
    ["#", ".", ".", ".", ".", ".", "#"],
    ["#", ".", "#", "#", "#", ".", "#"],
    ["#", ".", ".", ".", "#", ".", "#"],
    ["#", "X", "#", ".", ".", ".", "#"],
    ["#", "#", "#", "#", "#", "#", "#"],
];

echo "<br>Sebelum";
// Tampilkan grid
foreach ($grid as $baris) {
    echo "<br>";
    echo implode("", $baris) . PHP_EOL;
}

// Definisikan urutan navigasi (Atas, Kanan, Bawah)
$urutanNavigasi = [
    ['A' => -1, 'B' => 0, 'C' => 0], //  Ini adalah langkah pertama, yang menggerakkan pemain satu langkah ke atas (atau utara) dalam grid.
    ['A' => 0, 'B' => 1, 'C' => 0],  //  Ini adalah langkah kedua, yang menggerakkan pemain satu langkah ke kanan (atau timur) dalam grid.
    ['A' => 0, 'B' => 0, 'C' => 1],  //  Ini adalah langkah tika, yang menggerakkan pemain satu langkah ke bawahs (atau timur) dalam grid.
];

// Inisialisasi variabel untuk menyimpan lokasi Item yang mungkin
$lokasiMungkin = [];

// Loop melalui grid
for ($baris = 0; $baris < count($grid); $baris++) {
    for ($kolom = 0; $kolom < count($grid[$baris]); $kolom++) {
        // Periksa apakah posisi saat ini adalah posisi awal pemain
        if ($grid[$baris][$kolom] === "X") {
            // Periksa lokasi barang berdasarkan urutan navigasi
            $lokasiItem = [];
            foreach ($urutanNavigasi as $urutan) {
                $barisItem = $baris + $urutan['A'];
                $kolomItem = $kolom + $urutan['B'];
                if (isset($grid[$barisItem][$kolomItem]) && $grid[$barisItem][$kolomItem] === ".") {
                    $lokasiItem[] = [$barisItem, $kolomItem];
                }
            }
            // Tambahkan lokasi Item ke lokasi yang mungkin
            $lokasiMungkin = array_merge($lokasiMungkin, $lokasiItem);
        }
    }
}

// Tampilkan grid dengan lokasi Item yang mungkin ditandai dengan simbol "$"
foreach ($lokasiMungkin as $lokasi) {
    $grid[$lokasi[0]][$lokasi[1]] = "$";
}
echo "<br>Sesudah";
// Tampilkan grid yang telah dimodifikasi
foreach ($grid as $baris) {
    echo "<br>";
    echo implode("", $baris) . PHP_EOL;
}

// Tampilkan daftar koordinat yang mungkin ada Item
echo "<br>Koordinat Itemm";
echo "Lokasi yang memungkinan: " . json_encode($lokasiMungkin);
?>
