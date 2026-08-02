-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2026 at 02:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `example_herbcareapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patientId` bigint(20) UNSIGNED NOT NULL,
  `practitionerId` bigint(20) UNSIGNED DEFAULT NULL,
  `message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `conditionId` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `condition_herbs`
--

CREATE TABLE `condition_herbs` (
  `conditionHerbId` bigint(20) UNSIGNED NOT NULL,
  `conditionId` bigint(20) UNSIGNED NOT NULL,
  `herbId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `condition_symptoms`
--

CREATE TABLE `condition_symptoms` (
  `conditionSymptomId` bigint(20) UNSIGNED NOT NULL,
  `conditionId` bigint(20) UNSIGNED NOT NULL,
  `symptomId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_categories`
--

CREATE TABLE `health_categories` (
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `health_categories`
--

INSERT INTO `health_categories` (`categoryId`, `categoryName`, `created_at`, `updated_at`) VALUES
(1, 'Immune system health', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(2, 'Respiratory health', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(3, 'Stress/anxiety health', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(4, 'Digestive health', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(5, 'Menstrual/productive health', '2026-05-12 20:34:05', '2026-05-12 20:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `herbs`
--

CREATE TABLE `herbs` (
  `herbId` bigint(20) UNSIGNED NOT NULL,
  `herbName` varchar(255) NOT NULL,
  `scientificName` varchar(255) NOT NULL,
  `benefits` text NOT NULL,
  `preparation` text NOT NULL,
  `safety` text NOT NULL,
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `herbs`
--

INSERT INTO `herbs` (`herbId`, `herbName`, `scientificName`, `benefits`, `preparation`, `safety`, `categoryId`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Jujube Seed (Suan Zao Ren)', 'Ziziphus jujuba var. spinosa', 'Nourishes the heart blood and calms the Mind (Shen). Primary herb for insomnia due to deficiency.', 'Decoct 9-15g or take as ground powder before bed.', 'Avoid if there is severe phlegm-heat or diarrhea.', 1, 'images/herb2.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(2, 'Pinellia (Ban Xia)', 'Pinellia ternata', 'TCM journal standard for resolving phlegm and stopping nausea. Harmonizes the stomach.', 'Must use processed form (Zhi Ban Xia). Simmer for 15-20 mins.', 'Contraindicated during pregnancy (consult MD). Irritant if unprocessed.', 4, 'images/herb1.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(3, 'Bupleurum (Chai Hu)', 'Bupleurum chinense', 'Regulates Liver Qi and resolves stagnation. Key for irritability and mood swings.', 'Simmer dried root in a formula. Do not overcook as volatile oils may escape.', 'Use caution with Yin deficiency or high blood pressure.', 3, 'images/herb16.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(4, 'Fresh Ginger (Sheng Jiang)', 'Zingiber officinale', 'Warms the middle burner and effectively stops vomiting/nausea.', 'Slice 3-5 pieces and steep in hot water or add to soup.', 'Generally safe. Reduce use if suffering from internal heat signs.', 4, 'images/herb4.png', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(5, 'Peppermint (Bo He)', 'Mentha haplocalyx', 'Clears exterior wind-heat. Soothes the throat and clears the eyes.', 'Steep for only 5 minutes at the end of a decoction.', 'Can dry up breast milk. Avoid if breastfeeding.', 2, 'images/herb5.webp', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(6, 'Angelica (Dang Gui)', 'Angelica sinensis', 'The \"Success of Ladies\" herb. Tonifies and invigorates blood, regulating menses.', 'Decoct roots. Often paired with Astragalus.', 'Avoid during early pregnancy or if there is severe diarrhea.', 5, 'images/herb8.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(7, 'Sichuan Lovage (Chuan Xiong)', 'Ligusticum chuanxiong', 'Moves Blood and Qi. Effective for menstrual headaches and pain.', 'Simmer root slices for 30-40 minutes.', 'Avoid if you have heavy menstrual bleeding.', 5, 'images/herb19.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(8, 'Astragalus (Huang Qi)', 'Astragalus membranaceus', 'Tonifies the Spleen and Lungs. Boosts \"Wei Qi\" (Defensive energy).', 'Simmer large slices in soups or tea for 1 hour.', 'Avoid during the acute stage of a common cold or flu.', 4, 'images/herb9.webp', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(9, 'Licorice (Gan Cao)', 'Glycyrrhiza uralensis', 'Harmonizes all herbs in a formula. Moistens the lungs and stops cough.', 'Standard in almost all TCM tea formulas.', 'Avoid long-term pure use if you have hypertension.', 2, 'images/herb10.avif', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(10, 'White Peony (Bai Shao)', 'Paeonia lactiflora', 'Nourishes the Liver and preserves Yin. Stops pain and cramps.', 'Decoct with licorice for muscle/menstrual spasms.', 'Avoid if there is diarrhea due to cold.', 5, 'images/herb13.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(11, 'Honeysuckle (Jin Yin Hua)', 'Lonicera japonica', 'Clears toxic heat. Excellent for inflammatory sore throats.', 'Steep dried flowers for 10-15 minutes.', 'Use with caution if you have a weak/cold stomach.', 2, 'images/herb17.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(12, 'Forsythia (Lian Qiao)', 'Forsythia suspensa', 'Clears heat and resolves lumps. Often used for respiratory infections.', 'Steep or decoct the dried fruit.', 'Generally safe. Avoid if diarrhea is present.', 2, 'images/herb18.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(13, 'Goji Berry (Gou Qi Zi)', 'Lycium barbarum', 'Nourishes Liver and Kidney Yin. Improves sleep and eye health.', 'Eat raw or steep in hot water for a snack/tea.', 'Generally safe for all. Avoid in acute phlegm-heat stages.', 1, 'images/herb11.webp', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(14, 'Poria (Fu Ling)', 'Wolfiporia extensa', 'Promotes urination and leaches out dampness. Calms the mind.', 'Hard sclerotium; decoct for at least 45 minutes.', 'Avoid if there is frequent/profuse pale urination.', 1, 'images/herb10.avif', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(15, 'Hawthorn (Shan Zha)', 'Crataegus pinnatifida', 'Transforms food stagnation (especially meat). Reduces lipids.', 'Boil dried berries into a concentrated tea.', 'Consult practitioner if on heart medication.', 4, 'images/herb14.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(16, 'Chrysanthemum (Ju Hua)', 'Chrysanthemum morifolium', 'Clears the Liver and Brightens Eyes. Calms Liver fire headaches.', 'Steep flowers with Goji berries for a traditional eye tea.', 'Avoid if allergic to ragweed/daisies.', 3, 'images/herb7.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(17, 'Atractylodes (Bai Zhu)', 'Atractylodes macrocephala', 'Dries dampness and strengthens Spleen. Prevents miscarriage due to weakness.', 'Decoct for 30 minutes. Sauté with bran to increase efficiency.', 'Contraindicated with severe Yin deficiency/thirst.', 4, 'images/herb10.avif', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(18, 'Lotus Seed (Lian Zi)', 'Nelumbo nucifera', 'Binds the essence and calms the Shen (Mind). Stabilizes sleep.', 'Soak overnight then cook in sweet soups or congee.', 'Avoid during acute constipation or hard stool.', 1, 'images/herb15.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(19, 'Cyperus (Xiang Fu)', 'Cyperus rotundus', 'The \"Commander\" of Qi. Regulates menses and relieves emotional stress.', 'Decoct the rhizome. Often paired with Chai Hu.', 'Use with caution if there is Heat in the Blood.', 3, 'images/herb12.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(20, 'Perilla Leaf (Su Ye)', 'Perilla frutescens', 'Warms the exterior and resolves seafood poisoning. Calms fetal restlessness.', 'Steep for 10-15 minutes. Very fragrant.', 'Avoid with profuse sweating due to exterior deficiency.', 2, 'images/herb3.jpg', '2026-05-12 20:34:05', '2026-05-12 20:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `herbs_symptoms`
--

CREATE TABLE `herbs_symptoms` (
  `herbSymptomId` bigint(20) UNSIGNED NOT NULL,
  `herbId` bigint(20) UNSIGNED NOT NULL,
  `symptomId` bigint(20) UNSIGNED NOT NULL,
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `herbs_symptoms`
--

INSERT INTO `herbs_symptoms` (`herbSymptomId`, `herbId`, `symptomId`, `categoryId`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(2, 1, 2, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(3, 2, 11, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(4, 2, 10, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(5, 2, 12, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(6, 3, 7, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(7, 3, 8, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(8, 4, 11, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(9, 4, 12, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(10, 5, 5, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(11, 5, 8, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(12, 6, 14, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(13, 6, 13, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(14, 7, 13, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(15, 7, 3, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(16, 8, 10, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(17, 8, 9, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(18, 9, 4, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(19, 10, 13, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(20, 10, 8, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(21, 11, 5, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(22, 11, 6, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(23, 12, 5, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(24, 12, 4, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(25, 12, 6, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(26, 13, 1, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(27, 14, 2, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(28, 14, 10, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(29, 15, 10, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(30, 15, 11, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(31, 16, 8, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(32, 16, 3, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(33, 17, 11, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(34, 17, 10, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(35, 18, 1, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(36, 19, 7, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(37, 19, 14, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(38, 20, 4, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(39, 20, 11, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageId` bigint(20) UNSIGNED NOT NULL,
  `patientId` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','replied','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageId`, `patientId`, `subject`, `message`, `status`, `created_at`, `updated_at`, `reply`, `replied_at`, `is_read`) VALUES
(1, 4, 'consultation herbs', 'if i bloated what herbs suitable for my stomach', 'resolved', '2026-05-12 21:02:07', '2026-05-12 21:38:59', 'Ginger\r\nGood for bloating, nausea, and indigestion.\r\nTry: ginger tea or a few slices in hot water.\r\nPeppermint\r\nMay help relax stomach muscles and reduce gas.\r\nTry: peppermint tea.\r\nAvoid if you often get acid reflux/heartburn, since it can worsen that.', '2026-05-12 21:38:03', 1),
(2, 2, 'consultation herbs', 'i want to make drink tea can u suggest herbal', 'pending', '2026-05-12 21:03:48', '2026-05-12 21:03:48', NULL, NULL, 0),
(3, 3, 'consultation herbs', 'i get red rashes in my body which herb suitable to use', 'replied', '2026-05-12 21:36:53', '2026-05-12 21:37:26', 'Turmeric\r\nHas anti-inflammatory properties; usually taken in food/tea rather than applied directly (it can stain skin).', '2026-05-12 21:37:26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_04_14_200000_create_health_categories_table', 1),
(3, '2026_04_14_200001_create_herbs_table', 1),
(4, '2026_04_14_200002_create_symptoms_table', 1),
(5, '2026_04_14_200003_create_herbs_symptoms_table', 1),
(6, '2026_04_14_200004_create_patient_practitioner_tables', 1),
(7, '2026_04_14_200006_create_recommendations_table', 1),
(8, '2026_04_16_152044_create_conditions_tables', 1),
(9, '2026_04_16_155347_create_messages_table', 1),
(10, '2026_04_21_155929_add_description_to_symptoms_table', 1),
(11, '2026_04_23_142436_make_symptom_id_nullable_in_recommendations', 1),
(12, '2026_04_28_162644_add_reply_to_messages_table', 1),
(13, '2026_04_28_181837_create_appointments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientId` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patientId`, `name`, `email`, `password`, `phone`, `profile_photo`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'RUSYDINA ADRINAZ BINTI RUZIMAN', 'rinazrusy@gmail.com', '$2y$12$/.7.ouV7S35r6q5daHUVpuST2lWFAGyMtKMVyinGNxgxNFB.OOGLS', NULL, NULL, NULL, NULL, '2026-05-12 20:39:35', '2026-05-12 20:39:35'),
(3, 'raisha', 'raisha@gmail.com', '$2y$12$sGUHAmP6Y7wtYgEbjbaH7eQj7877WBAI9yRmxFmLuW8Bxcik8EJti', NULL, NULL, NULL, NULL, '2026-05-12 20:47:42', '2026-05-12 20:47:42'),
(4, 'aisyah', 'aisyah@gmail.com', '$2y$12$IVZWbi1LMdsRM/zqJ5x9TOAYW.9IK3MbP0egcPjF2YvHuRW6lGSli', NULL, NULL, NULL, NULL, '2026-05-12 21:01:23', '2026-05-12 21:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `practitioners`
--

CREATE TABLE `practitioners` (
  `practitionerId` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `practitioners`
--

INSERT INTO `practitioners` (`practitionerId`, `name`, `email`, `password`, `phone`, `profile_photo`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'alya', 'alya@gmail.com', '$2y$12$aoKXDe6O2zTXgELvUSPTGOfRJFVH0BUDsdM0zlk8e2wBL7PWAZl6G', NULL, NULL, NULL, NULL, '2026-05-12 20:40:23', '2026-05-12 20:40:23'),
(3, 'CheeYat', 'cheeyat@gmail.com', '$2y$12$nR2UV3fq3I4bXuPoyDzmsOQU/f2u91/W2L/00jk.HorAal3H68M.q', NULL, NULL, NULL, NULL, '2026-05-12 21:02:40', '2026-05-12 21:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `recommendationId` bigint(20) UNSIGNED NOT NULL,
  `herbName` varchar(255) NOT NULL,
  `patientId` bigint(20) UNSIGNED NOT NULL,
  `symptomId` bigint(20) UNSIGNED DEFAULT NULL,
  `categoryId` bigint(20) UNSIGNED DEFAULT NULL,
  `herbsId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommendationId`, `herbName`, `patientId`, `symptomId`, `categoryId`, `herbsId`, `created_at`, `updated_at`) VALUES
(1, 'Pinellia (Ban Xia)', 4, NULL, 4, 2, '2026-05-12 21:01:37', '2026-05-12 21:01:37'),
(2, 'Jujube Seed (Suan Zao Ren)', 2, 1, 1, 1, '2026-05-12 21:15:13', '2026-05-12 21:15:13'),
(3, 'Goji Berry (Gou Qi Zi)', 2, 1, 1, 13, '2026-05-12 21:15:13', '2026-05-12 21:15:13'),
(4, 'Lotus Seed (Lian Zi)', 2, 1, 1, 18, '2026-05-12 21:15:13', '2026-05-12 21:15:13'),
(5, 'Pinellia (Ban Xia)', 2, NULL, 4, 2, '2026-05-29 04:32:22', '2026-05-29 04:32:22'),
(6, 'Angelica (Dang Gui)', 2, NULL, 5, 6, '2026-05-29 04:32:36', '2026-05-29 04:32:36'),
(7, 'Forsythia (Lian Qiao)', 2, 4, 2, 12, '2026-05-29 04:33:11', '2026-05-29 04:33:11'),
(8, 'Perilla Leaf (Su Ye)', 2, 4, 2, 20, '2026-05-29 04:33:11', '2026-05-29 04:33:11'),
(9, 'Licorice (Gan Cao)', 2, 4, 2, 9, '2026-05-29 04:33:11', '2026-05-29 04:33:11'),
(10, 'Fresh Ginger (Sheng Jiang)', 2, NULL, 4, 4, '2026-05-29 04:33:26', '2026-05-29 04:33:26');

-- --------------------------------------------------------

--
-- Table structure for table `symptoms`
--

CREATE TABLE `symptoms` (
  `symptomId` bigint(20) UNSIGNED NOT NULL,
  `symptomName` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `symptoms`
--

INSERT INTO `symptoms` (`symptomId`, `symptomName`, `description`, `categoryId`, `created_at`, `updated_at`) VALUES
(1, 'Insomnia / Trouble Sleeping', NULL, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(2, 'Mental Restlessness', NULL, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(3, 'Headache', NULL, 1, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(4, 'Persistent Cough', NULL, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(5, 'Sore Throat', NULL, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(6, 'Fever', NULL, 2, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(7, 'Stress & Anxiety', NULL, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(8, 'Irritability', NULL, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(9, 'Chronic Fatigue', NULL, 3, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(10, 'Abdominal Bloating', NULL, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(11, 'Nausea / Morning Sickness', NULL, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(12, 'Vomiting', NULL, 4, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(13, 'Menstrual Cramps', NULL, 5, '2026-05-12 20:34:05', '2026-05-12 20:34:05'),
(14, 'Irregular Cycle', 'haaaa', 5, '2026-05-12 20:34:05', '2026-05-12 20:57:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patientid_foreign` (`patientId`),
  ADD KEY `appointments_practitionerid_foreign` (`practitionerId`),
  ADD KEY `appointments_message_id_foreign` (`message_id`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`conditionId`);

--
-- Indexes for table `condition_herbs`
--
ALTER TABLE `condition_herbs`
  ADD PRIMARY KEY (`conditionHerbId`),
  ADD KEY `condition_herbs_conditionid_foreign` (`conditionId`),
  ADD KEY `condition_herbs_herbid_foreign` (`herbId`);

--
-- Indexes for table `condition_symptoms`
--
ALTER TABLE `condition_symptoms`
  ADD PRIMARY KEY (`conditionSymptomId`),
  ADD KEY `condition_symptoms_conditionid_foreign` (`conditionId`),
  ADD KEY `condition_symptoms_symptomid_foreign` (`symptomId`);

--
-- Indexes for table `health_categories`
--
ALTER TABLE `health_categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `herbs`
--
ALTER TABLE `herbs`
  ADD PRIMARY KEY (`herbId`),
  ADD KEY `herbs_categoryid_foreign` (`categoryId`);

--
-- Indexes for table `herbs_symptoms`
--
ALTER TABLE `herbs_symptoms`
  ADD PRIMARY KEY (`herbSymptomId`),
  ADD KEY `herbs_symptoms_herbid_foreign` (`herbId`),
  ADD KEY `herbs_symptoms_symptomid_foreign` (`symptomId`),
  ADD KEY `herbs_symptoms_categoryid_foreign` (`categoryId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `messages_patientid_foreign` (`patientId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patientId`),
  ADD UNIQUE KEY `patients_email_unique` (`email`);

--
-- Indexes for table `practitioners`
--
ALTER TABLE `practitioners`
  ADD PRIMARY KEY (`practitionerId`),
  ADD UNIQUE KEY `practitioners_email_unique` (`email`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`recommendationId`),
  ADD KEY `recommendations_patientid_foreign` (`patientId`),
  ADD KEY `recommendations_symptomid_foreign` (`symptomId`),
  ADD KEY `recommendations_categoryid_foreign` (`categoryId`),
  ADD KEY `recommendations_herbsid_foreign` (`herbsId`);

--
-- Indexes for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD PRIMARY KEY (`symptomId`),
  ADD KEY `symptoms_categoryid_foreign` (`categoryId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `conditionId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `condition_herbs`
--
ALTER TABLE `condition_herbs`
  MODIFY `conditionHerbId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `condition_symptoms`
--
ALTER TABLE `condition_symptoms`
  MODIFY `conditionSymptomId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_categories`
--
ALTER TABLE `health_categories`
  MODIFY `categoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `herbs`
--
ALTER TABLE `herbs`
  MODIFY `herbId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `herbs_symptoms`
--
ALTER TABLE `herbs_symptoms`
  MODIFY `herbSymptomId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patientId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `practitioners`
--
ALTER TABLE `practitioners`
  MODIFY `practitionerId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `recommendationId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `symptoms`
--
ALTER TABLE `symptoms`
  MODIFY `symptomId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`messageId`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patientid_foreign` FOREIGN KEY (`patientId`) REFERENCES `patients` (`patientId`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_practitionerid_foreign` FOREIGN KEY (`practitionerId`) REFERENCES `practitioners` (`practitionerId`) ON DELETE SET NULL;

--
-- Constraints for table `condition_herbs`
--
ALTER TABLE `condition_herbs`
  ADD CONSTRAINT `condition_herbs_conditionid_foreign` FOREIGN KEY (`conditionId`) REFERENCES `conditions` (`conditionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `condition_herbs_herbid_foreign` FOREIGN KEY (`herbId`) REFERENCES `herbs` (`herbId`) ON DELETE CASCADE;

--
-- Constraints for table `condition_symptoms`
--
ALTER TABLE `condition_symptoms`
  ADD CONSTRAINT `condition_symptoms_conditionid_foreign` FOREIGN KEY (`conditionId`) REFERENCES `conditions` (`conditionId`) ON DELETE CASCADE,
  ADD CONSTRAINT `condition_symptoms_symptomid_foreign` FOREIGN KEY (`symptomId`) REFERENCES `symptoms` (`symptomId`) ON DELETE CASCADE;

--
-- Constraints for table `herbs`
--
ALTER TABLE `herbs`
  ADD CONSTRAINT `herbs_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `health_categories` (`categoryId`) ON DELETE CASCADE;

--
-- Constraints for table `herbs_symptoms`
--
ALTER TABLE `herbs_symptoms`
  ADD CONSTRAINT `herbs_symptoms_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `health_categories` (`categoryId`) ON DELETE CASCADE,
  ADD CONSTRAINT `herbs_symptoms_herbid_foreign` FOREIGN KEY (`herbId`) REFERENCES `herbs` (`herbId`) ON DELETE CASCADE,
  ADD CONSTRAINT `herbs_symptoms_symptomid_foreign` FOREIGN KEY (`symptomId`) REFERENCES `symptoms` (`symptomId`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_patientid_foreign` FOREIGN KEY (`patientId`) REFERENCES `patients` (`patientId`) ON DELETE CASCADE;

--
-- Constraints for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD CONSTRAINT `recommendations_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `health_categories` (`categoryId`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommendations_herbsid_foreign` FOREIGN KEY (`herbsId`) REFERENCES `herbs` (`herbId`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommendations_patientid_foreign` FOREIGN KEY (`patientId`) REFERENCES `patients` (`patientId`) ON DELETE CASCADE,
  ADD CONSTRAINT `recommendations_symptomid_foreign` FOREIGN KEY (`symptomId`) REFERENCES `symptoms` (`symptomId`) ON DELETE CASCADE;

--
-- Constraints for table `symptoms`
--
ALTER TABLE `symptoms`
  ADD CONSTRAINT `symptoms_categoryid_foreign` FOREIGN KEY (`categoryId`) REFERENCES `health_categories` (`categoryId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
