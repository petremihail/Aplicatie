# ************************************************************
# Sequel Ace SQL dump
# Version 20088
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 9.2.0)
# Database: hr
# Generation Time: 2025-06-05 08:15:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attendances
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attendances`;

CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `clock_in` time DEFAULT NULL,
  `clock_out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_user_id_foreign` (`user_id`),
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;

INSERT INTO `attendances` (`id`, `user_id`, `date`, `clock_in`, `clock_out`, `created_at`, `updated_at`)
VALUES
	(1,11,'2025-04-22','16:30:59','16:31:01','2025-04-22 16:30:59','2025-04-22 16:31:01');

/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table cache_locks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_post_id_foreign` (`post_id`),
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'excelent','2025-04-23 19:40:09','2025-04-23 19:40:09'),
	(2,1,1,'asdasdasda da das das das as dasd asd e fergvtrh f dfds f','2025-04-23 20:05:36','2025-04-23 20:05:36'),
	(3,1,1,'sdasfsfgtfdsadfvdgfg','2025-04-23 20:06:32','2025-04-23 20:06:32'),
	(4,1,1,'fdsftrhrhrtg','2025-04-23 20:06:35','2025-04-23 20:06:35'),
	(5,1,1,'fsdfergrthukuesdf','2025-04-23 20:06:38','2025-04-23 20:06:38'),
	(6,1,1,'fgergyj6j67rjyujyu','2025-04-23 20:06:42','2025-04-23 20:06:42'),
	(7,1,1,'jhtnyukdas','2025-04-23 20:06:46','2025-04-23 20:06:46'),
	(8,1,1,'ewirwe','2025-04-23 20:06:50','2025-04-23 20:06:50'),
	(9,1,1,'1','2025-04-23 20:06:52','2025-04-23 20:06:52'),
	(10,1,1,'1','2025-04-23 20:06:55','2025-04-23 20:06:55'),
	(11,1,1,'1','2025-04-23 20:06:58','2025-04-23 20:06:58'),
	(12,1,1,'1','2025-04-23 20:07:01','2025-04-23 20:07:01'),
	(13,1,1,'1','2025-04-23 20:07:04','2025-04-23 20:07:04'),
	(14,1,1,'1','2025-04-23 20:07:13','2025-04-23 20:07:13'),
	(15,1,1,'1','2025-04-23 20:07:15','2025-04-23 20:07:15'),
	(16,11,1,'dasdas','2025-04-23 20:08:13','2025-04-23 20:08:13'),
	(17,11,1,'test zoom','2025-04-24 13:05:24','2025-04-24 13:05:24');

/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contract_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contract_user`;

CREATE TABLE `contract_user` (
  `user_id` bigint unsigned NOT NULL,
  `contract_id` bigint unsigned NOT NULL,
  KEY `contract_user_user_id_foreign` (`user_id`),
  KEY `contract_user_contract_id_foreign` (`contract_id`),
  CONSTRAINT `contract_user_contract_id_foreign` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contract_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contract_user` WRITE;
/*!40000 ALTER TABLE `contract_user` DISABLE KEYS */;

INSERT INTO `contract_user` (`user_id`, `contract_id`)
VALUES
	(1,1),
	(1,2),
	(3,1),
	(4,1);

/*!40000 ALTER TABLE `contract_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contracts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contracts`;

CREATE TABLE `contracts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contracts` WRITE;
/*!40000 ALTER TABLE `contracts` DISABLE KEYS */;

