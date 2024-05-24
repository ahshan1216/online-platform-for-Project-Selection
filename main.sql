-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2024 at 05:54 PM
-- Server version: 8.0.37
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etisparl_versity`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int NOT NULL,
  `group_number` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `teacher_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `project_id` int DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `group_number`, `teacher_name`, `comment`, `project_id`, `time`, `session`) VALUES
(24, '9', 'Tonmoy', 'Very Good\n', 128, '16-02-2024', 'summer24'),
(26, '1', 'Tonmoy', 'ha kub valo hoyse\n', 125, '26-04-2024', 'summer24'),
(27, '1', 'Tonmoy', 'hoi ani', 125, '19-04-2024', 'summer24'),
(28, '1', 'Tonmoy', 'hoi ani', 125, '12-04-2024', 'summer24');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `notice` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `session` varchar(255) NOT NULL,
  `subject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `name`, `notice`, `date`, `session`, `subject`) VALUES
(19, 'Tonmoy', 'During Medical Treatment ,Today class held Next week', '2024-05-23 09:52:52', 'summer24', 'Class Cancel'),
(20, 'Tonmoy', 'https://meet.google.com/vap-nqxy-ibf', '2024-05-23 09:53:43', 'summer24', 'Join The Class'),
(22, 'Mahadi', 'test notice', '2024-05-24 11:33:42', 'summer24', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `project_management`
--

CREATE TABLE `project_management` (
  `id` int NOT NULL,
  `session` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_number` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `time` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `perday` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_management`
--

INSERT INTO `project_management` (`id`, `session`, `group_number`, `project_id`, `title`, `description`, `time`, `status`, `perday`, `duration`) VALUES
(133, 'summer24', 9, 128, '', 'Database banao Done sir.\nlink check: mongodb.com/cluster/sdsdfsdf', '16-02-2024', 'complete', '8.333333333333334', '12'),
(135, 'summer24', 1, 125, '', 'Link:\ndone', '26-04-2024', 'complete', '8.333333333333334', '12'),
(136, 'summer24', 1, 125, NULL, NULL, '19-04-2024', 'not-complete', '0', '12'),
(137, 'summer24', 1, 125, NULL, NULL, '12-04-2024', 'partially', '4.166666666666667', '12');

--
-- Triggers `project_management`
--
DELIMITER $$
CREATE TRIGGER `update_perday_before_insert` BEFORE INSERT ON `project_management` FOR EACH ROW BEGIN
    IF NEW.status = 'complete' THEN
        SET NEW.perday = 100 / NEW.duration;
    ELSEIF NEW.status = 'partially' THEN
        SET NEW.perday = 100 / (NEW.duration * 2);
    ELSE
        SET NEW.perday = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_perday_before_update` BEFORE UPDATE ON `project_management` FOR EACH ROW BEGIN
    IF NEW.duration IS NOT NULL THEN
        IF NEW.status = 'complete' THEN
            SET NEW.perday = 100 / NEW.duration;
        ELSEIF NEW.status = 'partially' THEN
            SET NEW.perday = 100 / (NEW.duration * 2);
        ELSE
            SET NEW.perday = 0;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_students`
--

CREATE TABLE `project_students` (
  `id` int NOT NULL,
  `group_number` int DEFAULT NULL,
  `student_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int DEFAULT '0',
  `session` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_leader` int DEFAULT '0',
  `listening` int DEFAULT '0',
  `project_approval` int DEFAULT '0',
  `request` int DEFAULT '0',
  `group_approval` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_students`
--

