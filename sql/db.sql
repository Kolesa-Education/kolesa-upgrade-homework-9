CREATE TABLE `adverts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`id`)
)
