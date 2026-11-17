CREATE DATABASE IF NOT EXISTS soul_society_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE soul_society_store;
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(160) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL, role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE categories (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(80) NOT NULL UNIQUE
);
CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY, category_id INT NOT NULL, name VARCHAR(150) NOT NULL,
 description TEXT NOT NULL, price DECIMAL(10,2) NOT NULL, stock INT NOT NULL DEFAULT 0,
 image VARCHAR(500) DEFAULT NULL, active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(category_id) REFERENCES categories(id)
);
CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, total DECIMAL(10,2) NOT NULL,
 payment_method ENUM('PIX','Boleto','Cartão') NOT NULL, status VARCHAR(30) NOT NULL DEFAULT 'Confirmado',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id)
);
CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY, order_id INT NOT NULL, product_id INT NOT NULL,
 quantity INT NOT NULL, unit_price DECIMAL(10,2) NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY(product_id) REFERENCES products(id)
);
INSERT INTO categories(name) VALUES ('Vestuário'),('Acessórios'),('Colecionáveis'),('Equipamentos');
INSERT INTO products(category_id,name,description,price,stock,image) VALUES
(3,'Figure Ichigo Kurosaki','Figure colecionável do substituto de Shinigami. Um item indispensável para fãs de Bleach.',189.90,12,'https://images.unsplash.com/photo-1608889175123-8ee362201f81?auto=format&fit=crop&w=900&q=85'),
(4,'Réplica Zanpakutō','Réplica decorativa inspirada nas espadas dos ceifeiros de almas. Produto para exposição.',249.90,7,'https://images.unsplash.com/photo-1584811644165-33db3b146db1?auto=format&fit=crop&w=900&q=85'),
(1,'Camiseta Gotei 13','Camiseta preta com estampa temática da Soul Society.',79.90,25,'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=900&q=85'),
(2,'Colar Hōgyoku','Acessório temático inspirado no misterioso artefato de Bleach.',49.90,18,'https://images.unsplash.com/photo-1611652022419-a9419f74343d?auto=format&fit=crop&w=900&q=85'),
(3,'Poster Soul Society','Poster decorativo com arte inspirada no universo dos Shinigami.',39.90,30,'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&w=900&q=85'),
(1,'Moletom Bankai','Moletom preto com identidade visual Bankai.',159.90,10,'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=900&q=85');
