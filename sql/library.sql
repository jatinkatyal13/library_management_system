-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 30, 2016 at 01:20 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `user` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`user`, `name`) VALUES
('jatin@library', 'Jatin Katyal');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(5) NOT NULL,
  `book_name` varchar(50) NOT NULL,
  `isbn` int(11) NOT NULL,
  `volume` varchar(10) NOT NULL,
  `writer` varchar(50) NOT NULL,
  `pub` varchar(50) NOT NULL,
  `pages` int(11) NOT NULL,
  `desc` text NOT NULL,
  `pic_link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `isbn`, `volume`, `writer`, `pub`, `pages`, `desc`, `pic_link`) VALUES
(1, 'Mastering C++', 1234, '1', 'Yashwant', 'Mc Graw Hills', 101, 'something', NULL),
(2, 'Physics', 1123, '2', 'Jatin Katyal', 'HMRITM', 1001, 'some description', NULL),
(3, 'Chemistry', 1111, '2', 'Ishaan Sharma', 'HMRITM', 101, 'some description', NULL),
(6, 'Inferno', 1212, '1', 'Dan Brown', 'Mc Graw Hills', 101, 'A decent book with an amazing plot', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `issue_details`
--

CREATE TABLE `issue_details` (
  `issue_id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `book_id` varchar(50) NOT NULL,
  `req_date` date NOT NULL,
  `last_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `issue_details`
--

INSERT INTO `issue_details` (`issue_id`, `user`, `book_id`, `req_date`, `last_date`) VALUES
(10, 'sameer', '3', '2016-11-01', '2016-11-08'),
(13, 'jatin', '6', '2016-11-04', '2016-11-11');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `desig` int(1) NOT NULL,
  `dp_link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user`, `pass`, `desig`, `dp_link`) VALUES
('ishaan', '3dc1e4c3bc5b2ae63520627ea44df7fd', 4, NULL),
('jatin', '7fd615ba249ecd0c26ff3bea4ac33ff6', 4, 'dp/dp_jatin.jpg'),
('jatin@library', '7fd615ba249ecd0c26ff3bea4ac33ff6', 1, NULL),
('jatinkatyal', '7fd615ba249ecd0c26ff3bea4ac33ff6', 2, 'dp/dp_jatinkatyal.jpg'),
('sameer', '7fd615ba249ecd0c26ff3bea4ac33ff6', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `req_id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
  `req_date` date NOT NULL,
  `last_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_details`
--

CREATE TABLE `staff_details` (
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `fac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_details`
--

INSERT INTO `staff_details` (`user`, `name`, `fac_id`) VALUES
('jatinkatyal', 'Jatin Katyal', 1001);

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `enroll_num` varchar(15) NOT NULL,
  `reg_date` date NOT NULL,
  `total_issued` int(11) NOT NULL,
  `vault` int(11) NOT NULL,
  `fine_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`user`, `name`, `enroll_num`, `reg_date`, `total_issued`, `vault`, `fine_paid`) VALUES
('ishaan', 'Ishaan', '02413302716', '2016-11-07', 0, 2, 0),
('jatin', 'Jatin Katyal', '02613302716', '2016-10-10', 10, 2, 0),
('sameer', 'Sameer Katyal', '02513302716', '2016-11-10', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_details`
--

CREATE TABLE `teacher_details` (
  `user` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `reg_date` date NOT NULL,
  `fac_id` varchar(50) NOT NULL,
  `total_issued` int(11) NOT NULL,
  `vault` int(11) NOT NULL,
  `fine_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `issue_details`
--
ALTER TABLE `issue_details`
  ADD PRIMARY KEY (`issue_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `enroll_num` (`enroll_num`);

--
-- Indexes for table `teacher_details`
--
ALTER TABLE `teacher_details`
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `fac_id` (`fac_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `issue_details`
--
ALTER TABLE `issue_details`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
