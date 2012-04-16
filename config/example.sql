-- Example database for Sungem sample app

--
-- Database: `test`
--
CREATE DATABASE `test` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Table structure for table `some_strings`
--

CREATE TABLE IF NOT EXISTS `some_strings` (
  `string` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `some_strings`
--

INSERT INTO `some_strings` (`string`) VALUES
('foo'),
('bar');
