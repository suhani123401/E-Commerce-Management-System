create database e-commmerce;
use e-commmerce;


CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('admin', 'customer') DEFAULT 'customer',
 `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `created_by` INT(11) DEFAULT NULL ,
   `updated_by` INT(11) DEFAULT NULL,
   `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk_customer_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
   `created_by` INT(11) DEFAULT NULL ,
   `updated_by` INT(11) DEFAULT NULL,
   `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk_customer_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` VARCHAR(50) NOT NULL UNIQUE,
  `customer_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Pending','Processing','Delivered','Cancelled') DEFAULT 'Pending',
  `payment_method` VARCHAR(50) DEFAULT 'Cash on Delivery',
  `delivery_address` TEXT DEFAULT NULL,
  `delivery_date` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `created_by` INT(11) DEFAULT NULL ,
   `updated_by` INT(11) DEFAULT NULL,
   `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk_customer_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `customers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `country` VARCHAR(100) DEFAULT 'Nepal',
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `created_by` INT(11) DEFAULT NULL ,
   `updated_by` INT(11) DEFAULT NULL,
   `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk_customer_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `payment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `payment_method` VARCHAR(50) NOT NULL,
  `payment_status` ENUM('Pending', 'Completed', 'Failed', 'Refunded') DEFAULT 'Pending',
  `amount` DECIMAL(10,2) NOT NULL,
  `transaction_id` VARCHAR(100) DEFAULT NULL,
  `payment_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `created_by` INT(11) DEFAULT NULL ,
   `updated_by` INT(11) DEFAULT NULL,
   `updated_on` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk_customer_created_by` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_customer_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE users
ADD full_name VARCHAR(100) NOT NULL  AFTER id;

ALTER TABLE customers AUTO_INCREMENT = 1;


CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    subject VARCHAR(200),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE orders
ADD COLUMN username VARCHAR(100) NOT NULL AFTER customer_id;

ALTER TABLE orders
ADD COLUMN email VARCHAR(100) NOT NULL AFTER username;
-- 1. Select the database you are using
USE e-commerce;



ALTER TABLE orders
ADD COLUMN phone VARCHAR(20) NOT NULL AFTER email,
ADD COLUMN city VARCHAR(100) NOT NULL AFTER phone,
ADD COLUMN address TEXT NOT NULL AFTER city;










