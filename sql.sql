-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2024 at 10:27 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure for table `merchant`
CREATE TABLE `merchant` (
  `merchant_id` INT(11) NOT NULL AUTO_INCREMENT,
  `merchant_name` ENUM('PhonePe Business', 'SBI Merchant', 'Paytm Business', '') NOT NULL,
  `merchant_username` VARCHAR(100) NOT NULL,
  `merchant_password` VARCHAR(100) NOT NULL,
  `merchant_primary` ENUM('Active', 'InActive') DEFAULT 'InActive',
  `merchant_payupi` ENUM('Show', 'Hide', '') DEFAULT 'Show',
  `merchant_timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `merchant_session` TEXT DEFAULT NULL,
  `merchant_csrftoken` TEXT DEFAULT NULL,
  `merchant_token` TEXT DEFAULT NULL,
  `merchant_qrdata` LONGTEXT DEFAULT NULL,
  `merchant_data` LONGTEXT DEFAULT NULL,
  `merchant_upi` VARCHAR(255) DEFAULT NULL,
  `user_id` BIGINT(20) NOT NULL,
  `status` ENUM('Active', 'InActive', '') NOT NULL,
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table structure for table `plans`
CREATE TABLE `plans` (
  `plan_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `type` ENUM('1 Month', '1 Year') NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `limit` DOUBLE NOT NULL,
  `account_limit` DOUBLE NOT NULL,
  `amount` DOUBLE NOT NULL,
  `status` ENUM('Active', 'InActive') NOT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `plans`
INSERT INTO `plans` (`plan_id`, `type`, `name`, `limit`, `account_limit`, `amount`, `status`) VALUES
(4, '1 Year', 'Yearly Startup', 200000, 25, 11999, 'Active'),
(6, '1 Month', 'Starter Monthly', 2000, 2, 1, 'Active');

-- Table structure for table `siteconfig`
CREATE TABLE `siteconfig` (
  `site_id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `brand` TEXT NOT NULL,
  `logo` LONGTEXT NOT NULL,
  `favicon` TEXT DEFAULT NULL,
  `support` LONGTEXT NOT NULL,
  `whatsapp_link` VARCHAR(255) NOT NULL,
  `notice` LONGTEXT NOT NULL,
  `gateway` LONGTEXT NOT NULL,
  `smsapi_url` VARCHAR(255) NOT NULL,
  `cron_token` VARCHAR(255) DEFAULT NULL,
  `protocol` ENUM('http://', 'https://') NOT NULL,
  `baseurl` TEXT NOT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `siteconfig`
INSERT INTO `siteconfig` (`site_id`, `title`, `brand`, `logo`, `favicon`, `support`, `whatsapp_link`, `notice`, `gateway`, `smsapi_url`, `cron_token`, `protocol`, `baseurl`) VALUES
(1, 'Your Website Name', 'Your Website Name', 'https://imb.org.in/auth/assets/img/smart-pay.png', 'https://imb.org.in/auth/assets/img/smart-pay.png', '+919876543210', 'https://wa.me/+919876543210', 'Phone pe merchant best working!', '{"paytm":{"mid":"#","key":"#"},"upiapi":{"token":"bc69c3-10b264-11bc6a-a200b4-e469fd","secret":"#"}}', 'https://yourwebsiteurl.com/api/user/v2/send_message_url?mobile=91{NUMBER}&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0ODkzNTQ2fQ.JRfDiLGh52EL4XYgy4pSsL63MbC5jZ4bdl2XgdO', 'bc69c3-10b264-11bc6a-a200b4-e469fd', 'https://', 'imb.org.in');

-- Table structure for table `transaction`
CREATE TABLE `transaction` (
  `txn_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `txn_mode` ENUM('INTENT', 'URL') DEFAULT 'INTENT',
  `user_id` BIGINT(20) NOT NULL,
  `merchant_id` BIGINT(20) NOT NULL,
  `merchant_name` ENUM('PhonePe Business', 'SBI Merchant', 'Paytm Business', '') NOT NULL,
  `merchant_upi` VARCHAR(255) NOT NULL,
  `client_orderid` VARCHAR(255) NOT NULL,
  `txn_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `txn_amount` VARCHAR(255) NOT NULL,
  `txn_note` TEXT NOT NULL,
  `product_name` LONGTEXT NOT NULL,
  `customer_name` TEXT NOT NULL,
  `customer_mobile` VARCHAR(10) NOT NULL,
  `customer_email` TEXT NOT NULL,
  `customer_vpa` VARCHAR(255) NOT NULL,
  `bank_orderid` VARCHAR(255) NOT NULL,
  `utr_number` VARCHAR(255) DEFAULT NULL,
  `payment_mode` ENUM('UPI', 'DC', 'CC', 'NB', 'WALLET') DEFAULT 'UPI',
  `payment_token` LONGTEXT NOT NULL,
  `callback_url` TEXT NOT NULL,
  `domain` VARCHAR(255) DEFAULT NULL,
  `webhook_status` ENUM('Success', 'Pending') NOT NULL,
  `status` ENUM('Success', 'Failed', 'Pending') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`txn_id`),
  UNIQUE KEY `bank_orderid` (`bank_orderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `useraccount`
CREATE TABLE `useraccount` (
  `user_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `role` ENUM('Admin', 'User') NOT NULL DEFAULT 'User',
  `username` VARCHAR(10) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `uid_token` VARCHAR(255) NOT NULL,
  `mobile` VARCHAR(10) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `company` VARCHAR(200) NOT NULL,
  `pan` VARCHAR(10) NOT NULL,
  `aadhaar` VARCHAR(12) NOT NULL,
  `location` TEXT NOT NULL,
  `plan_id` BIGINT(20) NOT NULL,
  `plan_type` ENUM('1 Month', '1 Year') NOT NULL,
  `plan_limit` DOUBLE NOT NULL,
  `expire_date` DATE NOT NULL,
  `is_expire` ENUM('Yes', 'No', 'Alert') NOT NULL,
  `token` VARCHAR(255) DEFAULT NULL,
  `webhook_url` TEXT DEFAULT NULL,
  `create_date` DATETIME DEFAULT CURRENT_TIMESTAMP(),
  `status` ENUM('Active', 'InActive') NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `useraccount`
INSERT INTO `useraccount` (`user_id`, `role`, `username`, `password`, `uid_token`, `mobile`, `email`, `name`, `company`, `pan`, `aadhaar`, `location`, `plan_id`, `plan_type`, `plan_limit`, `expire_date`, `is_expire`, `token`, `webhook_url`, `create_date`, `status`) VALUES
(61, 'Admin', '9876543210', '9876543210', 'NjE6OTg3NjU0MzIxMA==', '9876543210', 'helloimb@gmail.com', 'Imb Payment', 'Imb Payment', 'CKLPA5432A', '969696969696', 'Imb', 6, '1 Month', 1997, '2024-07-18', 'No', 'bc69c3-10b264-11bc6a-a200b4-e469fd', NULL, '2029-04-01 18:42:54', 'Active');

COMMIT;
