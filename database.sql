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


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u525659666_hello`
--

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `merchant_id` int(11) NOT NULL,
  `merchant_name` enum('PhonePe Business','SBI Merchant','Paytm Business','') NOT NULL,
  `merchant_username` varchar(100) NOT NULL,
  `merchant_password` varchar(100) NOT NULL,
  `merchant_primary` enum('Active','InActive') DEFAULT 'InActive',
  `merchant_payupi` enum('Show','Hide','') DEFAULT 'Show',
  `merchant_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `merchant_session` text DEFAULT NULL,
  `merchant_csrftoken` text DEFAULT NULL,
  `merchant_token` text DEFAULT NULL,
  `merchant_qrdata` longtext DEFAULT NULL,
  `merchant_data` longtext DEFAULT NULL,
  `merchant_upi` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` enum('Active','InActive','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` bigint(20) NOT NULL,
  `type` enum('1 Month','1 Year') NOT NULL,
  `name` varchar(200) NOT NULL,
  `limit` double NOT NULL,
  `account_limit` double NOT NULL,
  `amount` double NOT NULL,
  `status` enum('Active','InActive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `type`, `name`, `limit`, `account_limit`, `amount`, `status`) VALUES
(4, '1 Year', 'Yearly Startup', 200000, 25, 11999, 'Active'),
(6, '1 Month', 'Starter Monthely', 2000, 2, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `siteconfig`
--

CREATE TABLE `siteconfig` (
  `site_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `brand` text NOT NULL,
  `logo` longtext NOT NULL,
  `favicon` text DEFAULT NULL,
  `support` longtext NOT NULL,
  `whatsapp_link` varchar(255) NOT NULL,
  `notice` longtext NOT NULL,
  `gateway` longtext NOT NULL,
  `smsapi_url` varchar(255) NOT NULL,
  `cron_token` varchar(255) DEFAULT NULL,
  `protocol` enum('http://','https://') NOT NULL,
  `baseurl` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siteconfig`
--

INSERT INTO `siteconfig` (`site_id`, `title`, `brand`, `logo`, `favicon`, `support`, `whatsapp_link`, `notice`, `gateway`, `smsapi_url`, `cron_token`, `protocol`, `baseurl`) VALUES
(1, 'Your Website Name', 'Your Website Name', 'https://imb.org.in/auth/assets/img/smart-pay.png', 'https://imb.org.in/auth/assets/img/smart-pay.png', '+919876543210', 'https://wa.me/+919876543210', 'Phone pe merchant best working! ', '{\"paytm\":{\"mid\":\"#\",\"key\":\"#\"},\"upiapi\":{\"token\":\"bc69c3-10b264-11bc6a-a200b4-e469fd\",\"secret\":\"#\"}}', 'https://yourwebsiteurl.com/api/user/v2/send_message_url?mobile=91{NUMBER}&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJLYTN6b3pEc2xrbTZzU3FVTk00OFMyV1ZHN3ZPQ0VlUyIsInJvbGUiOiJ1c2VyIiwiaWF0IjoxNzA0ODkzNTQ2fQ.JRfDiLGh52EL4XYgy4pSsL63MbC5jZ4bdl2XgdO', 'bc69c3-10b264-11bc6a-a200b4-e469fd', 'https://', 'imb.org.in');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `txn_id` bigint(20) NOT NULL,
  `txn_mode` enum('INTENT','URL') DEFAULT 'INTENT',
  `user_id` bigint(20) NOT NULL,
  `merchant_id` bigint(20) NOT NULL,
  `merchant_name` enum('PhonePe Business','SBI Merchant','Paytm Business','') NOT NULL,
  `merchant_upi` varchar(255) NOT NULL,
  `client_orderid` varchar(255) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT current_timestamp(),
  `txn_amount` varchar(255) NOT NULL,
  `txn_note` text NOT NULL,
  `product_name` longtext NOT NULL,
  `customer_name` text NOT NULL,
  `customer_mobile` varchar(10) NOT NULL,
  `customer_email` text NOT NULL,
  `customer_vpa` varchar(255) NOT NULL,
  `bank_orderid` varchar(255) NOT NULL,
  `utr_number` varchar(255) DEFAULT NULL,
  `payment_mode` enum('UPI','DC','CC','NB','WALLET') DEFAULT 'UPI',
  `payment_token` longtext NOT NULL,
  `callback_url` text NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `webhook_status` enum('Success','Pending') NOT NULL,
  `status` enum('Success','Failed','Pending') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `user_id` bigint(20) NOT NULL,
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `username` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `uid_token` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `email` varchar(150) NOT NULL,
  `name` varchar(100) NOT NULL,
  `company` varchar(200) NOT NULL,
  `pan` varchar(10) NOT NULL,
  `aadhaar` varchar(12) NOT NULL,
  `location` text NOT NULL,
  `plan_id` bigint(20) NOT NULL,
  `plan_type` enum('1 Month','1 Year') NOT NULL,
  `plan_limit` double NOT NULL,
  `expire_date` date NOT NULL,
  `is_expire` enum('Yes','No','Alert') NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `webhook_url` text DEFAULT NULL,
  `create_date` datetime DEFAULT current_timestamp(),
  `status` enum('Active','InActive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`user_id`, `role`, `username`, `password`, `uid_token`, `mobile`, `email`, `name`, `company`, `pan`, `aadhaar`, `location`, `plan_id`, `plan_type`, `plan_limit`, `expire_date`, `is_expire`, `token`, `webhook_url`, `create_date`, `status`) VALUES
(61, 'Admin', '9876543210', '9876543210', 'NjE6OTg3NjU0MzIxMA==', '9876543210', 'helloimb@gmail.com', 'Imb Payment ', 'Imb Payment ', 'CKLPA5432A', '969696969696', 'Imb', 6, '1 Month', 1997, '2024-07-18', 'No', 'bc69c3-10b264-11bc6a-a200b4-e469fd', NULL, '2029-04-01 18:42:54', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`merchant_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `siteconfig`
--
ALTER TABLE `siteconfig`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`txn_id`),
  ADD UNIQUE KEY `bank_orderid` (`bank_orderid`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `merchant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `siteconfig`
--
ALTER TABLE `siteconfig`
  MODIFY `site_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `txn_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
