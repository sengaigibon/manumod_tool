SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `datacenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdx_kfz_model_countries`
--
use `datacenter`;
CREATE TABLE `mdx_kfz_model_countries` (
   `id` int NOT NULL DEFAULT '0',
   `countryId` int NOT NULL DEFAULT '0' COMMENT 'foreign key in mdx_countries'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdx_kfz_model_countries`
--
ALTER TABLE `mdx_kfz_model_countries`
    ADD PRIMARY KEY (`id`,`countryId`);
COMMIT;

use `datacenter`;
ALTER TABLE `mdx_kfz_model_countries`
    RENAME COLUMN `id` TO `modelId`;

use `datacenter`;
ALTER TABLE `mdx_kfz_model_countries`
    ADD COLUMN `id` INT AUTO_INCREMENT UNIQUE FIRST;