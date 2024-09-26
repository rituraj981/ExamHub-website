-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 05:35 PM
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
-- Database: `my_online_exam_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `administer_notification_table`
--

CREATE TABLE `administer_notification_table` (
  `notification_id` int(11) NOT NULL,
  `administer_id` int(11) NOT NULL,
  `administer_name` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `notification_msg` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `administer_notification_table`
--

INSERT INTO `administer_notification_table` (`notification_id`, `administer_id`, `administer_name`, `admin_id`, `notification_msg`, `created_at`) VALUES
(1, 1, 'lokesh saini', 2, 'hello sir\r\n', '2024-06-20 16:00:56'),
(2, 1, 'lokesh saini', 2, 'he', '2024-06-21 07:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `administer_table`
--

CREATE TABLE `administer_table` (
  `administer_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `administer_name` varchar(50) NOT NULL,
  `exam_code` varchar(100) NOT NULL,
  `administer_email_address` varchar(150) NOT NULL,
  `administer_password` varchar(150) NOT NULL,
  `administer_verfication_code` varchar(120) NOT NULL,
  `administer_type` enum('Administer','Examiner') NOT NULL,
  `administer_created_on` datetime NOT NULL,
  `administer_email_verified` enum('Yes','No') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `administer_table`
--

INSERT INTO `administer_table` (`administer_id`, `admin_id`, `administer_name`, `exam_code`, `administer_email_address`, `administer_password`, `administer_verfication_code`, `administer_type`, `administer_created_on`, `administer_email_verified`) VALUES
(1, 2, 'lokesh saini', 'MCA301', 'lokeshsuiwal21@gmail.com', '$2y$10$TwfMiOa6gfhVV.G2WspaeexHoWLvks1ylYbHGRWMYdaJGfwotULXG', '', 'Administer', '2024-06-12 18:33:53', 'Yes'),
(2, 2, 'Rakesh meel', 'MCA301', 'rakeshmeel12@gmail.com', '$2y$10$1B7JytN8KYh5dpt9n6FRrOVxMSy/iZdhuRMEMtCy4I8hGnU6W6d2q', '', 'Examiner', '2024-06-12 18:34:46', 'Yes'),
(3, 4, 'Pratap singh ', 'MCA101', 'pratapsingh72@gmail.com', '$2y$10$oL7kbMJ77BijJxcHXWfKCu6KwUcZ.5hbq4HBNVo2j/C2kVk4bJNfG', '', 'Administer', '2024-06-15 09:18:08', 'Yes'),
(6, 2, 'Rituraj', 'python201', 'rituraj12@gmail.com', '$2y$10$zXa9bVDPzcWBgwVh.sWf.esqYpB6tYXkvfQ9fqQDBxSqLdaHda6b2', '', 'Examiner', '2024-06-21 09:24:04', 'Yes'),
(5, 2, 'Pratap Singh', 'MCA301', 'pratapsingh02@gmail.com', '$2y$10$OEiYi0Ov/6puSpl7gyeM3.H0LLWeAHUsZRq.0fIgPYibcBeYLYQui', '', 'Administer', '2024-06-21 04:36:52', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_image` varchar(200) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email_address` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL,
  `admin_verfication_code` varchar(100) NOT NULL,
  `admin_type` enum('Master Admin') NOT NULL,
  `admin_created_on` datetime NOT NULL,
  `email_verified` enum('No','Yes') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_image`, `admin_name`, `admin_email_address`, `admin_password`, `admin_verfication_code`, `admin_type`, `admin_created_on`, `email_verified`) VALUES
(3, '', 'lokesh', 'lokesh@gmail.com', '$2y$10$yvfeorNYCzGH4ly4W8fT6uxqDEUkZd6cbHDqQjKJhfWtKzvwHz3Q6', '172cdfd49d2e58f491c00a6998435d0b', 'Master Admin', '2024-04-21 13:57:11', 'No'),
(2, 'upload_image/6668bb6094dca.png', 'Lokesh Suiwal', 'lok12@gmail.com', '$2y$10$ZF491wkNztuU36ki9nwff.lcImERUBBQUI7MY7Iq/KVO3WcgDwYAO', '9b5178dd89d450eebf3b637d471c9acb', 'Master Admin', '2024-04-21 12:51:38', 'Yes'),
(4, 'upload_image/666bcbd2c290b.png', 'lokeshs', 'informationcomputer815@gmail.com', '$2y$10$ZF491wkNztuU36ki9nwff.lcImERUBBQUI7MY7Iq/KVO3WcgDwYAO', 'd518cd04f4033d93b58e4542beb89897', 'Master Admin', '2024-04-21 14:49:57', 'Yes'),
(5, '', 'raj saini', 'rajsanin@gmail.com', '$2y$10$I98dmo2PXRLpXX4fWzezJOuH0APGRoO4SKURxsg/tZtkQLk1P/TlC', '7f7b649e6eb313a338a142854f3bc52c', 'Master Admin', '2024-04-21 14:59:24', 'No'),
(7, '', 'Ram', 'informationcomputer@gmail.com', '$2y$10$5gMxWA7cQe3cEjUpF32UUOWjriFCwu9Nij/RNpdHWDiT.irmn7/o2', '61e5a2def1ebd9bfa483f68a85f704b8', 'Master Admin', '2024-06-12 10:48:03', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `all_subject_question_paper`
--

CREATE TABLE `all_subject_question_paper` (
  `question_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `admin_id` int(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `online_exam_id` int(100) NOT NULL,
  `exam_code` varchar(200) NOT NULL,
  `total_question` int(110) NOT NULL,
  `marks_per_right_answer` float NOT NULL,
  `marks_per_wrong_answer` float NOT NULL,
  `exam_subject_question_title` varchar(500) NOT NULL,
  `option_title_1` varchar(500) NOT NULL,
  `option_title_2` varchar(500) NOT NULL,
  `option_title_3` varchar(500) NOT NULL,
  `option_title_4` varchar(450) NOT NULL,
  `exam_subject_question_answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `all_subject_question_paper`
--

INSERT INTO `all_subject_question_paper` (`question_id`, `subject_id`, `admin_id`, `section_name`, `online_exam_id`, `exam_code`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `exam_subject_question_title`, `option_title_1`, `option_title_2`, `option_title_3`, `option_title_4`, `exam_subject_question_answer`) VALUES
(1, 2, 2, 'Sorting Array', 0, 'MCA301', 10, 3, 0, 'What does SQL stand for? ', 'Structured Query Language', 'Sequential Query Language ', 'Standard Question Language ', 'Systematic Query Logic ', '1'),
(2, 2, 2, 'Sorting Array', 0, 'MCA301', 10, 3, 0, 'Which of the following is not a type of database model?', 'Hierarchical ', 'Relational ', 'Object-Oriented', 'Scalar ', '2'),
(8, 2, 2, 'Sorting Array', 0, 'MCA301', 10, 3, 0, 'Which SQL command is used to retrieve data from a database?', 'UPDATE ', 'SELECT ', 'INSERT ', 'DELETE ', '3'),
(9, 2, 2, 'Sorting Array', 0, 'MCA301', 10, 3, 0, 'Which of the following is a non-relational database? ', 'MySQL ', 'PostgreSQL ', 'MongoDB ', 'Oracle ', '4'),
(10, 2, 2, 'Sorting Array', 0, 'MCA301', 10, 3, 0, 'Which SQL clause is used to filter the results of a query?', 'GROUP BY ', 'ORDER BY ', 'WHERE', 'HAVING ', '1'),
(11, 3, 2, 'Linklist DSA', 0, 'MCA301', 10, 3, 0, 'What does SQL stand for? ', 'Structured Query Language', 'Sequential Query Language ', 'Standard Question Language ', 'Systematic Query Logic ', '1'),
(12, 3, 2, 'Linklist DSA', 0, 'MCA301', 10, 3, 0, 'Which of the following is not a type of database model?', 'Hierarchical ', 'Relational ', 'Object-Oriented', 'Scalar ', '2'),
(13, 3, 2, 'Linklist DSA', 0, 'MCA301', 10, 3, 0, 'Which SQL command is used to retrieve data from a database?', 'UPDATE ', 'SELECT ', 'INSERT ', 'DELETE ', '1'),
(14, 3, 2, 'Linklist DSA', 0, 'MCA301', 10, 3, 0, 'Which of the following is a non-relational database? ', 'MySQL ', 'PostgreSQL ', 'MongoDB ', 'Oracle ', '3'),
(15, 3, 2, 'Linklist DSA', 0, 'MCA301', 10, 3, 0, 'Which SQL clause is used to filter the results of a query?', 'GROUP BY ', 'ORDER BY ', 'WHERE', 'HAVING ', '3'),
(34, 6, 2, 'Array', 0, 'MCA301', 5, 3, 0, 'What does SQL stand for? ', 'Structured Query Language', 'Sequential Query Language ', 'Standard Question Language ', 'Systematic Query Logic ', '1'),
(35, 6, 2, 'Array', 0, 'MCA301', 5, 3, 0, 'Which of the following is not a type of database model?', 'Hierarchical ', 'Relational ', 'Object-Oriented', 'Scalar ', '2'),
(36, 6, 2, 'Array', 0, 'MCA301', 5, 3, 0, 'Which SQL command is used to retrieve data from a database?', 'UPDATE ', 'SELECT ', 'INSERT ', 'DELETE ', '1'),
(37, 6, 2, 'Array', 0, 'MCA301', 5, 3, 0, 'Which of the following is a non-relational database? ', 'MySQL ', 'PostgreSQL ', 'MongoDB ', 'Oracle ', '3'),
(38, 6, 2, 'Array', 0, 'MCA301', 5, 3, 0, 'Which SQL clause is used to filter the results of a query?', 'GROUP BY ', 'ORDER BY ', 'WHERE', 'HAVING ', '3'),
(49, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(50, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(51, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(52, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(53, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(54, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(55, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(56, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(57, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(58, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(59, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(60, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(61, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(62, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(63, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(64, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(65, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(66, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(67, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(68, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(69, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(70, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(71, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(72, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(73, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(74, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(75, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(76, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(77, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(78, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(79, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(80, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(81, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(82, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(83, 8, 4, 'Basic Python', 0, 'MCA101', 35, 2, 0, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(84, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(85, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(86, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(87, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(88, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(89, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(90, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(91, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(92, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(93, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(94, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(95, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(96, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(97, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(98, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(99, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(100, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(101, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(102, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(103, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(104, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(105, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(106, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(107, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(108, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(109, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(110, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(111, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(112, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(113, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1'),
(114, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Python is a ___object-oriented programming language.', 'Special purpose', 'General purpose', 'Medium level programming language', 'All of the mentioned above', '2'),
(115, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst the following, who is the developer of Python programming?', 'Guido van Rossum', 'Denis Ritchie', 'Y.C. Khenderakar', 'None of the mentioned above', '1'),
(116, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the application areas of Python programming?', 'Web Development', 'Game Development', 'Artificial Intelligence and Machine Learning', 'All of the mentioned above', '4'),
(117, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'Amongst which of the following is / are the Numeric Types of Data Types?', 'int', 'float', 'complex', ' All of the mentioned above', '4'),
(118, 9, 2, 'DBMS', 0, 'MCA2024', 90, 5, 2.5, 'list, tuple, and range are the ___ of Data Types.', 'Sequence Types', 'Binary Types', 'Boolean Types', 'None of the mentioned above', '1');

-- --------------------------------------------------------

--
-- Table structure for table `calculation_result_data`
--

CREATE TABLE `calculation_result_data` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exam_code` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `enrollment_number` varchar(255) DEFAULT NULL,
  `exam_name` varchar(255) DEFAULT NULL,
  `total_question` int(11) DEFAULT NULL,
  `attempted_questions` int(11) DEFAULT NULL,
  `not_attempted_questions` int(11) DEFAULT NULL,
  `total_right_answers` int(11) DEFAULT NULL,
  `total_wrong_answers` int(11) DEFAULT NULL,
  `maximum_marks` decimal(10,2) DEFAULT NULL,
  `negative_marks` decimal(10,2) DEFAULT NULL,
  `total_marks` decimal(10,2) DEFAULT NULL,
  `user_marks` decimal(5,2) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `calculation_result_data`
--

INSERT INTO `calculation_result_data` (`id`, `admin_id`, `user_id`, `exam_code`, `user_name`, `enrollment_number`, `exam_name`, `total_question`, `attempted_questions`, `not_attempted_questions`, `total_right_answers`, `total_wrong_answers`, `maximum_marks`, `negative_marks`, `total_marks`, `user_marks`, `percentage`) VALUES
(1, 2, 6, 'MCA301', 'Lokesh Kumar Saini', 'IITJEE2023103', '0', 20, 8, 12, 4, 4, 12.00, 0.00, 60.00, 12.00, 20.00),
(2, 2, 7, 'MCA301', 'Pratap Singh', 'VGU22csa3bc059', '0', 20, 9, 11, 4, 5, 12.00, 0.00, 60.00, 12.00, 20.00),
(3, 2, 8, 'MCA301', 'Dinesh kumar saini', 'RKCLEXAM202421', '0', 20, 13, 7, 5, 8, 15.00, 0.00, 60.00, 15.00, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `calendar_event_master`
--

CREATE TABLE `calendar_event_master` (
  `event_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `calendar_event_master`
--

INSERT INTO `calendar_event_master` (`event_id`, `admin_id`, `event_name`, `event_start_date`, `event_end_date`) VALUES
(1, 2, 'this is first exam my admin panel.', '2024-06-12', '2024-06-12'),
(3, 2, 'RKCL Exam 2024 Result Publish data', '2024-06-13', '2024-06-13'),
(6, 2, 'this are create to new exam in VGU college.', '2024-06-10', '2024-06-11'),
(7, 4, 'online exam create this MCA 2nd year', '2024-06-18', '2024-06-19'),
(8, 4, 'Result Publish in UPSC Exam 3259', '2024-06-14', '2024-06-15'),
(9, 2, 'UPCS Exam 2024-25', '2024-06-12', '2024-06-13'),
(10, 3, 'UPCS Exam 2024', '2024-06-12', '2024-06-13'),
(11, 2, 'UPCS Exam 2024-25 completed', '2024-06-12', '2024-06-13'),
(12, 4, 'add to next gen. exam in VGU college......', '2024-06-04', '2024-06-05'),
(13, 2, 'this are create by lokesh saini\n', '2024-06-15', '2024-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_table`
--

CREATE TABLE `online_exam_table` (
  `online_exam_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `online_exam_title` varchar(250) NOT NULL,
  `exam_code` varchar(100) NOT NULL,
  `online_exam_datetime` datetime NOT NULL,
  `online_exam_duration` varchar(30) NOT NULL,
  `total_question` int(5) NOT NULL,
  `marks_per_right_answer` float NOT NULL,
  `marks_per_wrong_answer` float NOT NULL,
  `question_type` varchar(250) NOT NULL,
  `online_exam_created_on` datetime NOT NULL,
  `online_exam_status` enum('Pending','Created','Started','Completed') NOT NULL,
  `online_exam_code` varchar(100) NOT NULL,
  `exam_result_publish_datetime` datetime NOT NULL,
  `result_published` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `online_exam_table`
--

INSERT INTO `online_exam_table` (`online_exam_id`, `admin_id`, `online_exam_title`, `exam_code`, `online_exam_datetime`, `online_exam_duration`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`, `question_type`, `online_exam_created_on`, `online_exam_status`, `online_exam_code`, `exam_result_publish_datetime`, `result_published`) VALUES
(1, 2, 'RCAT(Rajasthan) Exam 2024', 'MCA301', '2024-06-10 11:30:00', '6', 20, 3, 0, 'Multiple Choice Exam', '2024-06-10 07:53:40', 'Completed', '3372f239f3235e95a29e2b2aadff7ace', '2024-06-30 10:00:00', 1),
(3, 4, 'Python Developer', 'MCA101', '2024-06-15 12:00:00', '60', 35, 2, 0, 'Programming/SQL Exam', '2024-06-14 05:23:59', 'Pending', '9e31ffe801e4a38448459f237f60ba8d', '0000-00-00 00:00:00', 0),
(4, 2, 'Python Developer Exam 2024', 'python201', '2024-06-22 09:20:00', '60', 30, 3, 0, 'Multiple Choice Exam', '2024-06-21 04:53:10', 'Pending', '982b63bf68ac009cabffe90b5a8172bf', '2024-06-25 06:00:00', 0),
(5, 2, 'MCA First papar', 'MCA2024', '2024-06-27 16:10:00', '120', 90, 5, 2.5, 'Multiple Choice Exam', '2024-06-22 12:33:46', 'Pending', 'af1785486cc8b3ed93d00820206288d2', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `question_table`
--

CREATE TABLE `question_table` (
  `question_id` int(11) NOT NULL,
  `online_exam_id` int(11) NOT NULL,
  `question_title` text NOT NULL,
  `answer_option` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_calculation_result_data`
--

CREATE TABLE `section_calculation_result_data` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exam_code` varchar(255) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `attempted_questions` int(11) DEFAULT NULL,
  `not_attempted_questions` int(11) DEFAULT NULL,
  `total_right_answer` int(11) DEFAULT NULL,
  `total_wrong_answer` int(11) DEFAULT NULL,
  `minimum_mark` decimal(10,2) DEFAULT NULL,
  `negative_mark` decimal(10,2) DEFAULT NULL,
  `total_mark` decimal(10,2) DEFAULT NULL,
  `user_mark` decimal(5,2) DEFAULT NULL,
  `percentagee` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `section_calculation_result_data`
--

INSERT INTO `section_calculation_result_data` (`id`, `admin_id`, `user_id`, `exam_code`, `section_name`, `total_questions`, `attempted_questions`, `not_attempted_questions`, `total_right_answer`, `total_wrong_answer`, `minimum_mark`, `negative_mark`, `total_mark`, `user_mark`, `percentagee`) VALUES
(1, 2, 6, 'MCA301', 'Sorting Array', 3, 3, 0, 2, 1, 6.00, 0.00, 9.00, 6.00, 66.00),
(2, 2, 6, 'MCA301', 'Linklist DSA', 5, 5, 0, 2, 3, 6.00, 0.00, 15.00, 6.00, 40.00),
(3, 2, 7, 'MCA301', 'Sorting Array', 5, 5, 0, 2, 3, 6.00, 0.00, 15.00, 6.00, 40.00),
(4, 2, 7, 'MCA301', 'Linklist DSA', 4, 4, 0, 2, 2, 6.00, 0.00, 12.00, 6.00, 50.00),
(5, 2, 8, 'MCA301', 'Sorting Array', 5, 5, 0, 2, 3, 6.00, 0.00, 15.00, 6.00, 40.00),
(6, 2, 8, 'MCA301', 'Linklist DSA', 3, 3, 0, 2, 1, 6.00, 0.00, 9.00, 6.00, 66.00),
(7, 2, 8, 'MCA301', 'Array', 5, 5, 0, 1, 4, 3.00, 0.00, 15.00, 3.00, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `subject_table`
--

CREATE TABLE `subject_table` (
  `subject_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `exam_code` varchar(100) NOT NULL,
  `section_name` varchar(100) NOT NULL,
  `total_question` int(20) NOT NULL,
  `marks_per_right_answer` float NOT NULL,
  `marks_per_wrong_answer` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subject_table`
--

INSERT INTO `subject_table` (`subject_id`, `admin_id`, `exam_code`, `section_name`, `total_question`, `marks_per_right_answer`, `marks_per_wrong_answer`) VALUES
(2, 2, 'MCA301', 'Sorting Array', 10, 3, 0),
(3, 2, 'MCA301', 'Linklist DSA', 10, 3, 0),
(6, 2, 'MCA301', 'Array', 5, 3, 0),
(8, 4, 'MCA101', 'Basic Python', 35, 2, 0),
(9, 2, 'MCA2024', 'DBMS', 90, 5, 2.5);

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selected_option` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `question_id`, `user_id`, `selected_option`) VALUES
(4, 4, 6, 2),
(6, 3, 6, 2),
(7, 5, 6, 1),
(8, 6, 6, 1),
(9, 7, 6, 2),
(10, 8, 6, 2),
(15, 17, 6, 2),
(16, 18, 6, 2),
(17, 19, 6, 1),
(18, 20, 6, 1),
(19, 11, 6, 1),
(20, 12, 6, 1),
(21, 13, 6, 1),
(22, 14, 6, 1),
(23, 15, 6, 1),
(24, 16, 6, 1),
(25, 1, 7, 1),
(26, 2, 7, 1),
(27, 3, 7, 1),
(28, 4, 7, 1),
(29, 5, 7, 1),
(30, 6, 7, 1),
(31, 7, 7, 1),
(32, 8, 7, 1),
(33, 9, 7, 1),
(34, 10, 7, 1),
(35, 11, 7, 1),
(36, 12, 7, 1),
(37, 13, 7, 1),
(39, 14, 7, 1),
(40, 16, 7, 1),
(41, 17, 7, 1),
(42, 18, 7, 2),
(43, 19, 7, 2),
(44, 20, 7, 1),
(45, 1, 6, 1),
(46, 2, 6, 2),
(48, 1, 8, 1),
(49, 2, 8, 2),
(50, 8, 8, 2),
(51, 9, 8, 2),
(52, 10, 8, 3),
(53, 11, 8, 1),
(54, 12, 8, 2),
(55, 13, 8, 3),
(56, 34, 8, 1),
(57, 35, 8, 1),
(58, 36, 8, 2),
(59, 37, 8, 2),
(60, 38, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_exam_enroll_table`
--

CREATE TABLE `user_exam_enroll_table` (
  `user_exam_enroll_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `attendance_status` enum('Present','Absent') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_email_address` varchar(250) NOT NULL,
  `user_password` varchar(150) NOT NULL,
  `enrollment_number` varchar(50) NOT NULL,
  `user_exam_code` varchar(100) NOT NULL,
  `user_verfication_code` varchar(100) NOT NULL,
  `user_mobile_no` int(25) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_gender` varchar(11) NOT NULL,
  `user_image` varchar(500) NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_email_verified` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_email_address`, `user_password`, `enrollment_number`, `user_exam_code`, `user_verfication_code`, `user_mobile_no`, `user_name`, `user_gender`, `user_image`, `user_created_on`, `user_email_verified`) VALUES
(2, 'lok@gmail.com', '$2y$10$3hslTufSwYKGkxqFxlEgi.tH6qiady/lXzjSO3pjd3sPYk1igQs8O', 'UPSC210215', 'MCA301', 'bc52ed00a034cd099d9ea924e30e851d', 2147483647, 'lokesh', 'Male', '6637d16a0e915.png', '2024-05-05 20:35:22', 'no'),
(3, 'informationcomputer815@gmail.com', '$2y$10$JFVl49vg0TCrHB8yCWVSUOYPOA5QFMgay1Cn9qpOe0PXSqr7TBb1.', 'RKCLEXAM202421', 'MCA302', '9407536eebb1cd43a8a44915ba5b479c', 2147483647, 'information computer', 'Male', '6637d40f44e22.png', '2024-05-05 20:46:39', 'no'),
(4, 'rituraj210@gmail.com', '$2y$10$0l8kjQUSc9WWpgR.J/xXi.a0qXB6EJwl03x52GSC4ekmOM35hem7C', 'VGUMCA2024201', 'MCA101', 'a4af4436b642e749841c3d4ed4585990', 2147483647, 'Ritu Raj', 'Male', '6637d448c1486.png', '2024-05-05 20:47:36', 'no'),
(5, 'shrmasoniya11@gmail.com', '$2y$10$bP8NTvjvfMy8kA6OscQAZOyQAbCWkkNIQUUtlIBK6VICveJHkXTcy', 'IITJEE2023101', 'MCA302', 'c008d506cbb5a510cd6c3ffca2e5d34f', 2147483647, 'Soniya Shrma', 'Female', '6637d49d1d422.png', '2024-05-05 20:49:01', 'no'),
(6, 'lokeshsuiwal282@gmail.com', '$2y$10$NWE9XyQBmAVdWA5U0O/Avu4vVzPM1lNfIqonaO3WC5X8aqpKo8ouO', 'IITJEE2023103', 'MCA301', '692788a2122a3ffccfb81d60606277e1', 2147483647, 'Lokesh Kumar Saini', 'Male', '6637f3b154132.png', '2024-05-05 23:01:37', 'no'),
(7, 'pratapsingh72@gmail.com', '$2y$10$TMZPwtaS8KZAfPYE4AO.6.jwKhKFlx8R3QKOBLLQ4BJUKv5hBokXu', 'VGU22csa3bc059', 'MCA301', '335b9c15e068e9fde4d41c39cfba9a3d', 2147483647, 'Pratap Singh', 'Female', '6667f03008ed2.jpg', '2024-06-11 08:35:28', 'no'),
(8, 'dineshsaini21@gmail.com', '$2y$10$cfKDnSUCCqBAsTLZ/3dgd.u.Zxi3Kav89sslBE6xTM4KfeRwyK.hW', 'RKCLEXAM202421', 'MCA301', 'f923eab4cea83259814ecf4affd7d9df', 2147483647, 'Dinesh kumar saini', 'Male', '666d6fc8b039f.jpg', '2024-06-15 12:41:12', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administer_notification_table`
--
ALTER TABLE `administer_notification_table`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `administer_table`
--
ALTER TABLE `administer_table`
  ADD PRIMARY KEY (`administer_id`);

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `all_subject_question_paper`
--
ALTER TABLE `all_subject_question_paper`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `subject_id_fk` (`subject_id`);

--
-- Indexes for table `calculation_result_data`
--
ALTER TABLE `calculation_result_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  ADD PRIMARY KEY (`online_exam_id`);

--
-- Indexes for table `question_table`
--
ALTER TABLE `question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `section_calculation_result_data`
--
ALTER TABLE `section_calculation_result_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_table`
--
ALTER TABLE `subject_table`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_question_user` (`question_id`,`user_id`);

--
-- Indexes for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  ADD PRIMARY KEY (`user_exam_enroll_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administer_notification_table`
--
ALTER TABLE `administer_notification_table`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `administer_table`
--
ALTER TABLE `administer_table`
  MODIFY `administer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `all_subject_question_paper`
--
ALTER TABLE `all_subject_question_paper`
  MODIFY `question_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `calculation_result_data`
--
ALTER TABLE `calculation_result_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `online_exam_table`
--
ALTER TABLE `online_exam_table`
  MODIFY `online_exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `section_calculation_result_data`
--
ALTER TABLE `section_calculation_result_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_table`
--
ALTER TABLE `subject_table`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `user_exam_enroll_table`
--
ALTER TABLE `user_exam_enroll_table`
  MODIFY `user_exam_enroll_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_subject_question_paper`
--
ALTER TABLE `all_subject_question_paper`
  ADD CONSTRAINT `subject_id_fk` FOREIGN KEY (`subject_id`) REFERENCES `subject_table` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