INSERT INTO `project_students` (`id`, `group_number`, `student_id`, `status`, `session`, `group_leader`, `listening`, `project_approval`, `request`, `group_approval`) VALUES
(1487, 1, '41220100052', 1, 'summer24', 1, 1, 1, -1, 'Tonmoy'),
(1488, 1, '41220100118', 1, 'summer24', 0, 1, 1, 0, 'Tonmoy'),
(1489, 1, '41220100106', 1, 'summer24', 0, 1, 1, 0, 'Tonmoy'),
(1490, 1, '41220101630', 1, 'summer24', 0, 1, 1, 0, 'Tonmoy'),
(1491, 0, '41220100111', 0, 'summer24', 0, 0, 0, 1, '0'),
(1492, 1, '41220100051', 1, 'summer24', 0, 1, 1, 0, 'Tonmoy'),
(1493, 2, '41220200170', 1, 'summer24', 1, 2, 0, -1, 'Tonmoy'),
(1494, 2, '41220200187', 1, 'summer24', 0, 2, 0, 0, 'Tonmoy'),
(1495, 2, '41220200198', 1, 'summer24', 0, 2, 0, 0, 'Tonmoy'),
(1496, 2, '41220200166', 1, 'summer24', 0, 2, 0, 0, 'Tonmoy'),
(1497, 2, '41220200207', 1, 'summer24', 0, 2, 0, 0, 'Tonmoy'),
(1498, 2, '41220200188', 1, 'summer24', 0, 2, 0, 0, 'Tonmoy'),
(1499, 3, '41220200209', 1, 'summer24', 1, 3, 0, -1, 'Tonmoy'),
(1500, 3, '41220200229', 1, 'summer24', 0, 3, 0, 0, 'Tonmoy'),
(1501, 3, '41220200208', 1, 'summer24', 0, 3, 0, 0, 'Tonmoy'),
(1504, 5, '41220100087', 1, 'summer24', 1, 5, 0, -1, 'Tonmoy'),
(1505, 5, '41220100064', 1, 'summer24', 0, 5, 0, 0, 'Tonmoy'),
(1506, 5, '41220100159', 1, 'summer24', 0, 5, 0, 0, 'Tonmoy'),
(1507, 5, '41220100090', 1, 'summer24', 0, 5, 0, 0, 'Tonmoy'),
(1508, 5, '41220100072', 1, 'summer24', 0, 5, 0, 0, 'Tonmoy'),
(1509, 5, '41220100075', 1, 'summer24', 0, 5, 0, 0, 'Tonmoy'),
(1510, 6, '41220200226', 1, 'summer24', 1, 6, 0, -1, 'Tonmoy'),
(1511, 6, '41220200221', 1, 'summer24', 0, 6, 0, 0, 'Tonmoy'),
(1512, 6, '41220200224', 1, 'summer24', 0, 6, 0, 0, 'Tonmoy'),
(1513, 6, '41200301545', 1, 'summer24', 0, 6, 0, 0, 'Tonmoy'),
(1514, 6, '41210101566', 1, 'summer24', 0, 6, 0, 0, 'Tonmoy'),
(1515, 6, '41190201364', 1, 'summer24', 0, 6, 0, 0, 'Tonmoy'),
(1516, 7, '41220100091', 1, 'summer24', 1, 7, 0, -1, 'Tonmoy'),
(1517, 7, '41220100083', 1, 'summer24', 0, 7, 0, 0, 'Tonmoy'),
(1518, 7, '41220100078', 1, 'summer24', 0, 7, 0, 0, 'Tonmoy'),
(1519, 7, '41220100084', 1, 'summer24', 0, 7, 0, 0, 'Tonmoy'),
(1520, 7, '41220100062', 1, 'summer24', 0, 7, 0, 0, 'Tonmoy'),
(1521, 7, '41220100063', 1, 'summer24', 0, 7, 0, 0, 'Tonmoy'),
(1522, 8, '41220100144', 1, 'summer24', 1, 8, 0, -1, 'Tonmoy'),
(1523, 8, '41220100122', 1, 'summer24', 0, 8, 0, 0, 'Tonmoy'),
(1524, 8, '41220100141', 1, 'summer24', 0, 8, 0, 0, 'Tonmoy'),
(1525, 8, '41220100142', 1, 'summer24', 0, 8, 0, 0, 'Tonmoy'),
(1526, 8, '41220100147', 1, 'summer24', 0, 8, 0, 0, 'Tonmoy'),
(1527, 8, '41220100151', 1, 'summer24', 0, 8, 0, 0, 'Tonmoy'),
(1528, 9, '41220100056', 1, 'summer24', 1, 9, 1, -1, 'Tonmoy'),
(1529, 9, '41220100057', 1, 'summer24', 0, 9, 1, 0, 'Tonmoy'),
(1530, 9, '41220100058', 1, 'summer24', 0, 9, 1, 0, 'Tonmoy'),
(1531, 9, '41220100061', 1, 'summer24', 0, 9, 1, 0, 'Tonmoy'),
(1532, 9, '41220101621', 1, 'summer24', 0, 9, 1, 0, 'Tonmoy'),
(1533, 9, '41220100054', 1, 'summer24', 0, 9, 1, 0, 'Tonmoy'),
(1534, 10, '41220100135', 1, 'summer24', 1, 10, 0, -1, 'Tonmoy'),
(1535, 10, '41220100137', 1, 'summer24', 0, 10, 0, 0, 'Tonmoy'),
(1536, 10, '41220100140', 1, 'summer24', 0, 10, 0, 0, 'Tonmoy'),
(1537, 11, '41220100105', 1, 'summer24', 1, 11, 0, -1, 'Tonmoy'),
(1538, 11, '41220100110', 1, 'summer24', 0, 11, 0, 0, 'Tonmoy'),
(1539, 11, '41220100154', 1, 'summer24', 0, 11, 0, 0, 'Tonmoy'),
(1540, 12, '41220100150', 1, 'summer24', 1, 12, 0, -1, '0'),
(1541, 12, '41220100136', 1, 'summer24', 0, 12, 0, 0, '0'),
(1542, 12, '41220100050', 1, 'summer24', 0, 12, 0, 0, '0'),
(1543, 13, '41220100053', 1, 'summer24', 1, 13, 0, -1, '0'),
(1544, 13, '41220100121', 1, 'summer24', 0, 13, 0, 0, '0'),
(1545, 13, '41210300026', 1, 'summer24', 0, 13, 0, 0, '0'),
(1546, 14, '41210300014', 1, 'summer24', 1, 14, 0, -1, '0'),
(1547, 14, '41220200165', 1, 'summer24', 0, 14, 0, 0, '0'),
(1548, 14, '41220200184', 1, 'summer24', 0, 14, 0, 0, '0');

--
-- Triggers `project_students`
--
DELIMITER $$
CREATE TRIGGER `before_insert_project_students` BEFORE INSERT ON `project_students` FOR EACH ROW BEGIN
    IF NEW.group_number IS NULL THEN
        -- Auto-increment group_number only if not provided in the INSERT statement
        SET NEW.group_number = (SELECT COALESCE(MAX(group_number), 0) + 1 FROM project_students);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `summer24`
--

