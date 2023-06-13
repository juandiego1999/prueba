-- Adminer 4.8.1 MySQL 5.5.5-10.3.38-MariaDB-0ubuntu0.20.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `candidates`;
CREATE TABLE `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commune` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commune` (`commune`),
  CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`commune`) REFERENCES `communes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `communes`;
CREATE TABLE `communes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` int(11) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `region` (`region`),
  CONSTRAINT `communes_ibfk_1` FOREIGN KEY (`region`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` text NOT NULL,
  `alias` text NOT NULL,
  `rut` text NOT NULL,
  `email` text NOT NULL,
  `region` int(11) NOT NULL,
  `commune` int(11) NOT NULL,
  `candidate` int(11) NOT NULL,
  `meet` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate` (`candidate`),
  KEY `commune` (`commune`),
  KEY `region` (`region`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`candidate`) REFERENCES `candidates` (`id`),
  CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`commune`) REFERENCES `communes` (`id`),
  CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`region`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- 2023-06-13 14:34:32
