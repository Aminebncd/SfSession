-- --------------------------------------------------------
-- Hôte:                         localhost
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sfsession
CREATE DATABASE IF NOT EXISTS `sfsession` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sfsession`;

-- Listage de la structure de table sfsession. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id`, `label`) VALUES
	(1, 'DEV WEB'),
	(2, 'BUREAUTIQUE'),
	(3, 'GRASPHISME'),
	(4, 'SANTE'),
	(5, 'TECHNIQUE DE RECHERCHE D\'EMPLOI');

-- Listage de la structure de table sfsession. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table sfsession.doctrine_migration_versions : ~2 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20240307101203', '2024-03-07 10:12:55', 1074),
	('DoctrineMigrations\\Version20240307152312', '2024-03-07 15:23:34', 216);

-- Listage de la structure de table sfsession. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.formateur : ~2 rows (environ)
INSERT INTO `formateur` (`id`, `nom`, `prenom`, `email`) VALUES
	(1, 'Bounachada', 'Mohamed Amine', 'aminebncd_pro@hotmail.com'),
	(2, 'Murmann', 'Mickael', 'MickaMurmann@elan.fr');

-- Listage de la structure de table sfsession. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.formation : ~3 rows (environ)
INSERT INTO `formation` (`id`, `titre`) VALUES
	(1, 'Developpeur web et web/mobile'),
	(2, 'Dentaire'),
	(3, 'Secretaire');

