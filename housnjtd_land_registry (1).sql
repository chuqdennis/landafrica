-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2019 at 04:58 AM
-- Server version: 10.1.40-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `housnjtd_land_registry`
--

-- --------------------------------------------------------

--
-- Table structure for table `lands`
--

CREATE TABLE `lands` (
  `id` int(11) NOT NULL,
  `landId` varchar(100) NOT NULL,
  `estate_id` int(11) NOT NULL,
  `land_type` varchar(25) NOT NULL,
  `landTitle` varchar(1000) NOT NULL,
  `coords` longtext NOT NULL,
  `area` varchar(25) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `state` varchar(25) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(25) NOT NULL,
  `status` varchar(25) NOT NULL,
  `currentOwner` varchar(100) NOT NULL,
  `txnID` varchar(500) NOT NULL,
  `txnLink` varchar(1000) NOT NULL,
  `prevOwner` varchar(100) NOT NULL,
  `dateAdded` varchar(25) NOT NULL,
  `lastModified` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lands`
--

INSERT INTO `lands` (`id`, `landId`, `estate_id`, `land_type`, `landTitle`, `coords`, `area`, `address`, `state`, `city`, `postal_code`, `status`, `currentOwner`, `txnID`, `txnLink`, `prevOwner`, `dateAdded`, `lastModified`) VALUES
(10, 'RGY-V2ECO1', 0, 'Single', '9 Plots of land', '4.816418270418305:6.989560294655803,4.815215537386866:6.989651489762309,4.814985681498734:6.990279126671794,4.815087245737905: 6.9907941108026534,4.816525179918055:6.9900430922784835,4.816418270418305:6.989560294655803', '4009', 'Rumuola Road, Port Harcourt, Nigeria', 'Rivers', 'Port Harcourt', '500272', 'Allocated', 'Ayebatonye Joshua', '2yDVtTCDtSEWtsebdeEqziXsqgAb3ebuC8EeHZcpcBdo', 'https://wavesexplorer.com/tx/2yDVtTCDtSEWtsebdeEqziXsqgAb3ebuC8EeHZcpcBdo', 'N/A', '03-June-2019', 'N/A'),
(11, 'RGY-GDLTJK', 0, 'Estate', 'Tech creek', '4.836396824712705: 7.012265618529,4.836447605232102:7.013236578192391,4.836382125087983: 7.014199491228737,4.8360226523471335:7.014191444601693,4.835552263937069: 7.014100249495186,4.835370522872927:7.013558443274178,4.835653825098698:7.012533839430489,4.836396824712705:7.012265618529', '3434', 'Elekahia Road, Port Harcourt, Nigeria', 'Rivers', 'Port Harcourt', '500272', 'Mixed', 'Nathaniel Oswald', 'As6RAcwfXxhNoMYfamrxDePbbFiQKuMqzJQFmYDo4yx1', 'https://wavesexplorer.com/tx/As6RAcwfXxhNoMYfamrxDePbbFiQKuMqzJQFmYDo4yx1', 'N/A', '03-June-2019', 'N/A'),
(13, 'RGY-QPDUC4', 0, 'Estate', 'Kaduna state university', '9.098243150184958:7.471330934743946,9.097596924575623:7.473519617300099,9.099954053334178:7.474377924184864,9.100899548932377:7.47324066756255,9.098243150184958:7.471330934743946', '12000', 'Kaduna State University, Tafawa Balewa Road, Kaduna, Nigeria', 'Kaduna', 'Kaduna', '', 'Mixed', 'Ayebatonye Joshua', 'HnpdMZMwEJUfPFcjfbF7tjjjHVksPb5WrmrG3Eaqffyd', 'https://wavesexplorer.com/tx/HnpdMZMwEJUfPFcjfbF7tjjjHVksPb5WrmrG3Eaqffyd', 'N/A', '14-June-2019', 'N/A'),
(14, 'RGY-MKH71F', 13, 'Single', 'General hospital kaduna', '9.099472035008574:7.473251396398609,9.099334315367678:7.474013143758839,9.099911678122805:7.474206262807911,9.100486391499432:7.473358684759205,9.099779255554894:7.472875887136524', '2000', 'Hospital Road, Kaduna, Nigeria', 'Kaduna', 'Kaduna', '', 'Vacant', 'Bethram Harry', 'Eu3yYUQv7b1V86HYxQMdvrWg9cy5qcKVYnjMv7X7N8g1', 'https://wavesexplorer.com/tx/Eu3yYUQv7b1V86HYxQMdvrWg9cy5qcKVYnjMv7X7N8g1', 'N/A', '14-June-2019', 'N/A'),
(16, 'RGY-44P6UK', 13, 'Single', 'ICT Center kaduna', '9.098423245638607:7.473401600103443,9.098587450237913:7.472875887136524,9.098876132334665:7.47198539374358,9.09865631020877:7.4717493593502695,9.098243150184958: 7.471545511465138,9.098010085345694:7.4722750723171885,9.098010085345694:7.472865158300465', '3000', 'Kaduna ICT Hub, Independence Way, Kaduna, Nigeria', 'Kaduna', 'Kaduna', '', 'Allocated', 'Okoye Emmanuel', '3WEK4TysuQHpYhJh9iztRD96hDuCa8uv9XGng3Uiuc87', 'https://wavesexplorer.com/tx/3WEK4TysuQHpYhJh9iztRD96hDuCa8uv9XGng3Uiuc87', 'N/A', '14-June-2019', 'N/A'),
(17, 'RGY-C8VFCR', 0, 'Estate', 'Mubeen International', '71:89,:,:,71:100,72:89', '1000', '1 Jimmy Carter Street, Abuja, Nigeria', 'Federal Capital Territory', 'Abuja', '', 'Mixed', 'N/A', '8Cjv8zEg5jyifNUDcNAoS6Dr1cHexPmDV65JdZ2cPw1e', 'https://wavesexplorer.com/tx/8Cjv8zEg5jyifNUDcNAoS6Dr1cHexPmDV65JdZ2cPw1e', 'N/A', '17-June-2019', 'N/A'),
(18, 'RGY-RFSA4E', 0, 'Estate', 'FHF 1', '7.411078:9.021537,7.412024:9.021017', '10000', 'Masaka, Abuja-Keffi Road, New Karu, Nigeria', 'Nasarawa', 'New Karu', '', 'Mixed', 'N/A', '52MLDVQiCtiwDmQCDEi2FxMKYLLGysenobYXBfcyKdbw', 'https://wavesexplorer.com/tx/52MLDVQiCtiwDmQCDEi2FxMKYLLGysenobYXBfcyKdbw', 'N/A', '17-June-2019', 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lands`
--
ALTER TABLE `lands`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lands`
--
ALTER TABLE `lands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
