-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Mar 23, 2024 at 01:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(50) NOT NULL COMMENT 'id of account??',
  `uid` int(50) NOT NULL COMMENT 'actual id of account',
  `username` varchar(50) NOT NULL COMMENT 'username of account',
  `email` varchar(50) NOT NULL COMMENT 'email of account',
  `password` varchar(50) NOT NULL COMMENT 'password of accout ',
  `bio` text NOT NULL COMMENT 'bio of account',
  `ppic` varchar(50) NOT NULL COMMENT 'profile pic of account',
  `date` date NOT NULL COMMENT 'date o f vreation of account'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(50) NOT NULL COMMENT 'id of comment',
  `pid` varchar(50) NOT NULL COMMENT 'post id ',
  `uid` varchar(50) NOT NULL COMMENT 'commenter/user id',
  `comment` text NOT NULL COMMENT 'actual comment',
  `date` date NOT NULL DEFAULT current_timestamp() COMMENT 'time of commenting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `id` int(50) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `receiver` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(50) NOT NULL,
  `filepath` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(50) NOT NULL COMMENT 'id of likes',
  `pid` int(50) NOT NULL COMMENT 'post id',
  `uid` int(50) NOT NULL COMMENT 'user id',
  `date` date NOT NULL COMMENT 'time of like/unlike',
  `likes` int(50) NOT NULL COMMENT 'likes counter \r\n1 if liked for first time\r\n0 if liked and unliked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(50) NOT NULL COMMENT 'primary key',
  `email` varchar(50) NOT NULL COMMENT 'email',
  `password` varchar(50) NOT NULL COMMENT 'password',
  `date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'sign-up date time',
  `username` varchar(50) NOT NULL COMMENT 'the username of the user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(50) NOT NULL COMMENT 'pkey of messege',
  `sid` varchar(50) NOT NULL COMMENT 'sender id',
  `rid` varchar(50) NOT NULL COMMENT 'reciver id',
  `messege` text NOT NULL COMMENT 'actual text',
  `date` date NOT NULL DEFAULT current_timestamp() COMMENT 'date of sending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(50) NOT NULL COMMENT 'Post id',
  `Title` varchar(50) NOT NULL COMMENT 'Post1-title',
  `display-text` varchar(50) NOT NULL COMMENT 'Display-Text',
  `date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Posted-date',
  `post` text NOT NULL COMMENT 'actual-text',
  `poster` varchar(50) NOT NULL COMMENT 'poster of blog',
  `likes` int(50) NOT NULL COMMENT 'likes on the post'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'id of account??', AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'id of comment', AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `follower`
--
ALTER TABLE `follower`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'id of likes', AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'pkey of messege', AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'Post id', AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