-- Listage de la structure de table sfsession. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sfsession. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `intitule_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.module : ~8 rows (environ)
INSERT INTO `module` (`id`, `categorie_id`, `intitule_module`) VALUES
	(1, 1, 'Initiation à PHP'),
	(2, 1, 'SQL'),
	(3, 1, 'Introduction à Symfony'),
	(4, 2, 'Fondamentaux d\'Excel'),
	(5, 2, 'principes de base de Powerpoint'),
	(6, 4, 'Mesures essentielles d\'hygiene'),
	(7, 5, 'Creation de CV'),
	(8, 3, 'Maquettage 101');

-- Listage de la structure de table sfsession. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int DEFAULT NULL,
  `session_id` int DEFAULT NULL,
  `duree` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.programme : ~4 rows (environ)
INSERT INTO `programme` (`id`, `module_id`, `session_id`, `duree`) VALUES
	(1, 1, 3, 15),
	(2, 2, 3, 5),
	(3, 3, 3, 20),
	(4, 8, 3, 5);

-- Listage de la structure de table sfsession. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation_id` int DEFAULT NULL,
  `formateur_id` int DEFAULT NULL,
  `createur_id` int DEFAULT NULL,
  `intitule_session` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `nombre_places` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  KEY `IDX_D044D5D473A201E5` (`createur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`),
  CONSTRAINT `FK_D044D5D473A201E5` FOREIGN KEY (`createur_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.session : ~34 rows (environ)
INSERT INTO `session` (`id`, `formation_id`, `formateur_id`, `createur_id`, `intitule_session`, `date_debut`, `date_fin`, `nombre_places`) VALUES
	(1, 1, 1, 1, 'Session test', '2024-03-07 13:59:55', '2025-03-07 13:59:56', 20),
	(2, 2, 1, 1, 'Session test 2', '2024-03-07 16:07:56', '2025-03-07 16:07:57', 25),
	(3, 1, 1, 1, 'Session créée sur symfony', '2024-03-04 09:25:00', '2024-03-16 09:24:00', 35),
	(4, 2, 1, 1, 'test ajout session bis', '2024-01-01 00:00:00', '2024-03-01 00:00:00', 3),
	(5, 3, 2, 1, 'Formation 1', '2024-05-28 23:16:10', '2024-05-30 23:16:10', 11),
	(6, 1, 2, 1, 'Formation 2', '2024-12-25 19:38:27', '2024-12-27 19:38:27', 21),
	(7, 2, 2, 1, 'Formation 3', '2024-10-15 02:38:36', '2024-10-20 02:38:36', 24),
	(8, 3, 2, 1, 'Formation 4', '2024-06-20 19:24:06', '2024-06-22 19:24:06', 43),
	(9, 1, 1, 1, 'Formation 5', '2024-12-05 07:17:05', '2024-12-10 07:17:05', 38),
	(10, 3, 1, 1, 'Formation 6', '2024-09-29 14:25:34', '2024-10-01 14:25:34', 11),
	(11, 2, 1, 1, 'Formation 7', '2024-07-28 02:05:16', '2024-07-29 02:05:16', 44),
	(12, 1, 1, 1, 'Formation 8', '2024-12-01 08:58:42', '2024-12-02 08:58:42', 41),
	(13, 1, 1, 1, 'Formation 9', '2024-09-23 16:25:57', '2024-09-27 16:25:57', 25),
	(14, 2, 2, 1, 'Formation 10', '2024-09-16 16:20:15', '2024-09-20 16:20:15', 15),
	(15, 3, 2, 1, 'Formation 11', '2024-07-03 09:11:00', '2024-07-05 09:11:00', 44),
	(16, 2, 1, 1, 'Formation 12', '2024-04-04 12:03:50', '2024-04-08 12:03:50', 24),
	(17, 3, 1, 2, 'Formation 13', '2024-03-31 20:58:30', '2024-04-03 20:58:30', 43),
	(18, 3, 1, 1, 'Formation 14', '2024-06-23 13:19:17', '2024-06-26 13:19:17', 21),
	(19, 1, 1, 1, 'Formation 15', '2024-06-10 09:13:58', '2024-06-14 09:13:58', 28),
	(20, 3, 2, 1, 'Formation 16', '2024-08-01 10:26:03', '2024-08-06 10:26:03', 10),
	(21, 2, 2, 1, 'Formation 17', '2024-06-20 11:41:21', '2024-06-25 11:41:21', 11),
	(22, 1, 2, 1, 'Formation 18', '2024-08-26 00:18:48', '2024-08-27 00:18:48', 40),
	(23, 3, 2, 1, 'Formation 19', '2024-06-22 18:36:03', '2024-06-27 18:36:03', 29),
	(24, 1, 1, 2, 'Formation 20', '2024-02-21 17:59:43', '2024-02-24 17:59:43', 16),
	(25, 2, 1, 1, 'Formation 21', '2024-02-04 02:55:27', '2024-02-06 02:55:27', 42),
	(26, 2, 2, 1, 'Formation 22', '2024-06-25 17:03:20', '2024-06-29 17:03:20', 38),
	(27, 1, 1, 1, 'Formation 23', '2024-11-03 03:03:19', '2024-11-07 03:03:19', 31),
	(28, 1, 2, 1, 'Formation 24', '2024-09-23 01:44:07', '2024-09-27 01:44:07', 24),
	(29, 2, 1, 1, 'Formation 25', '2024-01-16 15:29:32', '2024-01-17 15:29:32', 47),
	(30, 3, 2, 1, 'Formation 26', '2024-06-14 07:32:53', '2024-06-19 07:32:53', 33),
	(31, 3, 1, 2, 'Formation 27', '2024-05-27 14:15:09', '2024-06-01 14:15:09', 14),
	(32, 2, 2, 1, 'Formation 28', '2024-12-30 02:42:18', '2025-01-02 02:42:18', 13),
	(33, 1, 1, 2, 'Formation 29', '2024-02-22 08:40:09', '2024-02-23 08:40:09', 15),
	(34, 3, 1, 1, 'Formation 30', '2024-04-26 03:59:06', '2024-05-01 03:59:06', 46);

-- Listage de la structure de table sfsession. session_user
CREATE TABLE IF NOT EXISTS `session_user` (
  `session_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`user_id`),
  KEY `IDX_4BE2D663613FECDF` (`session_id`),
  KEY `IDX_4BE2D663A76ED395` (`user_id`),
  CONSTRAINT `FK_4BE2D663613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4BE2D663A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.session_user : ~2 rows (environ)
INSERT INTO `session_user` (`session_id`, `user_id`) VALUES
	(1, 2),
	(3, 2);

-- Listage de la structure de table sfsession. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` datetime NOT NULL,
  `sexe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsession.user : ~2 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `date_naissance`, `sexe`, `ville`, `telephone`) VALUES
	(1, 'aminebncd_pro@hotmail.com', '["ROLE_ADMIN"]', '$2y$13$pC/Jgcx4ECcSNPjp5SW7RuBDNdjSWy9eCDAk7Mp1jESJ6yUrG16OO', 'Bounachada', 'Mohamed Amine', '2001-01-15 00:00:00', 'homme', 'strasbourg', '0000000000'),
	(2, 'test@test.test', '[]', '$2y$13$o81YlvPn0eUNegmw8L5lLe.Qag4jOUz.MSUQts7XlXS1PwXTSSERi', 'test', 'test', '1998-04-05 00:00:00', 'autre', 'test', '6677889911');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
