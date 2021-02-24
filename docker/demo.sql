SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `demo_wmfs`
-- main database to be used in main Laravel project
--
DROP DATABASE IF EXISTS demo_wmfs;
CREATE DATABASE demo_wmfs DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;


--
-- Database: `todo`
-- database used in 02.2 INTRODUCING ORM
--
DROP DATABASE IF EXISTS simpletodo;
CREATE DATABASE simpletodo DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE simpletodo;

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `what` varchar(255) NOT NULL,
                         `priority` enum('high','normal','low') NOT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `what`, `priority`) VALUES
(1,  'ksat tnegru yrev A', 'high'),
(2,  'A normal priority task', 'normal'),
(3,  'A low priority task', 'low'),
(4,  'A very urgent task', 'high');

-- --------------------------------------------------------
