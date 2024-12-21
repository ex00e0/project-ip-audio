-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 21 2024 г., 04:43
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `audio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` bigint UNSIGNED NOT NULL,
  `to` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `text`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 'text0', 1, 5, NULL, NULL),
(2, 'text02', 5, 1, NULL, NULL),
(3, 'text02', 5, 2, NULL, NULL),
(4, 'send_something', 5, 2, '2024-12-20 20:57:18', '2024-12-20 20:57:18'),
(5, 'send_something2', 5, 3, '2024-12-20 20:57:51', '2024-12-20 20:57:51');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_12_18_145621_create_tracks_table', 1),
(4, '2024_12_20_122134_create_saves_table', 1),
(5, '2024_12_20_205123_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `saves`
--

CREATE TABLE `saves` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `track_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `saves`
--

INSERT INTO `saves` (`id`, `user_id`, `track_id`, `created_at`, `updated_at`) VALUES
(5, 5, 7, '2024-12-20 09:27:34', '2024-12-20 09:27:34'),
(6, 7, 16, '2024-12-20 10:49:04', '2024-12-20 10:49:04'),
(7, 7, 1, '2024-12-20 10:49:10', '2024-12-20 10:49:10'),
(8, 7, 3, '2024-12-20 10:49:17', '2024-12-20 10:49:17');

-- --------------------------------------------------------

--
-- Структура таблицы `tracks`
--

CREATE TABLE `tracks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `performer_id` bigint UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tracks`
--

INSERT INTO `tracks` (`id`, `name`, `performer_id`, `file`, `created_at`, `updated_at`) VALUES
(1, 'calm', 3, 'Calm_music_-_Zeon_73851765.mp3', '2024-12-19 02:23:21', NULL),
(2, 'track000', 5, 'Meditation_Best_Relaxing_Spa_Music_Legends_Of_The_Drum_-_Wind_Spirits_48069509.mp3', '2024-12-20 02:23:21', '2024-12-19 07:38:38'),
(3, 'track1', 5, 'Calm_music_-_Zeon_73851765.mp3', '2024-12-18 02:23:21', NULL),
(7, 'meditation', 5, 'Meditation_Best_Relaxing_Spa_Music_Legends_Of_The_Drum_-_Wind_Spirits_48069509.mp3', '2024-12-19 07:28:28', '2024-12-19 07:28:28'),
(8, 'track001', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 07:52:47', '2024-12-19 07:52:47'),
(9, 'track002', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:09:24', '2024-12-19 09:09:24'),
(10, 'track003', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:09:41', '2024-12-19 09:09:41'),
(11, 'track004', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:10:12', '2024-12-19 09:10:12'),
(12, 'track005', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:10:35', '2024-12-19 09:10:35'),
(13, 'track006', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:11:19', '2024-12-19 09:11:30'),
(14, 'track007', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 09:11:48', '2024-12-19 09:11:48'),
(15, 'track008', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', '2024-12-19 11:49:23', '2024-12-19 11:49:23'),
(16, 'meditation 2', 5, 'Valeria_Ray_-_Strong_Waves_76194024.mp3', '2024-12-20 09:20:37', '2024-12-20 09:20:37');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','listener','performer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `friends` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `friends`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.ru', '$2y$10$Qh6CoVcMXScY6bQMF327gOSvoGDOOLHQIckkcnG38mn1EokHZ4MnC', 'admin', NULL, '2024-12-18 06:47:59', '2024-12-18 06:47:59'),
(2, 'ivanivan8', 'ivanivan8@mail.ru', '$2y$10$BLtfctJCwrlwtsVQzR0zyegqnCPC3hmbK78Pu50dYxkJmNyiryewi', 'listener', NULL, '2024-12-18 06:47:59', '2024-12-19 00:02:29'),
(3, 'ivanivan2', 'ivan2@mail.ru', '$2y$10$XSnLyvNMJF/vw56XJvVsOeROLu4LI7LeR472qGzPMShPQsruYKwAq', 'performer', NULL, '2024-12-18 06:51:02', '2024-12-18 06:51:02'),
(4, 'puppy', 'puppy@puppy.puppy', '$2y$10$e6vrXetxgmTnzA2zC18aW.7EdD8Oh6BSr48MXkaaYdrkNinmn1alu', 'listener', NULL, '2024-12-19 02:23:21', '2024-12-19 02:23:21'),
(5, 'performer0', 'x-x-x-x-2000-x-x@mail.ru', '$2y$10$.p/9W1rAi9wBA3bFN6mHyOYxwMGcBE0wfKFBom4XLV3dgQ/LoDOU.', 'performer', NULL, '2024-12-19 02:28:01', '2024-12-20 22:41:43'),
(6, 'performer01', 'performer01@performer01.ru', '$2y$10$VVUk/bPrjgAjVO7LBAyyxel/IbYm4tPMoyT3dfDRZJFgTIz9HYzRK', 'performer', NULL, '2024-12-19 02:28:58', '2024-12-19 02:28:58'),
(7, 'listener0', 'listener0@listener0.ru', '$2y$10$XjJcaTaIqlOQWUNLi6jcreGVxbfWUoQey4.a7F5fstwC8lobVW6Eu', 'listener', NULL, '2024-12-19 02:31:15', '2024-12-19 02:31:15'),
(8, 'listener01', 'listener01@listener01.ru', '$2y$10$Srqmh08UF8m2khki0MueF.eth/cenbeteNfTUiWlOOAUH3Ni3Tcmi', 'listener', NULL, '2024-12-19 02:41:49', '2024-12-19 02:41:49'),
(9, 'namename', 'namename@namename.ru', '$2y$10$qIYgOB6Nsbh0LKzQwdQeJurs8O5Av4q/5bvSAoHHuefb6nzwRJaVe', 'performer', NULL, '2024-12-19 02:44:34', '2024-12-19 02:44:34'),
(10, 'listener02', 'listener02@listener02.ru', '$2y$10$dXhRHFBZce1.E1RP7NMy1.vQLzpzqr5MHIPl/m.WcJFfAHkHWhFXu', 'listener', NULL, '2024-12-19 02:49:19', '2024-12-19 02:49:19');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_from_foreign` (`from`),
  ADD KEY `messages_to_foreign` (`to`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `saves`
--
ALTER TABLE `saves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saves_user_id_foreign` (`user_id`),
  ADD KEY `saves_track_id_foreign` (`track_id`);

--
-- Индексы таблицы `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracks_performer_id_foreign` (`performer_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `saves`
--
ALTER TABLE `saves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `saves`
--
ALTER TABLE `saves`
  ADD CONSTRAINT `saves_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`),
  ADD CONSTRAINT `saves_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_performer_id_foreign` FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