INSERT INTO `contracts` (`id`, `name`, `start_date`, `end_date`, `created_at`, `updated_at`)
VALUES
	(1,'Bins-Pfeffer','1974-11-25 00:00:00','2021-04-28 00:00:00','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(2,'Medhurst PLC','2005-05-12 00:00:00','2003-10-16 00:00:00','2025-03-20 10:03:59','2025-03-20 10:03:59');

/*!40000 ALTER TABLE `contracts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table course_contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_contents`;

CREATE TABLE `course_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_contents_course_id_foreign` (`course_id`),
  CONSTRAINT `course_contents_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table course_user_progress
# ------------------------------------------------------------

DROP TABLE IF EXISTS `course_user_progress`;

CREATE TABLE `course_user_progress` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `course_id` bigint unsigned NOT NULL,
  `completed_content_ids` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_user_progress_user_id_foreign` (`user_id`),
  KEY `course_user_progress_course_id_foreign` (`course_id`),
  CONSTRAINT `course_user_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_user_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `course_user_progress` WRITE;
/*!40000 ALTER TABLE `course_user_progress` DISABLE KEYS */;

INSERT INTO `course_user_progress` (`id`, `user_id`, `course_id`, `completed_content_ids`, `created_at`, `updated_at`)
VALUES
	(1,11,1,'[]','2025-04-23 09:49:45','2025-04-23 09:51:27'),
	(2,1,1,'[]','2025-04-23 09:53:22','2025-04-23 22:58:43');

/*!40000 ALTER TABLE `course_user_progress` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'junior',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `name`, `description`, `created_at`, `updated_at`, `category`)
VALUES
	(1,'sit','123123Enim soluta consectetur quo atque quo voluptatibus sint.','2025-04-22 17:15:38','2025-06-04 19:39:19','mid'),
	(2,'est','Nisi eum odio et placeat rerum dicta.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(3,'harum','Modi voluptas eius cum.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(4,'sunt','Et voluptatem et exercitationem blanditiis veniam eos.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(5,'rerum','Asperiores dolor non molestiae voluptatibus.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(6,'sed','Et architecto soluta quaerat qui in culpa facere.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(7,'culpa','A qui dolorem a voluptatibus.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(8,'nihil','Quo voluptatibus nesciunt quod perspiciatis neque odio.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(9,'placeat','Non voluptatem quas et quis est eos.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(10,'amet','At sit dolorum beatae quidem doloremque officia.','2025-04-22 17:15:38','2025-04-22 17:15:38','junior'),
	(11,'testet','asd123','2025-04-24 15:16:34','2025-04-24 15:16:34','junior');

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses_users`;

CREATE TABLE `courses_users` (
  `course_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  KEY `courses_users_course_id_foreign` (`course_id`),
  KEY `courses_users_user_id_foreign` (`user_id`),
  CONSTRAINT `courses_users_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `courses_users` WRITE;
/*!40000 ALTER TABLE `courses_users` DISABLE KEYS */;

INSERT INTO `courses_users` (`course_id`, `user_id`)
VALUES
	(1,1),
	(1,11),
	(1,13);

/*!40000 ALTER TABLE `courses_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table job_batches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(106,'0001_01_01_000000_create_users_table',1),
	(107,'0001_01_01_000001_create_cache_table',1),
	(108,'0001_01_01_000002_create_jobs_table',1),
	(109,'2025_03_19_195955_create_contracts_table',1),
	(110,'2025_03_19_201123_create_contract_user_table',1),
	(111,'2025_03_20_075658_create_attendances_table',1),
	(114,'2025_03_20_082153_create_posts_table',1),
	(115,'2025_03_20_082234_create_comments_table',1),
	(116,'2025_03_20_082407_create_surveys_table',1),
	(117,'2025_03_20_082500_create_questions_table',1),
	(118,'2025_03_20_082632_create_question_survey_table',1),
	(119,'2025_03_20_082834_create_submissions_table',1),
	(120,'2025_03_26_103456_create_roles_table',2),
	(121,'2025_03_26_103509_create_role_user_table',2),
	(122,'2025_04_22_165712_create_courses_table',3),
	(123,'2025_04_22_170538_create_courses_users_table',3),
	(124,'2025_04_22_173947_create_course_contents_table',4),
	(125,'2025_04_22_174415_create_course_user_progress_table',5),
	(127,'2025_03_20_081301_create_priorities_table',6),
	(128,'2025_03_20_081302_create_tasks_table',6),
	(129,'2025_04_23_130728_create_task_user_table',6),
	(130,'2025_04_23_190251_create_survey_user_table',7);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_reset_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `title`, `content`, `created_at`, `updated_at`)
VALUES
	(1,'Consectetur est quas corporis quis.','adasdaExercitationem et et eum tempore nemo officiis. Sed incidunt et rerum cupiditate odit fugiat cupiditate sit. Qui aspernatur quibusdam non ab occaecati. Corporis dolores excepturi est qui quod dolorem.\r\n\r\nNon autem et incidunt omnis. Dolor et laboriosam fuga nihil voluptates sit suscipit. Qui asperiores odio sit nam illum. Dolorem iste et sit aut.\r\n\r\nSequi accusamus et ea aut aut fugiat ex. Debitis impedit veritatis velit est ut earum. Aperiam ducimus nostrum iure.\r\n\r\nNatus excepturi aliquid et. Et esse sunt aspernatur ut sit natus. Provident doloremque esse at blanditiis occaecati quidem maiores.\r\n\r\nOptio consequatur ut neque fuga rerum accusantium pariatur. Enim distinctio voluptas rerum quasi ratione. Ut consequuntur animi eveniet magni ex est.','2025-04-23 19:39:29','2025-04-23 22:56:23'),
	(2,'Voluptatem ullam dolores est eius dolor.','Consectetur voluptas fugit id ut perferendis deserunt excepturi consequatur. Et omnis sunt mollitia cum. Autem est blanditiis laborum iusto pariatur quibusdam. Aut deserunt nostrum earum voluptatem impedit quis sit.\n\nPerferendis sit ducimus id eos officiis quo. Voluptatem et sit fugit nesciunt.\n\nAssumenda dolorem iusto non repudiandae doloribus. Magnam eveniet voluptatem voluptas laudantium placeat. Aut sunt non sit totam consequatur minima. Sit accusantium aut quae explicabo.\n\nExcepturi occaecati ab molestiae possimus. Iure molestias quae amet ut. Nihil aut eos minima sequi. Recusandae ad sit repellat qui est.\n\nUt suscipit dolores laborum nostrum aut. Dolores dolorum omnis laudantium voluptas aut. Et quibusdam ut incidunt expedita omnis ut quia. Et nulla suscipit consectetur et tenetur et aperiam.\n\nCommodi eum consectetur eveniet sint accusamus. Fugiat sequi et sunt est odit et. Quia quo sapiente quia voluptas nam et quibusdam.\n\nEt autem ipsum nobis quo illo necessitatibus nam. Saepe a vel tempore sed iure molestiae sint. Sapiente et quisquam quia et distinctio nam. Omnis dolorem id voluptas exercitationem voluptatem.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(3,'Id facere corrupti eos.','Voluptatem commodi blanditiis necessitatibus praesentium sed illum eos. Quam eos ad molestiae iusto omnis sapiente animi. Qui dicta unde rem ut aut. Ea debitis laborum unde amet. Aut corrupti illum non reiciendis minima accusamus distinctio.\n\nQuia quam sed possimus voluptas neque qui. Et minima sed voluptatem. Nemo occaecati eveniet voluptas a aliquid vero. Saepe a vel rerum cupiditate suscipit autem.\n\nId ut impedit dolore doloremque veniam voluptatem ratione consectetur. Aut fugiat odio voluptatem sint quos modi similique. Quis voluptas ad accusamus corrupti enim esse ullam quod. Enim quo deserunt quo neque reprehenderit eos quaerat omnis.\n\nEst excepturi quae iure molestias. Quia dolores blanditiis nesciunt inventore est perferendis exercitationem. Veritatis odit molestiae vel nam.\n\nNon et reiciendis debitis dolores hic in. Eum rerum est similique eveniet. Placeat qui provident laborum quo est neque vero.\n\nTenetur enim non quia ut. Id in aliquam eum provident. Non perspiciatis nostrum maiores ipsam tempore tempora maiores ut.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(4,'Placeat temporibus et quibusdam ad.','Sapiente omnis nisi soluta praesentium. Impedit veniam sit dicta qui dolores consectetur. Provident qui odio velit dolorum perspiciatis ipsam aut. Aut inventore repudiandae nisi et vitae.\n\nVeritatis perferendis atque eum optio laudantium officia ipsum. Nemo dolor dolor et eveniet.\n\nIn at dolor voluptates qui maxime molestias voluptatem. Consequatur eius recusandae sed aliquam nulla. Expedita praesentium occaecati error incidunt et odit aut. Odio et qui earum provident. Aperiam corporis et optio.\n\nIn magni nam suscipit consequuntur. Eos sunt quasi quae corporis. In ratione ut nisi ipsa consequuntur. Occaecati omnis dolor ipsum est.\n\nVelit molestias laudantium sint commodi autem fugit quod. Odio et corrupti cupiditate aspernatur quasi. Enim et ducimus eum vitae dicta voluptatem.\n\nInventore labore dolorem molestiae qui quae aut repellat. Et reiciendis ut blanditiis sequi expedita odio nisi. Provident vel nam doloribus voluptas. Commodi et sit ratione laboriosam in. Deleniti ut velit non explicabo dolorem enim quia accusantium.\n\nProvident tenetur asperiores aut molestiae quidem provident. Doloribus dignissimos temporibus minima assumenda. Repellat saepe in hic quis totam ea necessitatibus. Fugit qui ab fugiat earum quam error at. Inventore ad dolorem autem reprehenderit.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(5,'Blanditiis id animi quos rerum ut voluptatem harum eum.','Sunt quasi praesentium veniam rerum omnis iusto. Corporis et suscipit atque ea ad. Fuga voluptatibus voluptatem vel est.\n\nMolestias expedita ullam blanditiis officiis vel pariatur. Ut facere omnis sunt consequatur. Exercitationem velit libero eveniet quia quos sunt. Optio minima magni voluptatem doloribus possimus.\n\nUt enim eaque reiciendis. Rerum hic laudantium et quo a et odit nihil. Sit perspiciatis et accusantium provident amet. Temporibus qui consequatur iure numquam.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(6,'Quae facere voluptate tempore repudiandae consequatur.','Sequi at repellat corporis doloribus. Excepturi est deleniti atque delectus voluptate repellat non. Soluta doloremque ipsam aut eveniet vel.\n\nRerum ut corrupti voluptas voluptas impedit amet quia. Saepe repudiandae rerum et eveniet eaque qui. Et earum qui consequuntur eaque. Officiis voluptas sed et iusto laboriosam beatae.\n\nIste id suscipit non doloremque. Ipsum nulla eligendi molestiae a facere totam. Aut delectus a atque minima quod. Est ducimus vero omnis.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(7,'Consequatur sed enim.','Eaque qui ducimus aut quidem et. Eaque voluptatem tenetur et et ullam et. Consequatur id autem voluptate natus expedita.\n\nExpedita modi ea quas velit beatae excepturi nulla. Sit quos quia non. Est autem natus corporis vero. Voluptates deleniti tempora ut dolorum eaque atque et fuga. Sint nam et ipsa quia odio.\n\nAnimi minima odio rerum hic nesciunt vel. Corrupti accusantium ea ut eligendi ab dolorem sed. Accusamus dignissimos iure nostrum officia. Et quam eius deserunt harum velit.\n\nRepellat voluptate ut quasi perferendis itaque deserunt deserunt. Illo rem tempora fuga natus quia minus. Sed eos et in eum quo. Unde quia quas sunt sed necessitatibus dignissimos perferendis.\n\nQuaerat quas occaecati enim et animi. Est dolorem accusamus sequi non eveniet aut. Non eos veniam maiores sunt.\n\nSimilique ut ducimus eos inventore qui. Et natus incidunt aut inventore odit quia.\n\nLabore ut quo pariatur ad sapiente accusantium tenetur. Rerum voluptas consectetur ducimus aliquid similique voluptatem voluptate. Sint est aliquam minima doloremque. Maiores aperiam quos eos.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(8,'Dolor eum autem.','Quibusdam tenetur autem delectus. Quasi ullam eaque officia incidunt. Eaque suscipit labore ea nemo quasi. Velit ab incidunt et maiores hic.\n\nIllum assumenda nihil quo deleniti. Non maxime doloribus consequatur autem quo. Qui perspiciatis aut autem.\n\nEa sit quia ducimus enim eveniet. Magnam culpa et dignissimos est porro odio odit. Beatae nobis velit molestias molestias laboriosam in aut.\n\nVoluptatem at repudiandae deleniti molestiae perspiciatis ad. Sit cupiditate repudiandae et modi provident atque. Nam est qui qui ullam consequatur numquam.\n\nVelit tempore a sit hic. Nihil harum excepturi veniam enim. Fugiat et quisquam vel hic.\n\nUt necessitatibus adipisci reprehenderit neque quas nesciunt provident. At accusantium dolores magni odio quos. Laboriosam delectus autem ea qui. Eligendi rerum voluptatem temporibus.\n\nTempora error non quibusdam voluptas rem. Vitae atque sed velit voluptas optio. Vero inventore iste temporibus expedita qui. Quis aut reprehenderit at impedit quis molestiae.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(9,'Maxime quidem repudiandae consequatur hic laborum inventore cum et.','Ea ut aperiam tenetur qui commodi veritatis. Quibusdam ratione quia nostrum tenetur atque. Et beatae et modi est omnis sed similique rerum. Quia sapiente quos necessitatibus non libero quisquam sunt ad.\n\nPossimus in labore ex et porro. Est hic ea adipisci voluptatum autem recusandae. Ducimus qui voluptas dolores voluptatum asperiores et. Hic et facilis iste rem sit.\n\nEst nobis sed fugit temporibus deleniti. Vitae excepturi eius reiciendis animi.\n\nUt placeat ullam veniam. Ut quibusdam dicta iste nihil iste et. Velit quisquam dolor officia tempore beatae non. Voluptatem et optio libero.\n\nSed molestiae natus labore dignissimos occaecati. Eaque earum enim molestiae sint.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(11,'Repellat autem amet magnam soluta nobis sequi.','Nemo dolor sunt architecto odio aut veritatis vel. Ex sint quae fuga rerum officiis sit quia. Ducimus id necessitatibus est explicabo non et in illo. Optio enim doloremque perferendis ullam unde rem est quam.\n\nVoluptates ut itaque doloribus molestias animi modi. Consectetur dolore unde et et illum. Quis doloribus ea atque dolores magnam laudantium excepturi.\n\nIure accusamus non consequatur vero doloribus tenetur non. Earum tempora perspiciatis ratione maiores. Maiores quasi qui dolorem consequuntur dicta labore ipsam. Et esse et qui adipisci. In velit commodi suscipit ad ut modi natus.\n\nDoloremque recusandae nam qui possimus non inventore. Molestiae placeat odit officiis. Porro non quis aliquam quia nihil provident repellendus. Tenetur ut doloremque doloremque.\n\nSuscipit quam voluptate ut sequi doloribus eveniet est. Vitae rerum ea voluptas enim. Exercitationem velit ut et ex deserunt. Aliquam odit et id neque. Consequatur sapiente laudantium sit placeat ad.\n\nVoluptate repellendus saepe qui et vero omnis ut. Voluptas mollitia incidunt eum maiores. Nesciunt earum vel voluptatum distinctio nam officiis corrupti natus. Totam sequi laboriosam blanditiis mollitia.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(12,'Placeat incidunt autem in.','Ut et ut ipsam voluptas voluptatum rerum. Sunt vel eum assumenda molestias corrupti atque. Laudantium consequatur vel veniam expedita voluptatem voluptatem. Necessitatibus nesciunt ea nulla odio officiis.\n\nQuis est voluptatem placeat aliquid aut. Deleniti explicabo dolorum fugit unde. Est atque quo accusamus enim ut dolor qui.\n\nSunt quos non labore sed debitis mollitia. Aspernatur perspiciatis debitis consequatur. Vero et facilis ut.\n\nAdipisci amet consequatur doloremque voluptatum. Eligendi eveniet eum officiis quibusdam et et. Sed aut voluptatum qui hic. Ea velit consequatur quo in nobis odit delectus.\n\nIpsa dolore tempore dolores est sint. In voluptatibus et voluptatibus. Facilis id voluptas officiis nam ut temporibus totam. Qui dicta consequatur architecto eius.\n\nQui nisi rerum adipisci ut. Odit et qui quas quibusdam. Et consequuntur soluta sint quia. Est quibusdam voluptatem autem vero vero eveniet ipsum atque. Est facere eum tempore repellendus rerum animi sed.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(13,'Sit maiores sed qui.','Voluptas doloremque maxime magnam possimus ea possimus ut. Voluptas nihil et necessitatibus facere. Alias vel accusantium rerum perspiciatis. Voluptatem non et eos.\n\nCulpa et aut voluptatem adipisci unde qui. Nesciunt molestiae itaque non veniam porro. Sint quas magnam commodi dicta dolor. Laborum eos laboriosam eligendi culpa perferendis doloremque quae qui.\n\nId deserunt rerum aut accusantium nobis. Eos cupiditate quia est et.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(14,'Soluta sint nobis et facilis.','Enim est aliquid dolorum repellendus sapiente doloribus. Optio fuga quo itaque veritatis assumenda. Non impedit qui laborum quidem sit adipisci. Sunt libero molestiae minima ut.\n\nConsequatur dicta commodi laborum in dolor maxime consequatur autem. Blanditiis incidunt velit amet qui. Molestiae accusamus non odio dolorem perferendis voluptatum.\n\nQuae neque et cupiditate. Iusto optio vel qui. Culpa quo omnis rerum.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(15,'Quisquam quasi assumenda ad.','Ducimus quis itaque totam sapiente. Qui mollitia pariatur ut sunt libero est. Et qui nam officia rem rerum non adipisci. Molestiae dolore soluta et ut ex quia ullam rerum.\n\nSed sit repellat qui natus ad corrupti. Neque cupiditate nulla quasi veniam maiores. Eos nemo illo similique impedit autem.\n\nAtque aspernatur at est pariatur quia eaque minus. Quam in et facere. Quaerat commodi sit ratione et eius.\n\nNumquam ut magnam sunt aut. Eos in nihil quia sunt. Inventore sit expedita velit libero saepe ea.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(16,'Eos molestiae in omnis et.','Placeat aut voluptatum omnis vitae. Perferendis aperiam distinctio cum.\n\nCorporis rerum quam voluptatibus labore ipsam ad et quos. Delectus eos nemo earum dolore aut est. Veniam illo similique ut necessitatibus.\n\nQuam libero qui quos molestiae. Accusantium tempore qui sed molestiae. Dicta facilis suscipit magnam pariatur eius accusantium.\n\nEaque rerum aliquam unde voluptates dolorem quia officiis et. Sed ab doloremque eum incidunt. Eos veritatis laborum nisi ut sed itaque aspernatur. Excepturi saepe quia id. Corporis ut qui dolore sint est voluptas quas.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(17,'Eveniet qui omnis illum.','Reiciendis adipisci ut voluptatem ut adipisci. Voluptates veniam molestias quae excepturi est architecto. Ab dolorem sapiente aliquid. Qui eum delectus enim beatae.\n\nOfficiis ut dolorem ullam rerum omnis voluptas quidem. Corporis dolorum quia magnam dignissimos inventore hic cumque. In quaerat voluptate dolor dolorem rerum.\n\nMolestiae enim velit vel qui vero sunt qui. Laboriosam consectetur similique saepe quasi. Nam excepturi voluptas ipsum ut inventore. Tenetur aut nobis consequatur fuga maiores.\n\nRepellendus voluptas ut et explicabo commodi voluptates. Nostrum molestiae incidunt voluptatem architecto enim. Saepe itaque doloremque itaque. Dolores cupiditate dolores et qui veritatis eum.\n\nHic aut quibusdam nihil rerum impedit aspernatur iure dolores. Id at aut assumenda omnis totam voluptatum consequuntur qui. Consequuntur in et hic delectus dolore delectus sed. Ut rerum commodi ducimus id.\n\nDolor dolores non et et ex. Voluptatem maiores saepe eveniet qui. Iure possimus et quo fugiat earum officia doloremque.\n\nSint non fugiat velit sint voluptate dolores pariatur eos. Et pariatur commodi dicta ut sed optio commodi. Fugit eum quibusdam et mollitia nulla. Sit qui aut fugit ad.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(18,'Sunt voluptatum quia sequi quis.','Optio sapiente qui sequi est totam. Voluptatem et enim ullam in ut. Veniam sint voluptatem eaque omnis. Totam numquam est dolorem nobis animi mollitia id.\n\nDucimus doloribus provident eos incidunt similique. Dolores deleniti voluptate et corrupti temporibus porro. Quo beatae ea eligendi ut reprehenderit sed aspernatur. Qui dignissimos illum dolores laborum.\n\nFacilis hic ullam et aut facilis. Quod sed rerum fugiat aliquam saepe quia eveniet.\n\nEos voluptatem earum omnis sunt et ut quos dolores. Cum dolorem magni illo delectus. Iusto blanditiis aut inventore blanditiis voluptate. Pariatur non odio asperiores non.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(19,'Nostrum nisi non beatae sed.','Nihil recusandae quo repellendus dolores odit. Consequatur sunt autem voluptatum. Eaque omnis eum saepe. Et ea est recusandae est aperiam repudiandae et. Corporis voluptatem non et est aut.\n\nRepudiandae enim repudiandae eum repudiandae sed magni. Perspiciatis ea molestiae dolore. Voluptas aperiam commodi voluptatum vitae porro rerum.\n\nCorrupti sit in delectus reiciendis dicta. Voluptates consequatur asperiores ab commodi aut aut. Fuga dolore aspernatur consequatur rerum aut quia.\n\nNisi neque numquam reprehenderit et. Est impedit excepturi iure vel est nemo quod. Possimus velit qui molestiae quo perferendis. Et perspiciatis dolorem veniam asperiores voluptas nostrum quia nam.\n\nVel consequuntur cumque ut asperiores aliquid. Inventore exercitationem quasi qui. Quis ex et doloribus. Eveniet dolor voluptatem sit eos ea.\n\nAut sit enim sunt voluptatem sed animi. Velit nihil et corrupti repellat minus. Perferendis nisi enim neque illo eaque recusandae quidem.\n\nMaxime expedita nostrum unde. Eligendi qui impedit sed dolorem corporis. Pariatur qui sit sit rem ratione molestias. Odio eum maxime ducimus adipisci est maxime.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(20,'Molestiae ratione aspernatur qui quia unde.','In quis vel fugit debitis consequatur distinctio laboriosam soluta. Cum in omnis maiores est. Et qui ratione deserunt placeat. Ut sunt sint et aspernatur molestiae.\n\nAperiam officiis qui ab temporibus quia. Possimus delectus et velit eum. Ipsam aut rerum numquam neque.\n\nAlias nihil qui animi id vel dolor. Nemo officia optio similique consequatur. Eveniet laboriosam ut voluptates fuga a.\n\nExcepturi molestiae pariatur dolorum et et eum ex. Labore ut aut tenetur velit explicabo porro quo. Quo accusamus vero tempora nihil excepturi fugit fugit ab. Voluptatum voluptatibus consequatur qui cupiditate libero.\n\nEnim eveniet qui quia id vero odit. Aliquid voluptatem qui omnis dolor nemo repellat. Expedita at eos similique non rerum. Cum minima eos eveniet a.\n\nCorporis quis consequatur voluptatum voluptates tempore voluptatibus aut. Quasi nobis perspiciatis magni velit aut. Cupiditate vel et nam et.','2025-04-23 19:39:29','2025-04-23 19:39:29'),
	(21,'test','test1','2025-04-24 15:18:56','2025-04-24 15:18:56');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table priorities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `priorities`;

CREATE TABLE `priorities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `priorities` WRITE;
/*!40000 ALTER TABLE `priorities` DISABLE KEYS */;

INSERT INTO `priorities` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'Low',NULL,NULL),
	(2,'Medium',NULL,NULL),
	(3,'High',NULL,NULL);

