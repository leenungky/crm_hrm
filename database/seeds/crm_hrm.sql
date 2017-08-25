-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2017 at 01:03 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm_hrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `company_id`, `name`, `address`, `created_at`) VALUES
(2, 13, 'Dago', 'Bandung', '2017-08-05 01:37:20'),
(3, 13, 'jogja', 'jl kepatihan 21', '2017-08-08 01:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `phone`, `email`, `address`, `created_at`) VALUES
(13, 'asep', '085221597305', 'lee.nungky@gmail.com', 'Jalan raya veteran3 kp tapos rt 02 rw 03 desa citapen', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `company_payment`
--

CREATE TABLE `company_payment` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_payment`
--

INSERT INTO `company_payment` (`id`, `company_id`, `payment_date`) VALUES
(11, 13, '2017-08-01 07:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `days` int(11) NOT NULL,
  `isdeduction` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_group` tinyint(1) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `company_id`, `name`, `is_group`, `parent_id`, `created_at`) VALUES
(25, 13, 'Management', 1, 0, '2017-08-08 12:35:13'),
(28, 13, 'Dewan Direksi', 0, 25, '2017-08-08 12:36:29'),
(29, 13, 'Presiden Direktur', 0, 25, '2017-08-08 12:36:45'),
(30, 13, 'General Affair', 0, 0, '2017-08-08 12:37:01'),
(31, 13, 'Keuangan', 1, 0, '2017-08-08 12:42:04'),
(32, 13, 'Finance', 0, 31, '2017-08-19 04:57:58'),
(33, 13, 'nun', 0, 1, '2017-08-25 02:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `grade` char(1) NOT NULL,
  `major_study` varchar(50) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(5) NOT NULL,
  `gpa` varchar(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `company_id`, `employee_id`, `nama`, `grade`, `major_study`, `from`, `to`, `gpa`, `description`, `created_at`) VALUES
(2, 13, 2, 'tolis', 'A', 'IPAA', 2012, 2013, '2.5', 'aa', '2017-08-12 10:09:34'),
(3, 13, 3, 'tolis', 'A', 'IPA', 2012, 2013, '2.5', 'aa', '2017-08-12 11:35:57'),
(6, 13, 0, 'tolis1', 'A', 'IPA1', 2012, 2013, '100', 'cc', '2017-08-15 03:34:44'),
(14, 13, 1, 'tolis', 'A', 'IPA', 2012, 2013, '2.5', 'aa', '2017-08-16 06:14:08'),
(15, 13, 4, 'tolis', 'A', 'IPA', 2012, 2013, '2.5', 'aa', '2017-08-25 03:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `education_relation`
--

CREATE TABLE `education_relation` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `sex` char(1) NOT NULL,
  `jobtitle_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `company_id`, `nik`, `name`, `birth_place`, `birth_date`, `sex`, `jobtitle_id`, `department_id`, `branch_id`, `phone`, `address`, `email`, `nationality`, `created_at`) VALUES
(2, 13, '001', 'nungky', 'tolis', '2017-08-12', 'L', 1, 28, 2, '085221597305', 'jakarta', '', '', '2017-08-15 03:37:28'),
(3, 13, '002', 'asep', 'tolis', '2017-08-12', 'L', 1, 29, 3, '085221597305', 'jakarta', 'lee.nungky@gmail.com', 'Indonesia', '2017-08-16 06:14:08'),
(4, 13, '003', 'indra', 'jogj', '2017-08-25', 'L', 2, 28, 2, '085221597305', 'jakarta', 'lee.nungky@gmail.com', 'Indonesia', '2017-08-25 03:53:25');

-- --------------------------------------------------------

--
-- Table structure for table `employee_payroll`
--

CREATE TABLE `employee_payroll` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `gaji_dan_tunjangan` varchar(60) DEFAULT NULL,
  `gaji_pokok` varchar(60) DEFAULT NULL,
  `kesehatan` varchar(60) DEFAULT NULL,
  `potongan` varchar(60) DEFAULT NULL,
  `potongan_kesehatan` varchar(60) DEFAULT NULL,
  `pensiun` varchar(60) DEFAULT NULL,
  `lembur` varchar(60) DEFAULT NULL,
  `absensi` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_permition`
--

CREATE TABLE `employee_permition` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `propose` date NOT NULL,
  `dari` date NOT NULL,
  `sampai` date NOT NULL,
  `day` int(11) NOT NULL,
  `checked_by` int(11) NOT NULL,
  `checked_date` date NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approved_date` date NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_permition`
--

INSERT INTO `employee_permition` (`id`, `company_id`, `employee_id`, `reason`, `propose`, `dari`, `sampai`, `day`, `checked_by`, `checked_date`, `approved_by`, `approved_date`, `description`) VALUES
(4, 13, 3, 'a', '2017-12-12', '2017-12-12', '2015-12-12', 2, 3, '0000-00-00', 2, '0000-00-00', 'Testing'),
(12, 13, 2, 'asep', '2017-08-24', '2017-08-24', '2017-08-24', 2, 2, '2017-08-24', 2, '2017-08-24', 'jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `relation_id` int(11) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `sex` char(1) NOT NULL,
  `education` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`id`, `company_id`, `employee_id`, `nama`, `relation_id`, `birth_place`, `birth_date`, `sex`, `education`, `description`, `created_at`) VALUES
(3, 13, 2, 'a', 2, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-12 10:09:34'),
(4, 13, 2, 'a', 1, 'b', '2015-12-12', 'L', 'SD', 'aa', '2017-08-12 10:09:34'),
(5, 13, 3, 'a', 2, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-12 11:35:57'),
(6, 13, 3, 'a', 1, 'b', '2015-12-12', 'L', 'SD', 'aa', '2017-08-12 11:35:57'),
(11, 13, 0, 'a', 2, 'b', '2015-12-12', 'L', 'SD1', 'ee', '2017-08-15 03:34:44'),
(12, 13, 0, 'a', 1, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-15 03:34:44'),
(27, 13, 1, 'a', 2, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-16 06:14:08'),
(28, 13, 1, 'a', 1, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-16 06:14:08'),
(29, 13, 4, 'a', 2, 'b', '2015-12-12', 'P', 'SD', 'aa', '2017-08-25 03:53:26'),
(30, 13, 4, 'a', 1, 'b', '2015-12-12', 'L', 'SD', 'aa', '2017-08-25 03:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `family_relation`
--

CREATE TABLE `family_relation` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `family_relation`
--

INSERT INTO `family_relation` (`id`, `company_id`, `name`, `description`, `created_at`) VALUES
(1, 13, 'Bapak', 'Bapak', '2017-08-05 01:40:05'),
(2, 13, 'ibu', 'ibu', '2017-08-05 01:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitle`
--

CREATE TABLE `jobtitle` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobtitle`
--

INSERT INTO `jobtitle` (`id`, `company_id`, `name`, `description`, `created_at`) VALUES
(1, 13, 'Management', 'Management', '2017-08-05 01:02:26'),
(2, 13, 'Operational', 'Operational', '2017-08-05 01:02:37');

-- --------------------------------------------------------

--
-- Table structure for table `paycat`
--

CREATE TABLE `paycat` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `formula` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paycat`
--

INSERT INTO `paycat` (`id`, `company_id`, `name`, `formula`, `description`, `created_at`) VALUES
(1, 13, 'cat1', 'Gaji Pokok + Kesehatan + Lembur ', '', '2017-08-22 01:47:56'),
(2, 13, 'test', '( Gaji Pokok  + Kesehatan  + Lembur ) - (Potongan Kesehatan + Pensiun + Absensi ) + Potongan Kesehatan + Potongan Kesehatan + Potongan Kesehatan + Potongan Kesehatan', '', '2017-08-22 03:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `paycat_employe`
--

CREATE TABLE `paycat_employe` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `paycat_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paycat_employe`
--

INSERT INTO `paycat_employe` (`id`, `company_id`, `paycat_id`, `employee_id`, `created_at`) VALUES
(3, 13, 1, 4, '2017-08-25'),
(5, 13, 2, 2, '2017-08-26'),
(6, 13, 2, 3, '2017-08-26');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `is_group` tinyint(1) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `company_id`, `name`, `is_group`, `parent_id`, `created_at`) VALUES
(28, 13, 'Gaji Dan Tunjangan', 1, 0, '2017-08-26 04:30:04'),
(30, 13, 'Gaji Pokok', 0, 28, '2017-08-26 04:30:38'),
(31, 13, 'Kesehatan', 0, 28, '2017-08-26 04:30:47'),
(32, 13, 'Potongan', 1, 0, '2017-08-26 04:30:57'),
(33, 13, 'Potongan Kesehatan', 0, 32, '2017-08-26 04:31:09'),
(34, 13, 'Pensiun', 0, 32, '2017-08-26 04:31:18'),
(35, 13, 'Lembur', 0, 28, '2017-08-26 04:31:35'),
(36, 13, 'Absensi', 0, 32, '2017-08-26 04:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'administrator', '', '2017-07-04 00:00:00', '2017-07-04 00:00:00'),
(2, 'admin', '', '2017-07-04 00:00:00', '2017-07-04 00:00:00'),
(3, 'staff', 'staff', '2017-07-04 00:00:00', '2017-07-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_id` int(6) DEFAULT NULL,
  `agent_id` int(11) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `company_id`, `role_id`, `agent_id`, `password`, `email`, `first_name`, `last_name`, `avatar`, `active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(118, 13, 1, 0, '$2y$10$/XAkWkUZFlmDVucMbEkg6uI.QYrXU.DUUw3/TD0bJKGUCn2GBHFDa', 'lee.nungky@gmail.com', 'asep', NULL, NULL, NULL, '2017-08-26 03:59:25', 'HgRGRodjNc17Hp9VRZbeeANztOxLyyR0veklLXLWXNAcH6sdTOQ1ZWWUjLp8', '2017-08-01 00:04:56', '2017-08-25 20:58:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_payment`
--
ALTER TABLE `company_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `id` (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `education_relation`
--
ALTER TABLE `education_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_payroll`
--
ALTER TABLE `employee_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_permition`
--
ALTER TABLE `employee_permition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_relation`
--
ALTER TABLE `family_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobtitle`
--
ALTER TABLE `jobtitle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paycat`
--
ALTER TABLE `paycat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paycat_employe`
--
ALTER TABLE `paycat_employe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `company_payment`
--
ALTER TABLE `company_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `cuti`
--
ALTER TABLE `cuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `education_relation`
--
ALTER TABLE `education_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employee_payroll`
--
ALTER TABLE `employee_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_permition`
--
ALTER TABLE `employee_permition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `family`
--
ALTER TABLE `family`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `family_relation`
--
ALTER TABLE `family_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `paycat`
--
ALTER TABLE `paycat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `paycat_employe`
--
ALTER TABLE `paycat_employe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
