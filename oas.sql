-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2019 at 12:26 PM
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
(1, 'admin', 'Admin01'),
(2, 'admin', '0f84138dd4bc2114a8750963895ddb25');

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

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`sn`, `articleName`, `articlePath`, `tutorName`, `uploadedDate`, `visible`) VALUES
(1, 'project', 'articles/employment of pharmacy.docx', 'Alabi Wale', '2018-12-19 10:30:52', '1'),
(2, 'project', 'articles/zenoir.sql', 'Adegbite Oluwaseyi', '2018-12-28 12:34:02', '1');

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
  `file_path` varchar(5) NOT NULL,
  `type` enum('','single','multiple') NOT NULL,
  `format` enum('','individual','group') NOT NULL,
  `groupmembers` varchar(250) NOT NULL,
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
  `assignmentId` varchar(25) NOT NULL,
  `sub_AssId` varchar(25) NOT NULL,
  `courseCode` varchar(15) NOT NULL,
  `matricNum` varchar(15) NOT NULL,
  `format` enum('','individual','group') NOT NULL,
  `ass_file_path` varchar(100) NOT NULL,
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
(15, 'CSC_351', ' Networks and Telecommunication', 3, '300', 1, ''),
(16, 'CSC_381', 'Numerical Methods and Analysis', 3, '300', 1, ''),
(17, 'CSC_311', 'Operating Systems 2', 3, '300', 1, 'Odus'),
(18, 'CSC_461', 'Artificial Intelligence', 2, '400', 1, ''),
(19, 'CSC_401', 'Compiler Construction', 3, '400', 1, ''),
(20, 'CSC_451', 'Data Security and Integrity', 3, '400', 1, ''),
(21, 'CSC_421', 'Database Design and Management', 3, '400', 1, ''),
(22, 'CSC_431', 'Fundamentals of Software Engineering', 3, '400', 1, ''),
(23, 'CSC_411', 'Human Computer Interface', 2, '400', 1, ''),
(24, 'CSC_441', 'Introduction to Analogue Computer', 2, '400', 1, ''),
(25, 'CHM_101', 'Chemistry', 2, '100', 1, ''),
(26, 'CHM_111', 'Chemistry Practical', 2, '100', 1, ''),
(27, 'MTH_112', 'Mathematics II', 3, '100', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `groupId` int(11) NOT NULL,
  `group_name` varchar(25) NOT NULL,
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
  `gender` varchar(9) NOT NULL,
  `student_avatar` varchar(250) NOT NULL,
  `password` varchar(45) NOT NULL,
  `current_semester` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sn`, `Name`, `MatricNum`, `courses`, `phone`, `email`, `gender`, `student_avatar`, `password`, `current_semester`) VALUES
(2, 'Oregunwa Segun', '15/0384', '[\"CSC_461\",\"CSC_401\",\"CSC_451\",\"CSC_421\",\"CSC_431\",\"CSC_411\",\"CSC_441\",\"CSC_341\"]', '08105444538', 'oregsgraphix@gmail.com', '', '', '5e1bc091728e94cf976fb93a73174812', '400'),
(3, ' Piniki Endurance', '15/0385', '[\"CSC_461\",\"CSC_401\",\"CSC_421\",\"CSC_431\",\"CSC_411\",\"CSC_441\"]', '08105444538', 'oregsgraphix@gmail.com', '', '', 'd41d8cd98f00b204e9800998ecf8427e', ''),
(5, 'Ogunbajo Michael', '12/0384', '[\"CSC_461\",\"CSC_401\",\"CSC_421\",\"CSC_431\",\"CSC_411\",\"CSC_441\"]', '08105444538', 'banjo@gmail.com', '', '', '5e1bc091728e94cf976fb93a73174812', '1.1'),
(6, 'Adebambo  Paul', '16/0350', '[\"CSC_461\",\"CSC_401\",\"CSC_421\",\"CSC_431\",\"CSC_411\",\"CSC_441\"]', '0813748994', 'adebambo@gmail.com', '', '', '202cb962ac59075b964b07152d234b70', ''),
(7, 'Alabi Damilare', '15/0389', '[\"CSC_461\",\"CSC_401\",\"CSC_421\",\"CSC_431\",\"CSC_411\",\"CSC_441\"]', '0982939949', 'alabi@yahoo.com', '', '', '202cb962ac59075b964b07152d234b70', ''),
(8, 'Alade Ibukun', '12/0900', '[\"CSC_411\",\"CSC_441\"]', '090234566', 'alade@gmail.com', '', '', '5e1bc091728e94cf976fb93a73174812', '');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `sn` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `StaffId` varchar(45) NOT NULL,
  `courses` varchar(150) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`sn`, `Name`, `StaffId`, `courses`, `phone`, `email`, `password`) VALUES
(2, 'Adegbite Oluwaseyi', 'seyi', '[\"CSC_341\",\"CSC_461\",\"CSC_411\"]', '08123449988', 'adegbiteseyi@gmail.com', '5e1bc091728e94cf976fb93a73174812'),
(5, 'Oregunwa Segun', 'oregs', '[\"CSC_351\",\"CSC_461\",\"CSC_421\"]', '8105444538', 'oregsgraphix@gmail.com', '202cb962ac59075b964b07152d234b70');

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
  ADD PRIMARY KEY (`groupId`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sn`),
  ADD UNIQUE KEY `MatricNum` (`MatricNum`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`sn`),
  ADD UNIQUE KEY `StaffId` (`StaffId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
