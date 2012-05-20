--
-- Database: 'sungem'
--
CREATE DATABASE sungem DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE sungem;

-- --------------------------------------------------------

--
-- Table structure for table 'some_strings'
--

CREATE TABLE some_strings (
  `string` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table 'some_strings'
--

INSERT INTO some_strings (`string`) VALUES
('Foo'),
('Bar'),
('Baz');

-- --------------------------------------------------------

--
-- Table structure for table 'users'
--

CREATE TABLE users (
  username varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table 'users'
--

-- NOTE: password for users is sha1 hash of salt prepended to the password
INSERT INTO users (username, `password`) VALUES
('admin', SHA1('supersecretsalt-p@ssw0rd'));
