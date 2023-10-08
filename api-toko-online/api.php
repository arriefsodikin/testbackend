<?php

header('Content-Type: application/json; charset=utf8'); // format json

$host = "localhost";
$username = "root";
$password = "";
$database = "testoko";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// PRODUK -----------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // READ PRODUK
    $sql = "SELECT * FROM products";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CREATE PRODUK
    if (isset($_POST['nama'], $_POST['deskripsi'], $_POST['harga'], $_POST['stok'])) {
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        // Check if the inventory is not negative
        if ($stok < 0) {
            $data = [
                'status' => "gagal",
                'message' => "Inventory cannot be negative"
            ];
            echo json_encode($data);
            exit;
        }

        $sql = "INSERT INTO products(name, deskripsi, harga, inventory) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $nama, $deskripsi, $harga, $stok);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // UPDATE PRODUK
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id'], $_PUT['nama'], $_PUT['deskripsi'], $_PUT['harga'], $_PUT['stok'])) {
        $id = $_PUT['id'];
        $nama = $_PUT['nama'];
        $deskripsi = $_PUT['deskripsi'];
        $harga = $_PUT['harga'];
        $stok = $_PUT['stok'];

        // Check if the inventory is not negative
        if ($stok < 0) {
            $data = [
                'status' => "gagal",
                'message' => "Inventory cannot be negative"
            ];
            echo json_encode($data);
            exit;
        }

        $sql = "UPDATE products SET name=?, deskripsi=?, harga=?, inventory=? WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'ssdii', $nama, $deskripsi, $harga, $stok, $id);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE PRODUK
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
}
// ORDER -----------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // READ ORDER
    $sql = "SELECT * FROM orders";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CREATE ORDER
    if (isset($_POST['product_id'], $_POST['quantity'], $_POST['total_price'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $total_price = $_POST['total_price'];

        // Check if the quantity is not negative
        if ($quantity < 0) {
            $data = [
                'status' => "gagal",
                'message' => "Quantity cannot be negative"
            ];
            echo json_encode($data);
            exit;
        }

        $sql = "INSERT INTO orders(product_id, quantity, total_price) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'idi', $product_id, $quantity, $total_price);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // UPDATE ORDER
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT['id'], $_PUT['quantity'], $_PUT['total_price'])) {
        $id = $_PUT['id'];
        $quantity = $_PUT['quantity'];
        $total_price = $_PUT['total_price'];

        // Check if the quantity is not negative
        if ($quantity < 0) {
            $data = [
                'status' => "gagal",
                'message' => "Quantity cannot be negative"
            ];
            echo json_encode($data);
            exit;
        }

        $sql = "UPDATE orders SET quantity=?, total_price=? WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'dii', $quantity, $total_price, $id);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // DELETE ORDER
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM orders WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $cek = mysqli_stmt_execute($stmt);

        if ($cek) {
            $data = [
                'status' => "berhasil"
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "gagal"
            ];
            echo json_encode($data);
        }
    } else {
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
}
// CEK INVENTORY -----------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Check inventory for the product
        $check_sql = "SELECT inventory FROM products WHERE id=?";
        $stmt = mysqli_prepare($koneksi, $check_sql);
        mysqli_stmt_bind_param($stmt, 'i', $product_id);
        mysqli_stmt_execute($stmt);
        $inventory = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['inventory'];

        $data = [
            'inventory' => $inventory
        ];
        echo json_encode($data);
    } else {
        // Invalid request, return an error response
        $data = [
            'status' => "gagal",
            'message' => "Invalid request"
        ];
        echo json_encode($data);
    }
}
// FLASH SALE ----------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $discounted_price = $_POST['discounted_price'];

    // Check if the product has enough inventory
    $check_sql = "SELECT inventory FROM products WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $check_sql);
    mysqli_stmt_bind_param($stmt, 'i', $product_id);
    mysqli_stmt_execute($stmt);
    $inventory = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['inventory'];

    if ($inventory >= 1) {
        // Handle flash sale logic here (deduct inventory, create order, etc.)
        // Return success response
        $data = [
            'status' => "berhasil",
            'message' => "Flash sale successful"
        ];
        echo json_encode($data);
    } else {
        // Return error response (out of stock)
        $data = [
            'status' => "gagal",
            'message' => "Product out of stock"
        ];
        echo json_encode($data);
    }
}

// FUNCTIONAL TEST -----------------------------------------------
// Simulasikan beberapa permintaan konkuren untuk membeli produk tertentu dengan harga diskon
function simulasiFlashSale($id_produk, $harga_diskon, $permintaan_konkuren) {
    for ($i = 0; $i < $permintaan_konkuren; $i++) {
        $data = [
            'product_id' => $id_produk,
            'discounted_price' => $harga_diskon
        ];

        // Kirim permintaan POST ke endpoint flash sale
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/testfomotoko/toko.online/flash-sale.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $respons = curl_exec($ch);
        curl_close($ch);

        // Proses respons untuk memeriksa keberhasilan atau kegagalan
        $hasil = json_decode($respons, true);
        if ($hasil['status'] === 'berhasil') {
            // Flash sale berhasil, tangani sesuai kebutuhan
        } elseif ($hasil['status'] === 'gagal') {
            // Flash sale gagal, tangani sesuai kebutuhan
        }
    }
}

// Contoh penggunaan:
$id_produk = 1; // Tentukan ID produk yang ingin Anda jual dalam flash sale
$harga_diskon = 10.99; // Tentukan harga yang didiskon
$permintaan_konkuren = 5; // Tentukan jumlah permintaan konkuren yang ingin Anda uji

// Simulasikan race condition
simulasiFlashSale($id_produk, $harga_diskon, $permintaan_konkuren);
?>
