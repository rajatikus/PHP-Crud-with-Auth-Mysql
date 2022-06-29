

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test123`
--

-- --------------------------------------------------------

--
-- Table structure for table `datawarga`
--

CREATE TABLE `datawarga` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lahir` date DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `telpon` int(16) NOT NULL,
  `kepala` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datawarga`
--

INSERT INTO `datawarga` (`id`, `name`, `lahir`, `address`, `telpon`, `kepala`) VALUES
(9, 'Skurarr', '2022-06-02', 'qwewqqwe', 1234, 'Maradonna'),
(12, 'Andika', '2022-06-10', 'Perkutut 14', 40000, 'Ramboi'),
(14, 'Adrra', '2022-06-02', 'Askljajkdghadasasd', 30000, 'Sukraman'),
(18, 'Arman', '2022-06-09', '1qadasdad', 121445, 'Armando'),
(19, 'Romandi', '2022-05-31', 'Singkawang', 1241515551, 'Romni'),
(20, 'Rungkang', '2022-06-01', 'Singakwang', 12445566, 'Sirmana'),
(21, 'Sudirman', '2022-06-07', 'Jakarta 12345', 1234151556, 'Soport');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'asas', '$2y$10$xxx1FVTxK5i.NmT8zZ6IEuk7h2TDFiYX.MCpj6lNtHwyKVnMtHp4K', '2022-06-28 22:56:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datawarga`
--
ALTER TABLE `datawarga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `datawarga`
--
ALTER TABLE `datawarga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
