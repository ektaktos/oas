-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2018 at 07:00 PM
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

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`sn`, `title`, `content`, `tutor_id`, `date`, `visible`) VALUES
(1, 'New Announcement', 'zncboUJNmp:LC&lt;APSOICkmsa cjklm slKCN lzxcj', 'Tim01', '2018-10-11 04:45:54', '1'),
(2, 'New Announcement 2', 'kcm zcm, xz.cmzckmcsf9jfkdi oij98hdsfijfpasioj', 'Tim01', '2018-10-11 04:46:23', '1'),
(3, 'New Announcement 3', 'dmvmlkdfndfjdnfsladjfpasiljasfpi', 'Tim01', '2018-10-11 04:49:34', '1');

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
(1, 'GES 101 handout', 'articles/questions.txt', 'Tim01', '2018-09-06 12:17:27', '1');

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

--
-- Dumping data for table `assignmentdetails`
--

INSERT INTO `assignmentdetails` (`sn`, `assignmentId`, `sub_AssId`, `assignmentQuestion`, `tutor`, `tutorId`, `courseCode`, `type`, `format`, `dateAssigned`, `submissionDate`, `score`) VALUES
(1, 'Ass01', '', 'Who Discovered River Niger', 'Wale', 'Tim01', 'GES_101', 'single', 'individual', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
(2, 'Ass03', '', 'How old was Mungo Park when he died?', 'Wale', 'Tim01', 'GES_102', 'single', 'individual', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 10),
(7, 'Ass04', '', 'question_files/7389-translation-authors.rtf', 'Alabi Wale', 'Tim01', 'GES_101', 'single', 'individual', '2018-09-04 04:54:44', '2016-07-02 13:52:00', 15),
(20, 'Ass02', 'Ass02_1', 'ldmz.kn d.kvns;gkd;kdl/mvdk', 'Alabi Wale', 'Tim01', 'GES_102', 'multiple', 'individual', '2018-11-30 09:58:02', '2018-12-30 18:30:00', 2),
(21, 'Ass02', 'Ass02_2', 'vbhsdbodslznkmv', 'Alabi Wale', 'Tim01', 'GES_102', 'multiple', 'individual', '2018-11-30 09:58:02', '2018-12-30 18:30:00', 3),
(22, 'Ass02', 'Ass02_3', ',vdfds.klvndfkbnfkgngneo;wgno', 'Alabi Wale', 'Tim01', 'GES_102', 'multiple', 'individual', '2018-11-30 09:58:02', '2018-12-30 18:30:00', 3),
(23, 'Ass02', 'Ass02_4', 'lfwd;.kvnefkgnw;qkgnfkogner;gw/o', 'Alabi Wale', 'Tim01', 'GES_102', 'multiple', 'individual', '2018-11-30 09:58:02', '2018-12-30 18:30:00', 3),
(25, 'GES102_Ass01', '', 'lm\'bvlfms\'bbdk\'psjfodsygfuhjdsfoies;', 'Alabi Wale', 'Tim01', 'GES_102', 'single', '', '2018-12-06 08:32:12', '2018-12-18 23:40:00', 5),
(26, 'GES102_Ass02', '', 'kjdfbsdkjvhbdsfhsagfsakufbsdvhgsdfusbdkuyasdgfadsku', 'Alabi Wale', 'Tim01', 'GES_102', 'single', 'group', '2018-12-12 12:27:49', '2018-12-26 00:30:00', 10);

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

--
-- Dumping data for table `assignmentresult`
--

INSERT INTO `assignmentresult` (`sn`, `courseCode`, `matricNum`, `Ass01`, `Ass02`, `Ass03`, `Ass04`, `Ass05`) VALUES
(1, 'GES_101', '13/0274', 8, 0, 0, 0, 0),
(2, 'GES_102', '13/0274', 0, 10, 0, 0, 0),
(3, 'GES_102', '13/0297', 0, 10, 0, 0, 0);

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

--
-- Dumping data for table `assignmentsubmission`
--

INSERT INTO `assignmentsubmission` (`sn`, `assignmentId`, `sub_AssId`, `courseCode`, `matricNum`, `format`, `ass_file_path`, `ass_answer`, `status`, `date`) VALUES
(1, 'Ass02', 'Ass02_1', 'GES_102', '13/0274', '', '', 'hboijhmkjpoi;lkkm;okl', 'UnGraded', '2018-12-06 10:48:09'),
(2, 'Ass02', 'Ass02_2', 'GES_102', '13/0274', '', '', 'mvmpdvnslijweapgidkvmpd;adfb', 'UnGraded', '2018-12-06 10:57:03'),
(3, 'Ass02', 'Ass02_3', 'GES_102', '13/0274', '', '', 'mvmpdvnslijweapgidkvmpd;adfb', 'UnGraded', '2018-12-06 10:59:07'),
(6, 'GES102_Ass02', '', 'GES_102', 'Group1', 'group', 'graded_ass_files/n.txt', '', 'Graded', '2018-12-12 02:03:31');

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
(3, 'GES_201', 'Use of something', 2, '200', 1, 'Tim01'),
(4, 'GES_202', 'Use of Something', 2, '200', 2, 'Tim01');

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

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`sn`, `group_name`, `groupId`, `courseCode`, `members`) VALUES
(1, 'Group1', '', 'GES_102', '[\"13/0274\",\"13/0297\"]');

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

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`sn`, `Name`, `MatricNum`, `courses`, `phone`, `email`, `password`, `current_semester`) VALUES
(1, 'Wale Timothy', '13/0274', '[\"GES_101\",\"GES_102\"]', '08101662910', 'tim@gmail.com', '31dd7529f9d284a85eee6d5b2116c678', ''),
(2, 'Oregunwa Segun', '13/0297', '[\"GES_100\",\"GES_102\"]', '08101662910', 'awtim01@gmail.com', 'cfb55f33bab7243f9bb5aa466303929c', '1.1');

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
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignmentdetails`
--
ALTER TABLE `assignmentdetails`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `assignmentresult`
--
ALTER TABLE `assignmentresult`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assignmentsubmission`
--
ALTER TABLE `assignmentsubmission`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
