-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Aug 17, 2022 at 06:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Username` varchar(40) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Username`, `Password`) VALUES
('bye', '$2y$10$x4kx0x8HAcO3l6cgcwQxqOvw.OBT.0DIV4TGsxqIZhMfGCLRSQcgC'),
('Hamada', '$2y$10$pwXHDVWLFswhM9qn6mg0b.XK0x.s9/IDJHHG0Dtqv1b8Ey78hDIl6'),
('red', '$2y$10$1c60kbVxGovygcLr0caOiO/J8UDUIGU8kj04uyk1LRfx5M1u1Di.e');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `AssignmentID` int(11) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `DueDate` datetime NOT NULL,
  `MaxGrade` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `Description`, `DueDate`, `MaxGrade`) VALUES
(1, 'This is a valid assignment', '2023-07-25 22:00:00', 100),
(2, 'This is a late assignment', '2021-07-25 22:00:00', 100),
(6, 'Quiz 5', '2029-07-22 10:30:00', 100),
(8, 'Homework 4', '2020-12-09 12:00:00', 20);

-- --------------------------------------------------------

--
-- Table structure for table `assistants`
--

CREATE TABLE `assistants` (
  `AssistantID` int(11) NOT NULL,
  `AssistantUsername` varchar(250) NOT NULL,
  `AssistantPassword` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assistants`
--

INSERT INTO `assistants` (`AssistantID`, `AssistantUsername`, `AssistantPassword`) VALUES
(1, 'Hamada', '$2y$10$luHCo8R2AbHrvzboaqKdJeSa4o0q34d0blLg5M9N1u3pRJi6hE0nW'),
(5, 'Hanoosh', '$2y$10$3X1TFEOZ.S.jMCa71Yjaf.gYc/yNWqVxfvS7F8CK3qIKZJhZpeSwi'),
(8, 'assistant', '$2y$10$LYZiyyNBxkQJoLLUrLVW0O9n1Oy8i/wuJmW6ubPaFa88pLG2IfIv2');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `Header` varchar(40) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `attachments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `Header`, `Description`, `attachments`) VALUES
(4, 'No attach', 'No attach', 'attachments/'),
(5, 'with attach', 'with attach', 'attachments/full.pdf'),
(6, 'ID', 'ID file', 'attachments/ID.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `UserID` varchar(40) NOT NULL,
  `1` int(11) NOT NULL DEFAULT 0,
  `2` int(11) NOT NULL DEFAULT 0,
  `6` int(11) NOT NULL DEFAULT 0,
  `8` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`UserID`, `1`, `2`, `6`, `8`) VALUES
('ahmed.abuelfadel', 20, 3, 0, 0),
('Default username', 20, 0, 0, 0),
('user', 12, 20, 0, 0),
('user2', 0, 0, 0, 0),
('username', 20, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `Question` varchar(250) NOT NULL,
  `User` varchar(250) NOT NULL,
  `Answer` varchar(250) NOT NULL DEFAULT 'Not Answered yet',
  `Assistant` varchar(250) NOT NULL DEFAULT 'NA',
  `Answered` bit(1) NOT NULL DEFAULT b'0',
  `TeacherAnswer` varchar(255) NOT NULL DEFAULT 'Not Answered yet',
  `TeacherAnswered` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `Question`, `User`, `Answer`, `Assistant`, `Answered`, `TeacherAnswer`, `TeacherAnswered`) VALUES
(12, '2003    ', 'ahmed.abuelfadel', 'ana mesh fahem', 'Hamada', b'1', 'la mayemkensh', b'1'),
(13, '2004', 'ahmed.abuelfadel', 'Not Answered yet', 'Hamada', b'0', 'mesh 2005 la', b'1'),
(14, 'answer with bye', 'username', 'bye', 'Hamada', b'1', 'bye bye ya habibi', b'1'),
(15, 'answer with hello', 'username', 'hello', 'Hamada', b'1', 'hi hien', b'1'),
(18, 'Who is the best player?', 'user2', 'Not Answered yet', 'NA', b'0', 'not Haaland', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Username` varchar(40) NOT NULL,
  `Password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Username`, `Password`) VALUES
('user2', '$2y$10$llip7yvF7EHqYQu/S43L5esjDtZRwzd2MtUm5w2A7QhR.14q34Wne'),
('username', '$2y$10$F4vxGXoYUJ1KkhANW185uukb0jzyXHL35IPN1cCd8pQJ56e0QnIwS');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `VideoID` int(11) NOT NULL,
  `VideoName` varchar(255) NOT NULL,
  `VideoLocation` varchar(255) NOT NULL,
  `Accessebility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`VideoID`, `VideoName`, `VideoLocation`, `Accessebility`) VALUES
(2, 'flop', 'videos/v2.mp4', 1),
(3, 'accept', 'videos/v3.mp4', 0),
(5, 'binary', 'videos/v1.mp4', 0),
(7, 'marbella', 'videos/v3.mp4', 1),
(12, 'new test', 'videos/v1.mp4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `WorkID` int(11) NOT NULL,
  `UserID` varchar(250) NOT NULL,
  `AssignmentID` int(11) NOT NULL,
  `WorkFile` varchar(250) NOT NULL,
  `Late` int(1) NOT NULL DEFAULT 0,
  `Grade` int(11) NOT NULL,
  `Comments` varchar(255) NOT NULL DEFAULT 'No comments',
  `AssistantID` varchar(40) NOT NULL DEFAULT 'NA',
  `Corrected` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`WorkID`, `UserID`, `AssignmentID`, `WorkFile`, `Late`, `Grade`, `Comments`, `AssistantID`, `Corrected`) VALUES
(9, 'Default username', 1, 'work/full.pdf', 0, 20, '', 'Hamada', b'1'),
(10, 'Default username', 2, 'work/ID.pdf', 1, 0, '', '', b'0'),
(11, 'user', 2, 'work/ID.pdf', 1, 20, 'You are default username', 'Hamada', b'1'),
(12, 'user', 1, 'work/full.pdf', 0, 12, 'Mediocre', 'Hamada', b'1'),
(13, 'ahmed.abuelfadel', 2, 'work/ID.pdf', 1, 3, 'bad', 'Hamada', b'1'),
(14, 'ahmed.abuelfadel', 1, 'work/full.pdf', 0, 20, 'Good Job', 'Hamada', b'1'),
(20, 'username', 2, 'work/ID.pdf', 1, 0, 'No comments', 'NA', b'0'),
(26, 'username', 1, 'work/full.pdf', 0, 20, 'Well done', 'Hamada', b'1'),
(27, 'username', 6, 'work/ID.pdf', 0, 0, 'No comments', 'NA', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`);

--
-- Indexes for table `assistants`
--
ALTER TABLE `assistants`
  ADD PRIMARY KEY (`AssistantID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`VideoID`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`WorkID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assistants`
--
ALTER TABLE `assistants`
  MODIFY `AssistantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `VideoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
  MODIFY `WorkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
