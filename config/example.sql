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

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

-- NOTE:  Passwords are the salt concatenated with the password

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', SHA1('supersecretsalt-password'));