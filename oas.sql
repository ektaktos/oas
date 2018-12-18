-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2018 at 03:33 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oas`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `sn` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`sn`, `username`, `password`) VALUES
(1, 'admin', 'Admin01');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `sn` int(11) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `tutor_id` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `visible` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `sn` int(11) NOT NULL,
  `articleName` varchar(45) NOT NULL,
  `articlePath` varchar(45) NOT NULL,
  `tutorName` varchar(25) NOT NULL,
  `uploadedDate` datetime NOT NULL,
  `visible` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignmentdetails`
--

CREATE TABLE `assignmentdetails` (
  `sn` int(11) NOT NULL,
  `assignmentId` varchar(20) NOT NULL,
  `sub_AssId` varchar(20) NOT NULL,
  `assignmentQuestion` varchar(250) NOT NULL,
  `tutor` varchar(45) NOT NULL,
  `tutorId` varchar(15) NOT NULL,
  `courseCode` varchar(15) NOT NULL,
  `type` enum('','single','multiple') NOT NULL,
  `format` enum('','individual','group') NOT NULL,
  `dateAssigned` datetime NOT NULL,
  `submissionDate` datetime NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignmentresult`
--

CREATE TABLE `assignmentresult` (
  `sn` int(11) NOT NULL,
  `courseCode` varchar(15) NOT NULL,
  `matricNum` varchar(15) NOT NULL,
  `Ass01` int(15) NOT NULL,
  `Ass02` int(11) NOT NULL,
  `Ass03` int(11) NOT NULL,
  `Ass04` int(11) NOT NULL,
  `Ass05` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignmentsubmission`
--

CREATE TABLE `assignmentsubmission` (
  `sn` int(11) NOT NULL,
  `assignmentId` varchar(15) NOT NULL,
  `sub_AssId` varchar(10) NOT NULL,
  `courseCode` varchar(15) NOT NULL,
  `matricNum` varchar(15) NOT NULL,
  `format` enum('','individual','group') NOT NULL,
  `ass_file_path` varchar(45) NOT NULL,
  `ass_answer` text NOT NULL,
  `status` varchar(15) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `sn` int(11) NOT NULL,
  `courseCode` varchar(45) NOT NULL,
  `courseName` text NOT NULL,
  `unit` int(11) NOT NULL,
  `level` varchar(15) NOT NULL,
  `semester` int(11) NOT NULL,
  `tutor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`sn`, `courseCode`, `courseName`, `unit`, `level`, `semester`, `tutor`) VALUES
(1, 'GES_101', 'USe of English 1', 2, '100', 1, 'Tim01'),
(2, 'GES_102', 'Computer in Modern Society', 3, '100', 2, 'Tim01'),
(5, 'CSC_101', 'Introduction to computer science', 3, '100', 1, ''),
(6, 'CSC_251', 'Algorithms and data structures', 3, '200', 1, ''),
(7, 'CSC_201', 'Introduction to Java programming ', 3, '200', 1, ''),
(8, 'CSC_231', 'Introduction to Digital computer systems', 2, '200', 1, ''),
(9, 'CSC_221', 'Logic design', 3, '200', 1, ''),
(10, 'CSC_211', 'Operating System 1', 3, '200', 1, ''),
(11, 'CSC_331', 'Computer hardware system studies', 3, '300', 1, ''),
(12, 'CSC_361', 'Formal Theory of Computation and Automata ', 3, '300', 1, ''),
(13, 'CSC_341', 'Introduction to Linux administration', 3, '300', 1, ''),
(14, 'CSC_321', 'Introduction to Operations research', 3, '300', 1, ''),
(15, 'CSC 351', ' Networks and Telecommunication', 3, '300', 1, ''),
(16, 'CSC_381', 'Numerical Methods and Anakysis', 3, '300', 1, ''),
(17, 'CSC_311', 'Operating Systems 2', 3, '300', 1, ''),
(18, 'CSC_461', 'Artificial Intelligence', 2, '400', 1, ''),
(19, 'CSC_401', 'Compiler Construction', 3, '400', 1, ''),
(20, 'CSC_451', 'Data Security and Integrity', 3, '400', 1, ''),
(21, 'CSC_421', 'Database Design and Management', 3, '400', 1, ''),
(22, 'CSC_431', 'Fundamentals of Software Engineering', 3, '400', 1, ''),
(23, 'CSC_411', 'Human Computer Interface', 2, '400', 1, ''),
(24, 'CSC_441', 'Introduction to Analogue Computer', 2, '400', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `sn` int(11) NOT NULL,
  `group_name` varchar(25) NOT NULL,
  `groupId` varchar(25) NOT NULL,
  `courseCode` varchar(15) NOT NULL,
  `members` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `sn` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `MatricNum` varchar(15) NOT NULL,
  `courses` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `current_semester` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `sn` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `courses` varchar(150) NOT NULL,
  `StaffId` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`sn`, `Name`, `courses`, `StaffId`, `phone`, `email`, `password`) VALUES
(1, 'Alabi Wale', '[\"GES_102\",\"GES_101\"]', 'Tim01', '08101662910', 'tim01@gmail.com', 'ddc4295258a8253c08c9a88809c4e880');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `assignmentdetails`
--
ALTER TABLE `assignmentdetails`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `assignmentresult`
--
ALTER TABLE `assignmentresult`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `assignmentsubmission`
--
ALTER TABLE `assignmentsubmission`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`sn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignmentdetails`
--
ALTER TABLE `assignmentdetails`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignmentresult`
--
ALTER TABLE `assignmentresult`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assignmentsubmission`
--
ALTER TABLE `assignmentsubmission`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
