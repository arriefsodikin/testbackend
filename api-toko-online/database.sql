-- Membuat tabel vouchers
CREATE TABLE vouchers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    promo DECIMAL(10, 2) NOT NULL
);

-- Membuat tabel products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    voucher_id INT,
    name VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10, 2) NOT NULL,
    inventory INT NOT NULL,
    FOREIGN KEY (voucher_id) REFERENCES vouchers(id)
);

-- Membuat tabel orders
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);