/*!40000 ALTER TABLE `priorities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table priorities_tables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `priorities_tables`;

CREATE TABLE `priorities_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table question_survey
# ------------------------------------------------------------

DROP TABLE IF EXISTS `question_survey`;

CREATE TABLE `question_survey` (
  `survey_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `question_survey_survey_id_foreign` (`survey_id`),
  KEY `question_survey_question_id_foreign` (`question_id`),
  CONSTRAINT `question_survey_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_survey_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `question_survey` WRITE;
/*!40000 ALTER TABLE `question_survey` DISABLE KEYS */;

INSERT INTO `question_survey` (`survey_id`, `question_id`, `created_at`, `updated_at`)
VALUES
	(1,8,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(1,10,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(1,2,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(1,5,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,4,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,8,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,5,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,2,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,1,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,7,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,3,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,5,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,2,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,1,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,10,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,8,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,10,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,3,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,4,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,1,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,6,'2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(8,11,'2025-04-24 15:43:49','2025-04-24 15:43:49'),
	(8,12,'2025-04-24 15:43:49','2025-04-24 15:43:49');

/*!40000 ALTER TABLE `question_survey` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `question`, `type`, `created_at`, `updated_at`)
VALUES
	(1,'How satisfied are you with your job?','scala','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,'What motivates you at work?','liber','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,'Rate your manager’s communication skills.','scala','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,'Describe your biggest challenge at work.','liber','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(5,'Do you feel your work is appreciated?','scala','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(6,'What would you change about your current role?','liber','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(7,'Rate the team collaboration in your department.','scala','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(8,'Share one suggestion for company culture improvement.','liber','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(9,'How often do you receive feedback?','scala','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(10,'What training would benefit you most?','liber','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(11,'dasd','text','2025-04-24 15:43:49','2025-04-24 15:43:49'),
	(12,'dasdasasd','scala','2025-04-24 15:43:49','2025-04-24 15:43:49');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `role_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;

INSERT INTO `role_user` (`role_id`, `user_id`)
VALUES
	(1,1),
	(1,3),
	(1,4),
	(1,5),
	(1,6),
	(1,7),
	(1,8),
	(1,9),
	(1,10),
	(2,11),
	(3,13),
	(1,17),
	(1,18);

/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `name`)
VALUES
	(1,'user'),
	(2,'admin'),
	(3,'hr');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`)
VALUES
	('MruemaZcauTXofsovN9yCAmQ9SHdFHPVvqd0vLGx',11,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVDhKT0dZZEhQNXAwSm5GelJjOUwxVUhSeUlmWWxKUWJ2dmFSeFlKTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS10YXNrcz9wYWdlPTEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMTt9',1749066103);

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table submissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `submissions`;

CREATE TABLE `submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `survey_id` bigint unsigned NOT NULL,
  `submitted_at` date NOT NULL,
  `answers` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submissions_user_id_foreign` (`user_id`),
  KEY `submissions_survey_id_foreign` (`survey_id`),
  CONSTRAINT `submissions_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE,
  CONSTRAINT `submissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `submissions` WRITE;
/*!40000 ALTER TABLE `submissions` DISABLE KEYS */;

INSERT INTO `submissions` (`id`, `user_id`, `survey_id`, `submitted_at`, `answers`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'2025-04-23','{\"2\": \"das\", \"5\": \"3\", \"8\": \"sada\", \"10\": \"dasd\"}','2025-04-23 19:19:38','2025-04-23 19:19:38'),
	(2,1,2,'2025-04-24','{\"1\": \"2\", \"2\": \"das\", \"3\": \"5\", \"4\": \"dasd\", \"5\": \"3\", \"7\": \"4\", \"8\": \"dasdasd\"}','2025-04-24 13:14:40','2025-04-24 13:14:40');

/*!40000 ALTER TABLE `submissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table survey_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `survey_user`;

CREATE TABLE `survey_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_user_survey_id_foreign` (`survey_id`),
  KEY `survey_user_user_id_foreign` (`user_id`),
  CONSTRAINT `survey_user_survey_id_foreign` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE,
  CONSTRAINT `survey_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `survey_user` WRITE;
/*!40000 ALTER TABLE `survey_user` DISABLE KEYS */;

INSERT INTO `survey_user` (`id`, `survey_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,NULL,NULL),
	(2,2,1,NULL,NULL),
	(3,3,1,NULL,NULL),
	(4,2,11,'2025-04-24 16:23:56','2025-04-24 16:23:56'),
	(5,2,13,'2025-04-24 16:24:08','2025-04-24 16:24:08');

/*!40000 ALTER TABLE `survey_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table surveys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `surveys`;

CREATE TABLE `surveys` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;

INSERT INTO `surveys` (`id`, `title`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'Employee Engagement Survey','Help us by completing the \'Employee Engagement Survey\'. Your feedback is valuable!','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(2,'Team Collaboration Feedback','Help us by completing the \'Team Collaboration Feedback\'. Your feedback is valuable!','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(3,'Workplace Environment Review','Help us by completing the \'Workplace Environment Review\'. Your feedback is valuable!','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(4,'Training Needs Assessment','Help us by completing the \'Training Needs Assessment\'. Your feedback is valuable!','2025-04-23 18:58:07','2025-04-23 18:58:07'),
	(8,'asds','asdasd','2025-04-24 15:43:49','2025-04-24 15:43:49');

/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_user`;

CREATE TABLE `task_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `task_id` bigint unsigned NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_user_user_id_foreign` (`user_id`),
  KEY `task_user_task_id_foreign` (`task_id`),
  CONSTRAINT `task_user_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `task_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `task_user` WRITE;
/*!40000 ALTER TABLE `task_user` DISABLE KEYS */;

INSERT INTO `task_user` (`id`, `user_id`, `task_id`, `completed_at`, `created_at`, `updated_at`)
VALUES
	(1,18,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(2,10,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(3,7,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(4,4,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(5,1,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(6,3,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(8,9,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(9,8,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(10,17,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(11,10,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(12,18,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(13,9,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(14,5,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(15,1,2,'2025-04-23 16:17:29','2025-04-23 13:49:17','2025-04-23 16:17:29'),
	(16,13,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(17,7,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(18,5,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(19,13,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(20,4,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(21,8,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(22,18,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(23,10,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(24,7,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(25,10,4,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(26,1,4,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(27,8,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(28,9,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(30,1,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(32,7,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(33,4,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(34,18,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(35,13,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(36,17,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(37,10,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(38,10,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(39,7,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(40,17,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(41,3,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(42,4,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(43,18,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(44,9,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(45,8,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(46,1,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(48,6,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(49,17,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(50,7,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(51,13,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(52,10,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(53,5,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(54,13,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(55,18,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(57,9,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(59,6,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(60,17,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(61,7,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(62,3,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(63,10,8,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(65,1,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(67,10,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(68,9,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(69,18,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(70,5,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(71,7,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(72,8,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(73,6,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(74,8,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(75,10,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(76,1,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(77,3,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(78,17,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(80,18,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(81,6,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(82,4,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(83,8,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(84,10,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(85,7,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(86,9,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(87,1,11,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(89,8,12,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(90,9,12,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(91,10,12,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(92,13,12,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(94,5,12,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(95,9,13,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(97,17,14,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(98,8,14,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(99,18,14,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(100,13,14,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(101,7,14,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(102,5,15,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(103,9,15,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(104,18,15,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(106,7,16,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(107,10,16,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(108,17,16,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(109,4,16,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(110,8,16,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(111,4,17,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(112,13,17,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(114,5,17,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(115,11,17,'2025-04-23 16:10:55','2025-04-23 13:49:17','2025-04-23 16:10:55'),
	(116,18,17,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(117,3,17,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(118,6,18,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(119,9,18,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(120,5,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(121,10,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(122,4,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(123,9,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(124,11,19,'2025-04-23 16:20:42','2025-04-23 13:49:17','2025-04-23 16:20:42'),
	(125,13,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(126,17,19,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(127,11,20,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(128,13,20,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(129,5,20,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17');

/*!40000 ALTER TABLE `task_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `priority_id` bigint unsigned NOT NULL,
  `points` int NOT NULL,
  `completed_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_priority_id_foreign` (`priority_id`),
  CONSTRAINT `tasks_priority_id_foreign` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`id`, `title`, `description`, `due_date`, `priority_id`, `points`, `completed_at`, `created_at`, `updated_at`)
VALUES
	(1,'Placeat est consequuntur sed molestiae nostrum nisi consequuntur.','Dolorem ad accusamus quae reprehenderit voluptas veniam. Aliquam animi veritatis perspiciatis ut voluptas facilis. Qui sint molestiae molestias similique fugit quia.','2025-05-17',1,10,NULL,'2025-04-23 13:49:17','2025-04-23 23:34:25'),
	(2,'Expedita deleniti et earum nobis dolorem.','Nam aut eius voluptatum cum ea modi rerum. Accusamus nihil explicabo quidem quaerat est magnam optio.','2025-05-12',3,10,NULL,'2025-04-23 13:49:17','2025-04-23 23:34:13'),
	(3,'Ut suscipit voluptatem vel voluptatum.','Non excepturi harum et quia necessitatibus. Dicta fuga doloribus autem quam mollitia illum qui. Ipsam est rerum consequatur facere quos provident vel. Dolorem ut voluptas eum debitis alias atque adipisci.','2025-04-30',2,4,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(4,'Beatae quia et reprehenderit aliquid.','Accusamus eveniet ea optio est error. Qui et est pariatur doloribus qui possimus at dolorum.','2025-05-01',3,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(5,'Quae soluta labore nostrum dolores illum architecto.','Ducimus rerum repellendus officia tempora qui ex iure. Magnam nam maxime consequuntur et et sequi. Dignissimos et voluptate est adipisci praesentium nisi.','2025-05-20',1,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(6,'Occaecati possimus omnis mollitia quis est.','Quisquam aut debitis eligendi facilis quisquam rerum eius. Dolorem quam tempore et ducimus minus qui. Et qui ullam provident dolores quas laborum quia cumque.','2025-05-19',1,9,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(7,'Voluptatem quia sint libero deserunt quis dolorem.','Nobis non magnam placeat expedita vel. Sed magni maxime magnam dignissimos nisi sit aliquam. Quam fuga sapiente culpa dolores quidem id. Aut culpa ducimus dicta quo ab vel quam. Ut aut accusamus aperiam quisquam blanditiis maiores.','2025-04-26',3,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(8,'Doloribus esse ad libero itaque.','Cum vitae fugit aut aut aut earum. Eum quo sapiente voluptate ullam voluptas. Et et minima atque eum iusto provident quia.','2025-05-17',3,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(9,'Quos velit a similique aut.','Labore esse qui nobis. Repellat voluptatem harum est. Error ut consequatur tenetur ea deserunt et et.','2025-05-20',3,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(10,'Ullam impedit quibusdam laboriosam odio adipisci.','Pariatur eligendi molestias veniam vel quod debitis. Aut molestiae minus qui asperiores et harum nostrum sint. Laborum commodi non autem velit. Error non omnis quia quia molestias ad omnis. Veniam voluptatem labore sit quo repellendus.','2025-05-17',3,1,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(11,'Consequatur iusto quia quibusdam iure quisquam perferendis deserunt.','Harum autem tempore hic nesciunt iusto molestias. Rerum quisquam possimus esse a pariatur fugiat nihil aut. Ea deserunt aperiam culpa ut voluptate. Similique repellendus deserunt dignissimos perspiciatis corrupti quisquam in neque.','2025-05-13',2,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(12,'Nobis eligendi voluptatem est.','In occaecati sit eos autem commodi. Incidunt magni iure amet quasi. Nihil cum quam dolor.','2025-04-25',3,4,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(13,'Adipisci eveniet ipsum praesentium.','Saepe unde minus nesciunt occaecati possimus officia. Atque maxime neque inventore aut odio sunt. Officia esse et eos quisquam ipsum eligendi.','2025-04-26',3,4,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(14,'Harum eos eius sequi.','Distinctio ducimus qui asperiores eum. Molestiae praesentium repellat dolor unde id tempora magni esse. Exercitationem nihil atque facere sapiente rerum non. Dolores earum quia dolorem eaque odio.','2025-05-13',3,5,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(15,'Consectetur voluptatibus eum odit amet quia necessitatibus voluptatem fugit.','Ab qui nemo veniam deserunt. Distinctio beatae soluta sint ullam hic totam. Ipsam laboriosam voluptas nemo ad aut porro illum dolor.','2025-04-26',2,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(16,'Est quis minus dolor dolor sit quasi.','Voluptatibus doloremque accusamus odio quam. Voluptatem non provident facilis distinctio autem sunt. Eum velit repudiandae ea. Quos magni eligendi unde harum. Iste maxime quis sed asperiores alias.','2025-04-30',2,6,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(17,'Maiores vel repudiandae dicta.','Eveniet excepturi dolore rem praesentium animi omnis qui. Voluptatem atque dolorem consequatur iure pariatur dignissimos. Maxime est autem dolorem odio. Ipsa libero magni adipisci culpa.','2025-05-18',3,3,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(18,'Cumque ut aut animi inventore quia id.','Sit culpa maxime commodi et. Sapiente fuga tempora nihil et amet beatae autem autem. Consequuntur provident ipsa aut in laborum. Dolorem architecto vel aut sit voluptatum porro.','2025-05-11',2,2,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(19,'Nihil eaque consequuntur et est recusandae non.','Voluptas iure non vel alias vel voluptatem. Atque a adipisci aut quas eum sit. Minima delectus beatae assumenda.','2025-04-27',2,10,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(20,'Consequatur sit id et quidem consequatur cum.','At provident eos provident ut. Illo dignissimos qui voluptas quo. Pariatur suscipit modi ratione.','2025-05-17',1,7,NULL,'2025-04-23 13:49:17','2025-04-23 13:49:17'),
	(21,'Lorem ipsum dolor sit amet.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dui lectus, pellentesque faucibus urna ut, elementum venenatis sapien. Quisque aliquam ac erat nec pharetra. In vel nibh vehicula turpis pharetra viverra vitae sed ex. Curabitur diam dui, fringilla vel eleifend vitae, pulvinar tincidunt quam. Curabitur nisi mauris, venenatis ac nisi in, sollicitudin molestie nunc. Etiam eget arcu pretium velit feugiat vehicula. Vestibulum viverra id orci quis tempus. Nunc quis arcu quis justo ullamcorper tempor. Sed pulvinar sem ac arcu scelerisque, eget maximus tellus porta. Vestibulum non diam turpis. Integer laoreet pellentesque ligula id rutrum.','2025-06-11',3,50,NULL,'2025-04-23 22:44:41','2025-04-23 22:44:41');

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` int DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `previous_jobs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `skills` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `education` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `phone`, `email`, `email_verified_at`, `password`, `salary`, `address`, `previous_jobs`, `skills`, `education`, `created_at`, `updated_at`)
VALUES
	(1,'Makenzie','Hamill','marielle.hauck','+15156253534','donnelly.yazmin@example.net','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',7567,'5874 Sid Run\nGaylestad, ID 28148-4184','Debitis facere est laborum in iusto ipsa esse. In qui voluptas magni mollitia. Eius non ut dolorem enim id molestiae. Aspernatur porro eum eligendi sunt sed deleniti.','Repudiandae nihil qui in possimus voluptatem saepe sunt. Rem sequi saepe voluptatibus. Id incidunt odit libero vel ab eos.','Excepturi culpa voluptatum repudiandae veritatis consequatur unde. Quod deleniti ut aut quidem. Nemo ducimus sit sit quae. A omnis doloremque modi in pariatur sed ullam qui.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(3,'Darrick','Halvorson','audrey.stamm','+19296517719','jessie17@example.com','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',6896,'4549 Steuber Highway\nBashirianstad, ME 21448','Necessitatibus et magni cum rerum assumenda laudantium. Vitae totam similique quo. Quasi dignissimos aspernatur asperiores cumque. Ea eum harum reprehenderit sunt et.','Autem consequuntur ab voluptas et id qui sed. Consequuntur molestiae explicabo magni natus. Quia aliquid quas qui totam eos consequuntur.','Quas numquam sit animi. Nesciunt reiciendis occaecati sed quia. Ipsa quia fugit hic sint eveniet. Rerum mollitia et et suscipit.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(4,'Leone','Nolan','jaqueline.runolfsdottir','364.885.5108','zackary.cruickshank@example.net','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',7573,'437 Ona Spurs Suite 892\nLuluburgh, ID 03109','Eos in qui sint sapiente. Magni nobis nihil ducimus error. Esse debitis non facere sunt.','Quisquam autem eligendi est voluptas sed ea. Ab enim iusto sint praesentium fuga magnam excepturi. Aut reprehenderit ad nemo amet.','Quis saepe voluptatem iusto accusamus et. Et praesentium ipsum hic odit doloribus iure. Voluptatem quibusdam ullam cupiditate dolor excepturi autem.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(5,'Sammy','Gulgowski','collin15','(678) 361-8407','adriana47@example.org','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',8862,'334 Powlowski Spring\nLednerland, CA 40865','Sunt eius ducimus quia sint aut. Voluptatem voluptatem veniam expedita quam autem fugit. Ab excepturi quisquam debitis numquam autem qui et.','Qui corporis consectetur ullam ea voluptatem eligendi repudiandae. Sit adipisci non repellat dignissimos. Laborum dolorum quos aut dolor velit iure tempora.','Repudiandae iste perspiciatis quo eos est ab. Occaecati nulla veniam id eveniet possimus eos atque recusandae. Omnis illo ducimus earum odio facilis accusamus et.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(6,'Fernando','Jacobi','hobart.cremin','+1 (430) 766-5354','block.lavonne@example.com','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',1227,'858 Deja Ports\nOkunevaside, AK 94065-7719','Corrupti ipsum repudiandae et voluptate nam non. Non sapiente a libero. Harum fugiat hic enim consequatur cum aut quisquam.','Veritatis rem tenetur quos quis enim similique. Est et ea officiis eum. Magni sed est hic.','Commodi corporis fugiat quis officiis porro. Pariatur nulla sunt iure non repellat laborum sit ut.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(7,'Sienna','Schowalter','vida.streich','(228) 209-6614','heller.kiara@example.org','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',7950,'9366 Jenkins Ford Suite 361\nFritschfurt, DC 19470-5604','Ut vero iure quos quidem non. Dolores omnis ducimus est esse quas. Ipsa recusandae consectetur veritatis consequatur atque doloremque voluptatibus.','Veritatis ratione recusandae cumque fugiat. Repellat culpa perspiciatis nostrum ea fuga. Non architecto debitis minima quis tempore deleniti.','Quia nam voluptate ducimus. Et voluptatem amet cumque numquam. Dicta quos id sit. Doloremque tempore aut a est. Tenetur consequatur autem ratione tempore reiciendis quidem.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(8,'Keon','Russel','ola63','1-339-699-2924','donavon.lindgren@example.net','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',2315,'1059 Mallie Fords Suite 974\nLake Isaiahview, OH 43177-9606','Soluta earum reprehenderit architecto maiores consequuntur magni aliquam. Dolores sit et omnis molestiae officiis non ea. Corrupti non rerum saepe.','Quis temporibus commodi autem qui deleniti aut consequatur amet. Deleniti doloribus et repudiandae dolores qui et. Consequuntur velit et rem consequuntur voluptas totam minima.','Qui nobis ea assumenda voluptatem aliquam laborum. Fugiat delectus eaque adipisci. Placeat repellendus tenetur qui deserunt sint est sint.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(9,'Korey','Champlin','bogisich.jackeline','+1 (848) 339-7419','marvin.agustina@example.org','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',2664,'907 Kolby Junction\nEast Kennethbury, CO 59404-2488','Perferendis perspiciatis est enim modi officiis non consequuntur. Omnis impedit est qui dignissimos voluptatem nobis.','Eum doloribus ipsum voluptatem assumenda rem ipsum sed. Omnis natus sint voluptatum occaecati. Dolore temporibus voluptate at necessitatibus.','Accusantium corrupti eum expedita consectetur exercitationem. Tempora ut rem commodi in culpa sint consequatur. Voluptatem recusandae molestiae earum optio et et atque.','2025-03-20 10:03:59','2025-03-20 10:03:59'),
	(10,'Katelynn','Adams','yvette12','+1 (517) 478-9724','reanna93@example.com','2025-03-20 10:03:59','$2y$12$fu9K.gMfcASE7qqBRpwpPegB96hU9T.jTUjoc5I7Sd0e2oiw/dcHK',3936,'4242 Americo Rapid\r\nNorth Rosendo, MA 08824','Eum laboriosam qui iusto eligendi. Omnis dolor sunt nihil vero repudiandae expedita commodi eos. Sit vitae consequuntur ut veniam in. Animi non nam quas beatae totam laborum.','Aliquid fuga adipisci itaque velit laboriosam sit cum fuga. Eum qui quibusdam quia et est. Eaque dolorum cupiditate eum.','Vero exercitationem et sint. Vel fugit odio consequatur sit reprehenderit fugit. Iure id sit repudiandae.','2025-03-20 10:03:59','2025-04-24 14:40:46'),
	(11,'Petre','Mihai','petremihai','0712345678','petre@admin.com',NULL,'$2y$12$HsOPORGn0NI1ywlfJw4NEeHg5Hp1lR3apEFn.jBlBVQVKRmtkdbFq',NULL,NULL,NULL,NULL,NULL,'2025-03-20 10:12:29','2025-04-25 17:18:16'),
	(13,'Petre','Mihai','petremihaihr','0712345679','petre@hr.com',NULL,'$2y$12$rFhOk0Z16SngFTbbKOhLeeu2932TphkvJONvRVdiKHBjD8JQxg7Ce',NULL,NULL,NULL,NULL,NULL,'2025-03-20 13:05:06','2025-04-25 17:19:01'),
	(17,'user','user','user@user','0712345690','user@user.com',NULL,'$2y$12$z3WqltHOvrQ0H.MM7J3Jz.3eIYCbpV0.GH5gOfXWxEjQ8XHQRCg/i',NULL,NULL,NULL,NULL,NULL,'2025-03-27 18:51:11','2025-03-27 18:51:11'),
	(18,'user1','user1','user1','0791231231','user1@user.com',NULL,'$2y$12$yYWgCrBKqYkZ3tIc6BSR4eVTFnvqjtOuPXUIcNArdhP6jQts.yNL2',NULL,NULL,NULL,NULL,NULL,'2025-03-31 15:56:28','2025-03-31 15:56:28');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
