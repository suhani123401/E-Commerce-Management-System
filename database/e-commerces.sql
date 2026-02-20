CREATE DATABASE e_commmerces;
USE e_commmerces;

-- USERS TABLE (Create this first because other tables depend on it)
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(100) NOT NULL,
    `user_email` VARCHAR(100) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UK_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- PRODUCTS TABLE
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(150) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `category` VARCHAR(100) DEFAULT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT(11) NOT NULL DEFAULT 0,
  `image` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('active','inactive') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_product_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_product_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ORDERS TABLE
CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` INT(11) NOT NULL AUTO_INCREMENT,
    `order_cost` DECIMAL(10,2) NOT NULL,
    `order_status` VARCHAR(100) NOT NULL DEFAULT 'on_hold',
    `user_id` INT(11) NOT NULL,
    `user_phone` VARCHAR(20) NOT NULL,
    `user_address` VARCHAR(255) NOT NULL,
    `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ORDER ITEMS TABLE
CREATE TABLE IF NOT EXISTS `order_items` (ll
    `item_id` INT(11) NOT NULL AUTO_INCREMENT,
    `order_id` INT(11) NOT NULL,
    `product_id` INT(11) NOT NULL,
    `product_name` VARCHAR(225) NOT NULL,
    `image` VARCHAR(225) NOT NULL,
    `user_id` INT(11) NOT NULL,
    `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE orders
ADD COLUMN user_city VARCHAR(100) NOT NULL AFTER user_phone;

ALTER TABLE orders
ADD COLUMN user_city VARCHAR(100) NOT NULL AFTER user_phone;

ALTER TABLE order_items
ADD COLUMN product_price DECIMAL(10,2)  NOT NULL AFTER image;



ALTER TABLE order_items
ADD COLUMN product_quantity int NOT NULL AFTER product_price;

ALTER TABLE users
CHANGE id user_id INT(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE products
CHANGE stock product_quantity INT(11) NOT NULL;


CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE `admin` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL
);

ALTER TABLE admin 
ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL;

ALTER TABLE orders
CHANGE user_id user_id INT(11) NOT NULL FOREIGN KEY;


CREATE TABLE carousel_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    title1 VARCHAR(255),
    title2 VARCHAR(255),
    button_text VARCHAR(50),
    position ENUM('start','center','end') DEFAULT 'center',
    is_active TINYINT(1) DEFAULT 1,
    slide_order INT DEFAULT 0
);
