# IIG-test



Database: `auth_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `fname` varchar(255) NOT NULL,
  `Lname` varchar(255) NULL,
  `username` varchar(255) NOT NULL UNIQUE KEY,
  `password` varchar(255) NOT NULL,
  `pp` varchar(255) NOT NULL DEFAULT 'default-pp.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



