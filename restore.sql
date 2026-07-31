UPDATE patients SET patientId = 100 WHERE email = 'mimie@gmail.com';
DELETE FROM patients WHERE email = 'patient@herbcare.com';
UPDATE patients SET patientId = 2 WHERE email = 'rinazrusy@gmail.com';

INSERT INTO `patients` (`patientId`, `name`, `email`, `password`, `phone`, `profile_photo`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'raisha', 'raisha@gmail.com', '$2y$12$sGUHAmP6Y7wtYgEbjbaH7eQj7877WBAI9yRmxFmLuW8Bxcik8EJti', '01126262850', NULL, NULL, NULL, '2026-05-12 20:47:42', '2026-05-12 20:47:42'),
(4, 'aisyah', 'aisyah@gmail.com', '$2y$12$IVZWbi1LMdsRM/zqJ5x9TOAYW.9IK3MbP0egcPjF2YvHuRW6lGSli', '0126545622', NULL, NULL, NULL, '2026-05-12 21:01:23', '2026-05-12 21:01:23');

DELETE FROM practitioners WHERE email = 'practitioner@herbcare.com';

INSERT INTO `practitioners` (`practitionerId`, `name`, `email`, `password`, `phone`, `profile_photo`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'alya', 'alya@gmail.com', '$2y$12$aoKXDe6O2zTXgELvUSPTGOfRJFVH0BUDsdM0zlk8e2wBL7PWAZl6G', NULL, NULL, NULL, NULL, '2026-05-12 20:40:23', '2026-05-12 20:40:23'),
(3, 'CheeYat', 'cheeyat@gmail.com', '$2y$12$nR2UV3fq3I4bXuPoyDzmsOQU/f2u91/W2L/00jk.HorAal3H68M.q', NULL, NULL, NULL, NULL, '2026-05-12 21:02:40', '2026-05-12 21:02:40'),
(4, 'Dr hamzah', 'hamzah@gmail.com', '$2y$12$2Zq1jnoAI7UvWNfjzocN8eySfkMMyW1U4ker/kTUxz30jUxKPxO9S', '01126262850', NULL, NULL, NULL, '2026-07-13 08:20:58', '2026-07-13 08:20:58');

INSERT INTO `messages` (`messageId`, `patientId`, `practitionerId`, `subject`, `message`, `status`, `created_at`, `updated_at`, `reply`, `replied_at`, `is_read`) VALUES
(1, 4, NULL, 'consultation herbs', 'if i bloated what herbs suitable for my stomach', 'resolved', '2026-05-12 21:02:07', '2026-05-12 21:38:59', 'Ginger\r\nGood for bloating, nausea, and indigestion.\r\nTry: ginger tea or a few slices in hot water.\r\nPeppermint\r\nMay help relax stomach muscles and reduce gas.\r\nTry: peppermint tea.\r\nAvoid if you often get acid reflux/heartburn, since it can worsen that.', '2026-05-12 21:38:03', 1),
(2, 2, NULL, 'consultation herbs', 'i want to make drink tea can u suggest herbal', 'pending', '2026-05-12 21:03:48', '2026-05-12 21:03:48', NULL, NULL, 0),
(3, 3, NULL, 'consultation herbs', 'i get red rashes in my body which herb suitable to use', 'replied', '2026-05-12 21:36:53', '2026-05-12 21:37:26', 'Turmeric\r\nHas anti-inflammatory properties; usually taken in food/tea rather than applied directly (it can stain skin).', '2026-05-12 21:37:26', 0);
