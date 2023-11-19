CREATE TABLE `partie` (
  `Identifiant` int(10) NOT NULL AUTO_INCREMENT,
  `J1` varchar(20) NOT NULL,
  `J2` varchar(20) NOT NULL,
  `Gagnant` varchar(20) DEFAULT NULL,
  `Plateau` varchar(255) NOT NULL,
  PRIMARY KEY (`Identifiant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;