CREATE TABLE `summer24` (
  `id` int NOT NULL,
  `session` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_number` int DEFAULT NULL,
  `approved_by_faculty` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '0',
  `project_name` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `project_description` longtext COLLATE utf8mb4_general_ci,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `student_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `progress` double(11,3) DEFAULT '0.000',
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '0',
  `op_head` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `summer24`
--

INSERT INTO `summer24` (`id`, `session`, `group_number`, `approved_by_faculty`, `project_name`, `project_description`, `create_time`, `student_id`, `progress`, `status`, `op_head`) VALUES
(107, 'summer24', 2, '0', 'Goru-Chagol kena becha.com', '<p>..</p>', '2024-04-25 10:38:22', '41220200170', 0.000, '0', NULL),
(108, 'summer24', 3, '0', 'TOLATE', '<p>..</p>', '2024-04-25 10:44:38', '41220200209', 0.000, '0', NULL),
(109, 'summer24', 3, '0', 'wholesale product ', '<p>wholesale product</p>', '2024-04-25 10:45:36', '41220200209', 0.000, '0', NULL),
(110, 'summer24', 3, '0', 'fix my computer', '<p>&nbsp;here we can get &nbsp;software and hardware releted &nbsp;help</p>', '2024-04-25 10:46:16', '41220200209', 0.000, '0', NULL),
(111, 'summer24', 2, '0', 'Haircare', '<p>Only Haircare-a place everything about hair likes product info,how to care them,home made produce for hair etc</p>', '2024-04-25 10:47:43', '41220200170', 0.000, '0', NULL),
(112, 'summer24', 2, '0', 'donate their extra food', '<table dir=\"ltr\" style=\"height: 183px; width: 47.4537%;\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" data-sheets-root=\"1\"><colgroup><col style=\"width: 53.0488%;\" width=\"174\"></colgroup>\n<tbody>\n<tr style=\"height: 60px;\">\n<td data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;community based foood sharing &quot;}\">\n<div>\n<div>community based foood sharing</div>\n</div>\n</td>\n</tr>\n<tr style=\"height: 60px;\">\n<td data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;network &amp;also restaurant and &quot;}\">network &amp;also restaurant and</td>\n</tr>\n<tr style=\"height: 62px;\">\n<td data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;peple donate their extra food&quot;}\">peple donate their extra food</td>\n</tr>\n</tbody>\n</table>', '2024-04-25 10:48:37', '41220200170', 0.000, '0', NULL),
(113, 'summer24', 5, '0', 'Medshelf', '<p>Medshelf - Medicine cabinet organizer web app with location tracking via user-defined shelves.(**)</p>', '2024-04-25 10:52:40', '41220100087', 0.000, '0', NULL),
(114, 'summer24', 5, '0', 'Beyond_The_Book', '<p>Beyond_The_Book - A book review platform (Combination of goodread+reddit)*** BANGLA</p>', '2024-04-25 10:53:13', '41220100087', 0.000, '0', NULL),
(115, 'summer24', 5, '0', 'Green Route Planner', '<p>\"Green Route Planner\": An eco-friendly route planning web app that helps users minimize their carbon footprint while traveling. It suggests routes for walking, cycling, or using public transportation based on environmental impact, distance, and time, encouraging sustainable transportation choices</p>', '2024-04-25 10:53:41', '41220100087', 0.000, '0', NULL),
(116, 'summer24', 6, '0', 'Test Me Before My Exams ', '<p>Test Me Before My Exams - This application will help a student to judge themself how well he/she is prepared for the upcomming exam through solving question bank base of the score the application will suggest which topics needs to concentrate more and gives rating, review and suggestions</p>', '2024-04-25 10:57:11', '41220200226', 0.000, '0', NULL),
(117, 'summer24', 6, '0', 'SlangSentry', '<p><strong>SlangSentry</strong> - This is a chat application that will prevent to use Banglish slangs in conversation</p>', '2024-04-25 10:57:52', '41220200226', 0.000, '0', NULL),
(118, 'summer24', 6, '0', 'Ai content creator', '<p>Ai content creator</p>', '2024-04-25 10:58:49', '41220200226', 0.000, '0', NULL),
(119, 'summer24', 7, '0', 'Collaborative Note-sharing Platform', '<p>Collaborative Note-sharing Platform:- a real time note sharing and discussion platform among students</p>', '2024-04-25 11:02:41', '41220100091', 0.000, '0', NULL),
(120, 'summer24', 7, '0', 'Helping Hands Network', '<p>Helping Hands Network:- connects homeowners with skilled service providers like electrician,plamber</p>', '2024-04-25 11:02:56', '41220100091', 0.000, '0', NULL),
(121, 'summer24', 7, '0', 'Medminder', '<p>1.<strong>Medminder</strong> (It&rsquo;s an app with customizable medication reminder features, alerts and reports)</p>', '2024-04-25 11:03:28', '41220100091', 0.000, '0', NULL),
(122, 'summer24', 8, '0', 'Interest Free Loan Service', '<p>..</p>', '2024-04-25 11:05:58', '41220100144', 0.000, '0', NULL),
(123, 'summer24', 8, '0', 'Cloud-based Enterprise Solution', '<p>Cloud-based Enterprise Solution</p>', '2024-04-25 11:06:11', '41220100144', 0.000, '0', NULL),
(124, 'summer24', 8, '0', 'Disaster Management Application', '<p>Disaster Management Application</p>', '2024-04-25 11:06:20', '41220100144', 0.000, '0', NULL),
(125, 'summer24', 1, 'Tonmoy', 'Project Selection', '<p>Project Selection is a project of time optimizing to the faculty members<br><br>Features:<br><br>1. There are four Dashboard&nbsp; Student , Faculty , Department Head , Modaretor, Master Admin<br><br>2. Student Create thair Group of their own choice and create so many project as they want<br><br>3. Faculty or Department Head Approve the group then&nbsp;<br>approve the best project per group<br><br>4. Faculty add their Duration of project to Complete and also add Task system and student present system<br><br>5.When Faculty add their duration then Student update their project in every week with task. this update&nbsp; increate their project progress<br><br><br><br></p>', '2024-04-25 11:12:55', '41220100052', 12.500, 'approved', NULL),
(126, 'summer24', 1, '0', 'E Vangari ( ই ভাঙ্গারি) ', '<p>Broken Item sell &nbsp;and deposit empty bottles and receive payment in return</p>', '2024-04-25 11:39:11', '41220100052', 0.000, '', ''),
(127, 'summer24', 1, '0', 'Find My Project', '<p>fin</p><p>find</p><p>If someone lost their bike he can announce REWARD if someone can rescue it.GOVT will entry rescued bike\'s Reg number so user can find their lost bike too if possible.</p><p>If someone lost their bike he can announce REWARD if someone can rescue it.GOVT will entry rescued bike\'s Reg number so user can find their lost bike too if possible.</p>', '2024-04-25 11:40:19', '41220100052', 0.000, '0', NULL),
(128, 'summer24', 9, 'Tonmoy', 'NUB Query', '<p>&nbsp;- A news portal app that give latest University update by chat bot</p>', '2024-04-25 12:41:36', '41220100056', 8.333, 'approved', NULL),
(129, 'summer24', 10, '0', 'Pet Adoption Platform', '<p>..</p>', '2024-04-25 12:42:57', '41220100135', 0.000, '0', NULL),
(130, 'summer24', 11, '0', 'Meal Management System', '<p>...</p>', '2024-04-25 12:44:50', '41220100105', 0.000, '0', NULL),
(131, 'summer24', 12, '0', 'Android Job Portal App System', '<p>...</p>', '2024-04-25 12:46:10', '41220100150', 0.000, '0', NULL),
(132, 'summer24', 13, '0', 'Amusement park management system', '<p>..</p>', '2024-04-25 12:47:20', '41220100053', 0.000, '0', NULL),
(133, 'summer24', 14, '0', 'Matrimonial Portal', '<p>...</p>', '2024-04-25 12:48:37', '41210300014', 0.000, '0', NULL);

--
-- Triggers `summer24`
--
DELIMITER $$
CREATE TRIGGER `complete_summer24_trigger` AFTER UPDATE ON `summer24` FOR EACH ROW BEGIN
    IF NEW.progress = 100.00 THEN
        IF NOT EXISTS (SELECT 1 FROM summer24complete WHERE project_id = NEW.id) THEN
            INSERT INTO summer24complete (project_id, description, comment, who_c)
            VALUES (NEW.id, 'Summer 24 Project Complete', 'Project completed successfully', 'Automated');
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status_on_insert` BEFORE INSERT ON `summer24` FOR EACH ROW BEGIN
    IF NEW.progress < 100.000 THEN
        -- Check if status is not manually set to 'reject'
        IF NEW.status = 'reject' THEN
            SET NEW.status = 'approved';
        END IF;
    ELSE
        SET NEW.status = 'complete';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status_on_update` BEFORE UPDATE ON `summer24` FOR EACH ROW BEGIN
    IF NEW.progress < 100.000 THEN
        -- Check if status is not manually set to 'reject'
        IF NEW.status = 'reject' THEN
            SET NEW.status = 'approved';
        END IF;
    ELSE
        SET NEW.status = 'complete';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `summer24complete`
--

CREATE TABLE `summer24complete` (
  `id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `who_c` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `summer24faculty`
--

CREATE TABLE `summer24faculty` (
  `id` int NOT NULL,
  `teacher_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `selected_by_head` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `summer24faculty`
--

INSERT INTO `summer24faculty` (`id`, `teacher_id`, `selected_by_head`) VALUES
(24, '41220100092', 1),
(25, '41220100090', 1);

-- --------------------------------------------------------

--
-- Table structure for table `summer24present`
--

CREATE TABLE `summer24present` (
  `id` int NOT NULL,
  `roll` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `summer24present`
--

INSERT INTO `summer24present` (`id`, `roll`, `name`, `date`, `status`) VALUES
(69, '41220100061', 'Hadiatun Jany', '16-02-2024', 'present'),
(70, '41220101621', 'MD Meyad Rahman', '16-02-2024', 'present'),
(71, '41220100056', 'ADIBA BINTE ALAM', '16-02-2024', 'present'),
(72, '41220100058', 'NILIMA HASAN MOHONA', '16-02-2024', 'present'),
(73, '41220100054', 'Md.Al-Amin Hossen Titu', '16-02-2024', 'present'),
(74, '41220100057', 'MD ARIFUL ISLAM SOYEB', '16-02-2024', 'present'),
(75, '41220101630', 'Mahmud Anik', '19-04-2024', 'absent'),
(76, '41220100052', 'Md Ahshan Habib', '19-04-2024', 'absent'),
(77, '41220100051', 'Nusrat Anika', '19-04-2024', 'absent'),
(78, '41220100106', 'MD ABDUL  KHALEQUE', '19-04-2024', 'absent'),
(79, '41220100118', 'Mst Nusrat Jahan', '19-04-2024', 'absent'),
(80, '41220100052', 'Md Ahshan Habib', '26-04-2024', 'present'),
(81, '41220100051', 'Nusrat Anika', '26-04-2024', 'present'),
(82, '41220101630', 'Mahmud Anik', '26-04-2024', 'present'),
(83, '41220100118', 'Mst Nusrat Jahan', '26-04-2024', 'present'),
(84, '41220100106', 'MD ABDUL  KHALEQUE', '26-04-2024', 'present'),
(85, '41220100052', 'Md Ahshan Habib', '12-04-2024', 'present'),
(86, '41220100051', 'Nusrat Anika', '12-04-2024', 'present'),
(87, '41220100118', 'Mst Nusrat Jahan', '12-04-2024', 'present'),
(88, '41220101630', 'Mahmud Anik', '12-04-2024', 'present'),
(89, '41220100106', 'MD ABDUL  KHALEQUE', '12-04-2024', 'present'),
(90, '41220100106', 'MD ABDUL  KHALEQUE', '23-02-2024', 'present'),
(91, '41220101630', 'Mahmud Anik', '23-02-2024', 'present'),
(92, '41220100051', 'Nusrat Anika', '23-02-2024', 'present'),
(93, '41220100052', 'Md Ahshan Habib', '23-02-2024', 'present'),
(94, '41220100118', 'Mst Nusrat Jahan', '23-02-2024', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `t`
--

CREATE TABLE `t` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t`
--

INSERT INTO `t` (`time`, `id`) VALUES
('2024-05-23 13:03:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `task_no` int DEFAULT NULL,
  `group_number` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `task_no`, `group_number`) VALUES
(62, 'Database ta banao', 1, 1),
(63, 'Dashboard banao', 2, 1);

--
-- Triggers `tasks`
--
DELIMITER $$
CREATE TRIGGER `reset_task_no` BEFORE INSERT ON `tasks` FOR EACH ROW BEGIN
    DECLARE max_task_no INT;
    SELECT COALESCE(MAX(task_no), 0) INTO max_task_no FROM tasks WHERE group_number = NEW.group_number;
    SET NEW.task_no = max_task_no + 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `id` int NOT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `class_date` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `teacher_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `session` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`id`, `starting_date`, `ending_date`, `class_date`, `teacher_name`, `session`) VALUES
(32, '2024-02-16', '2024-05-03', '5', 'Tonmoy', 'summer24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `student_id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','faculty','admin','super_admin','master_admin') COLLATE utf8mb4_general_ci NOT NULL,
  `teacher_id` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `semester` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `session` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int NOT NULL,
  `verify` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`student_id`, `name`, `email`, `password`, `role`, `teacher_id`, `id_photo`, `profile_picture`, `semester`, `created_at`, `session`, `id`, `verify`) VALUES
('0', 'Tonmoy', 'tonmoy@gmail.com', 'aaa', 'faculty', '41220100092', 'test.jpg', '69581974_5a59-4084-9fc4-57c6ebaa38e2.jpeg', '7', '2024-03-16 13:51:07', 'summer24', 2, 1),
('0', 'Rayhan SIR', 'rayhan@gmail.com', 'aaa', 'admin', '11', 'test.jpg', '69581974-5a59-4084-9fc4-57c6ebaa38e2.jpeg', '0', '2024-03-16 13:51:07', 'summer24', 14, 1),
('2', 'Master Admin', 'masteradmin@gmail.com', 'aaa', 'master_admin', '2', '0', '0', NULL, '2024-04-16 19:10:04', 'summer24', 53, 1),
('0', 'Mahadi', 'mahadi@gmail.com', 'aaa', 'faculty', '41220100090', 'test.jpg', '69581974_5a59-4084-9fc4-57c6ebaa38e2.jpeg', '7', '2024-03-16 13:51:07', 'summer24', 55, 1),
('41220100052', 'Md Ahshan Habib', 'ahshanhabib@gmail.com', 'aaa', 'student', NULL, '41220100052_id_photo.webp', '41220100052_profile.webp', '7', '2024-04-25 05:26:59', 'summer24', 58, 1),
('41220200170', 'Shanta Akter', 'ShantaAkter@gmail.com', 'aaa', 'student', NULL, '41220200170_id_photo.webp', '41220200170_profile.webp', '6', '2024-04-25 05:33:39', 'summer24', 60, 1),
('41220200187', 'Md Shakib Khan Sourov', 'MdShakibKhanSourov@gmail.com', 'aaa', 'student', NULL, '41220200187_id_photo.webp', '41220200187_profile.webp', '6', '2024-04-25 05:36:31', 'summer24', 61, 1),
('41220200198', 'Diraz Kumar Bala', 'DirazKumarBala@gmail.com', 'aaa', 'student', NULL, '41220200198_id_photo.webp', '41220200198_profile.webp', '6', '2024-04-25 05:38:18', 'summer24', 62, 1),
('41220100051', 'Nusrat Anika', 'nusrat@gmail.com', 'aaa', 'student', NULL, '41220100051_id_photo.webp', '41220100051_profile.webp', '7', '2024-04-25 05:38:52', 'summer24', 63, 1),
('41220200209', 'Tonmoy Saha ', 'TonmoySaha@gmail.com', 'aaa', 'student', NULL, '41220200209_id_photo.webp', '41220200209_profile.webp', '6', '2024-04-25 05:39:47', 'summer24', 64, 1),
('41220200229', 'Abdullah Al Masud ', 'AbdullahAlMasud@gmail.com', 'aaa', 'student', NULL, '41220200229_id_photo.webp', '41220200229_profile.webp', '6', '2024-04-25 05:42:05', 'summer24', 65, 1),
('41220200208', 'Shorove Halder ', 'ShoroveHalder@gmail.com', 'aaa', 'student', NULL, '41220200208_id_photo.webp', '41220200208_profile.webp', '6', '2024-04-25 05:43:52', 'summer24', 66, 1),
('41220100064', 'Pratul Das', 'PratulDas@gmail.com', 'aaa', 'student', NULL, '41220100064_id_photo.webp', '41220100064_profile.webp', '7', '2024-04-25 05:45:12', 'summer24', 68, 1),
('41220100087', 'AlShahriarAhamedRafsun', 'AlShahriarAhamedRafsun@gmail.com', 'aaa', 'student', NULL, '41220100087_id_photo.webp', '41220100087_profile.webp', '7', '2024-04-25 05:48:20', 'summer24', 70, 1),
('41220100061', 'Hadiatun Jany', 'Jany@gmail.com', 'aaa', 'student', NULL, '41220100061_id_photo.webp', '41220100061_profile.webp', '7', '2024-04-25 05:55:17', 'summer24', 72, 1),
('41220100159', 'Asiful Islam Alvi', 'AsifulIslamAlvi@gmail.com', 'aaa', 'student', NULL, '41220100159_id_photo.webp', '41220100159_profile.webp', '7', '2024-04-25 05:55:43', 'summer24', 73, 1),
('41220101621', 'MD Meyad Rahman', 'rahman@gmail.com', 'aaa', 'student', NULL, '41220101621_id_photo.webp', '41220101621_profile.webp', '7', '2024-04-25 05:56:09', 'summer24', 74, 1),
('41220100054', 'Md.Al-Amin Hossen Titu', 'titu@gmail.com', 'aaa', 'student', NULL, '41220100054_id_photo.webp', '41220100054_profile.webp', '7', '2024-04-25 05:58:11', 'summer24', 75, 1),
('41220200221', 'Farjana Akter Ripa', 'FarjanaAkterRipa@gmail.com', 'aaa', 'student', NULL, '41220200221_id_photo.webp', '41220200221_profile.webp', '6', '2024-04-25 06:03:09', 'summer24', 76, 1),
('41220100062', 'MARJAHAN  AKTHER', 'marjahan@gmail.com', 'aaa', 'student', NULL, '41220100062_id_photo.webp', '41220100062_profile.webp', '7', '2024-04-25 06:04:07', 'summer24', 77, 1),
('41220100063', 'MARIYA AKTER', 'mariya@gmail.com', 'aaa', 'student', NULL, '41220100063_id_photo.webp', '41220100063_profile.webp', '7', '2024-04-25 06:04:45', 'summer24', 78, 1),
('41220100084', 'FARHANA AKTER', 'farhana@gmail.com', 'aaa', 'student', NULL, '41220100084_id_photo.webp', '41220100084_profile.webp', '7', '2024-04-25 06:05:35', 'summer24', 79, 1),
('41220100135', 'Ferdous Alam Prince', 'ferdousprince@gmail.com', 'aaa', 'student', NULL, '41220100135_id_photo.webp', '41220100135_profile.webp', '7', '2024-04-25 06:06:20', 'summer24', 80, 1),
('41220100137', 'Sowrav Chandra Das', 'SowravChandraDas@gmail.com', 'aaa', 'student', NULL, '41220100137_id_photo.webp', '41220100137_profile.webp', '7', '2024-04-25 06:11:02', 'summer24', 81, 1),
('41220100140', 'Joyonto kumar Das', 'JoyontokumarDas@gmail.com', 'aaa', 'student', NULL, '41220100140_id_photo.webp', '41220100140_profile.webp', '7', '2024-04-25 06:12:05', 'summer24', 82, 1),
('41220200166', 'Siam Hossain ', 'SiamHossain@gmail.com', 'aaa', 'student', NULL, '41220200166_id_photo.webp', '41220200166_profile.webp', '7', '2024-04-25 06:12:47', 'summer24', 83, 1),
('41220200207', 'Arafat Ikbal', 'ArafatIkbal@gmail.com', '', 'student', NULL, '41220200207_id_photo.webp', '41220200207_profile.webp', '6', '2024-04-25 06:13:31', 'summer24', 84, 1),
('41220200188', 'Nusrat Tasnim Juthi', 'juthi@gmail.com', 'AAA', 'student', NULL, '41220200188_id_photo.webp', '41220200188_profile.webp', '6', '2024-04-25 06:14:14', 'summer24', 85, 1),
('41220200224', 'Sharmily Jahan Shila', 'SharmilyJahanShila@gmail.com', 'aaa', 'student', NULL, '41220200224_id_photo.webp', '41220200224_profile.webp', '6', '2024-04-25 06:15:00', 'summer24', 86, 1),
('41220100105', 'Md Hasibur Rahman', 'HasiburRahman1@gmail.com', 'aaa', 'student', NULL, '41220100105_id_photo.webp', '41220100105_profile.webp', '7', '2024-04-25 06:15:10', 'summer24', 87, 1),
('41220100110', 'Md Emon Ahmed Shishir', 'EmonAhmed@gmail.com', 'aaa', 'student', NULL, '41220100110_id_photo.webp', '41220100110_profile.webp', '7', '2024-04-25 06:18:20', 'summer24', 88, 1),
('41220200226', 'Md. Azmain Sheikh Rubayed', 'Md.AzmainSheikhRubayed@gmail.com', 'aaa', 'student', NULL, '41220200226_id_photo.webp', '41220200226_profile.webp', '6', '2024-04-25 06:18:39', 'summer24', 89, 1),
('41220100154', 'Hridoy Ahmed', 'HridoyAhmed@gmail.com', 'aaa', 'student', NULL, '41220100154_id_photo.webp', '41220100154_profile.webp', '7', '2024-04-25 06:19:01', 'summer24', 90, 1),
('41220100150', 'Tonima Islam', 'TonimaIslam@gmail.com', 'aaa', 'student', NULL, '41220100150_id_photo.webp', '41220100150_profile.webp', '7', '2024-04-25 06:20:14', 'summer24', 91, 1),
('41220100136', 'Ismot Ara Ria', 'Ria123@gmail.com', 'aaa', 'student', NULL, '41220100136_id_photo.webp', '41220100136_profile.webp', '7', '2024-04-25 06:20:36', 'summer24', 92, 1),
('41220100050', 'Mst Sanda Khatun', 'svKhatun@gmail.com', 'aaa', 'student', NULL, '41220100050_id_photo.webp', '41220100050_profile.webp', '7', '2024-04-25 06:20:56', 'summer24', 93, 1),
('41220100053', 'Wajio Tausif', 'Tausif@gmail.com', 'aaa', 'student', NULL, '41220100053_id_photo.webp', '41220100053_profile.webp', '7', '2024-04-25 06:21:49', 'summer24', 94, 1),
('41220100090', 'Md Olik Ahmed ', 'MdOlikAhmed@gmail.com', 'aaa', 'student', NULL, '41220100090_id_photo.webp', '41220100090_profile.webp', '7', '2024-04-25 06:22:18', 'summer24', 95, 1),
('41220100121', 'Mohammed Shoriful Islam', 'MohammedShorifulIslam@gmail.com', 'aaa', 'student', NULL, '41220100121_id_photo.webp', '41220100121_profile.webp', '7', '2024-04-25 06:22:25', 'summer24', 96, 1),
('41210300026', 'Raian Tasnim Tanha', 'RaianTasnim@gmail.com', 'aaa', 'student', NULL, '41210300026_id_photo.webp', '41210300026_profile.webp', '7', '2024-04-25 06:22:58', 'summer24', 97, 1),
('41210300014', 'Md Rakib Hossen', 'MdRakibHossen@gmail.com', 'aaa', 'student', NULL, '41210300014_id_photo.webp', '41210300014_profile.webp', '7', '2024-04-25 06:23:35', 'summer24', 98, 1),
('41220200165', 'Md. Asaduzzaman Ashik', 'ashikkkk@gmail.com', 'aaa', 'student', NULL, '41220200165_id_photo.webp', '41220200165_profile.webp', '7', '2024-04-25 06:24:05', 'summer24', 99, 1),
('41220200184', 'Md Masum Billah', 'billah@gmail.com', 'aaa', 'student', NULL, '41220200184_id_photo.webp', '41220200184_profile.webp', '7', '2024-04-25 06:25:07', 'summer24', 100, 1),
('41220100072', ' ASKAT UDDIN', 'ASKATUDDIN@gmail.com', 'aaa', 'student', NULL, '41220100072_id_photo.webp', '41220100072_profile.webp', '7', '2024-04-25 06:36:56', 'summer24', 101, 1),
('41220100075', 'A.T.M Mazharul Haque ', 'ATMMazharulHaque@gmail.com', 'aaa', 'student', NULL, '41220100075_id_photo.webp', '41220100075_profile.webp', '7', '2024-04-25 06:42:25', 'summer24', 102, 1),
('41200301545', 'Md Saif Bin Wahid', 'MdSaifBinWahid@gmail.com', 'aaa', 'student', NULL, '41200301545_id_photo.webp', '41200301545_profile.webp', '12', '2024-04-25 06:46:33', 'summer24', 103, 1),
('41210101566', 'Md Shafiqur Rahman Akhand', 'MdShafiqurRahmanAkhad@gmail.com', 'aaa', 'student', NULL, '41210101566_id_photo.webp', '41210101566_profile.webp', '12', '2024-04-25 06:48:34', 'summer24', 104, 1),
('41190201364', 'Mohammad Yeasir Arafat', 'MohammadYeasirArafat@gmail.com', 'aaa', 'student', NULL, '41190201364_id_photo.webp', '41190201364_profile.webp', '12', '2024-04-25 06:49:26', 'summer24', 105, 1),
('41220100091', 'Md. Mahfuj Hasan', 'Md.MahfujHasan@gmail.com', 'aaa', 'student', NULL, '41220100091_id_photo.webp', '41220100091_profile.webp', '7', '2024-04-25 06:50:44', 'summer24', 106, 1),
('41220100083', 'Md. Rashaduzzaman Shawon', 'Md.RashaduzzamanShawon@gmail.com', 'aaa', 'student', NULL, '41220100083_id_photo.webp', '41220100083_profile.webp', '7', '2024-04-25 06:52:28', 'summer24', 107, 1),
('41220100078', 'Md. Almas Ahmed Akash', 'Md.AlmasAhmeAkash@gmail.com', 'aaa', 'student', NULL, '41220100078_id_photo.webp', '41220100078_profile.webp', '7', '2024-04-25 06:55:52', 'summer24', 108, 1),
('41220100122', 'Tanvir Islam', 'TanvirIslam@gmail.com', 'aaa', 'student', NULL, '41220100122_id_photo.webp', '41220100122_profile.webp', '7', '2024-04-25 07:01:55', 'summer24', 109, 1),
('41220100141', 'Golam Tanjil', 'GolamTanjil@gmail.com', 'aaa', 'student', NULL, '41220100141_id_photo.webp', '41220100141_profile.webp', '7', '2024-04-25 07:03:19', 'summer24', 110, 1),
('41220100144', 'Sabrina Akter Setu', 'SabrinaAkterSetu@gmail.com', 'aaa', 'student', NULL, '41220100144_id_photo.webp', '41220100144_profile.webp', '7', '2024-04-25 07:08:45', 'summer24', 111, 1),
('41220100142', 'Tanvir Ahammed', 'tanvirahmmed@gmail.com', 'aaa', 'student', NULL, '41220100142_id_photo.webp', '41220100142_profile.webp', '7', '2024-04-25 09:05:50', 'summer24', 112, 1),
('41220100147', 'Md. Rezwan Mahmud', 'RezwanMahmud@gmail.com', 'aaa', 'student', NULL, '41220100147_id_photo.webp', '41220100147_profile.webp', '7', '2024-04-25 09:06:31', 'summer24', 113, 1),
('41220100151', 'Tanjila Hasan Aysi', 'aysi123@gmail.com', 'aaa', 'student', NULL, '41220100151_id_photo.webp', '41220100151_profile.webp', '7', '2024-04-25 09:07:15', 'summer24', 114, 1),
('41220100058', 'NILIMA HASAN MOHONA', 'MOHONA@gmail.com', 'aaa', 'student', NULL, '41220100058_id_photo.webp', '41220100058_profile.webp', '7', '2024-04-25 09:09:11', 'summer24', 115, 1),
('41220100057', 'MD ARIFUL ISLAM SOYEB', 'SOYEB1@gmail.com', 'aaa', 'student', NULL, '41220100057_id_photo.webp', '41220100057_profile.webp', '7', '2024-04-25 09:09:24', 'summer24', 116, 1),
('41220100056', 'ADIBA BINTE ALAM', 'BINTE@gmail.com', 'aaa', 'student', NULL, '41220100056_id_photo.webp', '41220100056_profile.webp', '7', '2024-04-25 09:09:39', 'summer24', 117, 1),
('41220100111', 'Abdullah Al-Noman', 'noman@gmail.com', 'aaa', 'student', NULL, '41220100111_id_photo.webp', '41220100111_profile.webp', '7', '2024-04-25 09:14:01', 'summer24', 118, 1),
('41220101630', 'Mahmud Anik', 'anik@gmail.com', 'aaa', 'student', NULL, '41220101630_id_photo.webp', '41220101630_profile.webp', '7', '2024-04-25 09:18:44', 'summer24', 119, 1),
('41220100118', 'Mst Nusrat Jahan ', 'joyaaaa@gmail.com', 'aaa', 'student', NULL, '41220100118_id_photo.webp', '41220100118_profile.webp', '7', '2024-04-25 09:20:07', 'summer24', 120, 1),
('41220100106', 'MD ABDUL  KHALEQUE', 'khaleque@gmail.com', 'aaaa', 'student', '', '41220100106_id_photo.webp', '41220100106_profile.webp', '7', '2024-04-25 09:47:59', 'summer24', 121, 1),
('4', '4', '4@gmail.com', '4', 'student', NULL, '4_id_photo.webp', '4_profile.webp', '7', '2024-04-25 10:47:50', 'summer24', 123, 1),
('1', '1', '1@gmail.com', '1', 'student', NULL, '1_id_photo.webp', '1_profile.webp', '7', '2024-04-25 10:48:50', 'summer24', 124, 1),
('123456', 'Moderator', 'moderator@gmail.com', 'aaa', 'super_admin', '123456', '', '', '7', '2024-03-16 13:51:07', 'summer24', 125, 1),
('1234567', 'Kumul papi', 'kumul@gmail.com', 'aaa', 'student', NULL, '1234567_id_photo.webp', '1234567_profile.webp', '7', '2024-05-23 10:40:17', 'summer24', 126, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_management`
--
ALTER TABLE `project_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_students`
--
ALTER TABLE `project_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summer24`
--
ALTER TABLE `summer24`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_name` (`project_name`);

--
-- Indexes for table `summer24complete`
--
ALTER TABLE `summer24complete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summer24faculty`
--
ALTER TABLE `summer24faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summer24present`
--
ALTER TABLE `summer24present`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t`
--
ALTER TABLE `t`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `project_management`
--
ALTER TABLE `project_management`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `project_students`
--
ALTER TABLE `project_students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1549;

--
-- AUTO_INCREMENT for table `summer24`
--
ALTER TABLE `summer24`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `summer24complete`
--
ALTER TABLE `summer24complete`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `summer24faculty`
--
ALTER TABLE `summer24faculty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `summer24present`
--
ALTER TABLE `summer24present`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `t`
--
ALTER TABLE `t`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `time`
--
ALTER TABLE `time`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
