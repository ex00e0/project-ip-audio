-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 08 2025 г., 10:43
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
-- Структура таблицы `albums`
--

CREATE TABLE `albums` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `performer_id` bigint UNSIGNED NOT NULL,
  `count_l` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`id`, `name`, `img`, `performer_id`, `count_l`, `created_at`, `updated_at`) VALUES
(1, 'Альбом 1', 'alb1.jpg', 5, 9, '2025-05-02 19:16:17', '2025-05-07 04:29:36'),
(2, 'Альбом 2', 'alb2.jpg', 5, 0, '2025-05-03 19:16:17', '2025-05-03 19:16:17'),
(3, 'Альбом 3', 'alb3.jpg', 11, 1, '2025-05-01 19:16:17', '2025-05-02 15:42:01'),
(4, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(5, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(6, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(7, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(8, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(9, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(10, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(11, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00'),
(12, 'rand', 'rand', 5, 0, '2025-04-03 18:00:00', '2025-04-03 18:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `liked_posts`
--

CREATE TABLE `liked_posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, 'send_something', 5, 2, '2024-12-20 14:57:18', '2024-12-20 14:57:18'),
(5, 'send_something2', 5, 3, '2024-12-20 14:57:51', '2024-12-20 14:57:51'),
(6, 'привет', 1, 3, '2024-12-20 18:29:17', '2024-12-20 18:29:17'),
(7, '444', 1, 3, '2024-12-20 21:16:09', '2024-12-20 21:16:09'),
(8, 'bjmc', 1, 2, '2025-04-28 20:37:41', '2025-04-28 20:37:41');

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
(3, '2024_12_17_200809_create_albums_table', 1),
(4, '2024_12_18_145621_create_tracks_table', 1),
(5, '2024_12_20_122134_create_saves_table', 1),
(6, '2024_12_20_205123_create_messages_table', 1),
(7, '2025_05_02_200816_create_posts_table', 1),
(8, '2025_05_07_104425_create_liked_posts_table', 1);

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
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `track_id` bigint UNSIGNED DEFAULT NULL,
  `performer_id` bigint UNSIGNED NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `text`, `img`, `track_id`, `performer_id`, `likes`, `created_at`, `updated_at`) VALUES
(1, 'текст', 'pngtree-color-abstraction-color-abstract-gradient-picture-image_938005.jpg', 2, 5, 0, '2025-05-04 15:11:02', '2025-05-07 12:12:01'),
(2, 'только текст', NULL, NULL, 6, 0, '2025-05-04 15:11:05', '2025-05-07 12:19:48');

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
(6, 7, 16, '2024-12-20 04:49:04', '2024-12-20 04:49:04'),
(8, 7, 3, '2024-12-20 04:49:17', '2024-12-20 04:49:17'),
(10, 7, 2, '2025-05-07 04:07:50', '2025-05-07 04:07:50');

-- --------------------------------------------------------

--
-- Структура таблицы `tracks`
--

CREATE TABLE `tracks` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `performer_id` bigint UNSIGNED NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `album_id` bigint UNSIGNED NOT NULL,
  `genre` enum('классика','джаз','рок','поп','хип-хоп','электронная музыка','другое') COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_l` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tracks`
--

INSERT INTO `tracks` (`id`, `name`, `performer_id`, `file`, `album_id`, `genre`, `count_l`, `created_at`, `updated_at`) VALUES
(2, 'track000', 5, 'Meditation_Best_Relaxing_Spa_Music_Legends_Of_The_Drum_-_Wind_Spirits_48069509.mp3', 1, 'другое', 0, '2024-12-19 20:23:21', '2024-12-19 01:38:38'),
(3, 'track1', 5, 'Calm_music_-_Zeon_73851765.mp3', 1, 'другое', 4, '2024-12-17 20:23:21', '2025-05-07 04:19:28'),
(7, 'meditation', 5, 'Meditation_Best_Relaxing_Spa_Music_Legends_Of_The_Drum_-_Wind_Spirits_48069509.mp3', 1, 'другое', 0, '2024-12-19 01:28:28', '2024-12-19 01:28:28'),
(10, 'track003', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', 2, 'другое', 0, '2024-12-19 03:09:41', '2024-12-19 03:09:41'),
(11, 'track004', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', 2, 'другое', 0, '2024-12-19 03:10:12', '2024-12-19 03:10:12'),
(13, 'track006', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', 2, 'другое', 0, '2024-12-19 03:11:19', '2024-12-19 03:11:30'),
(14, 'track007', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', 2, 'другое', 0, '2024-12-19 03:11:48', '2024-12-19 03:11:48'),
(15, 'track008', 5, 'Uspokaivayushhaya_muzyka_-_SHum_vody_56569717.mp3', 2, 'другое', 0, '2024-12-19 05:49:23', '2024-12-19 05:49:23'),
(16, 'meditation 2', 5, 'Valeria_Ray_-_Strong_Waves_76194024.mp3', 1, 'другое', 11, '2024-12-20 03:20:37', '2025-05-07 04:29:36'),
(17, 'qwe', 11, 'Valeria_Ray_-_Strong_Waves_76194024.mp3', 3, 'другое', 0, '2024-12-20 19:15:56', '2024-12-20 19:19:11'),
(18, 'Успокаивающая музыка', 11, 'Valeria_Ray_-_Strong_Waves_76194024.mp3', 3, 'другое', 0, '2024-12-20 19:19:31', '2024-12-20 19:19:31');

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
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user 1.svg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `friends`, `img`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.ru', '$2y$10$Qh6CoVcMXScY6bQMF327gOSvoGDOOLHQIckkcnG38mn1EokHZ4MnC', 'admin', '{\"id\": [3, 2]}', 'user 1.svg', '2024-12-18 00:47:59', '2024-12-20 21:16:32'),
(2, 'ivanivan8', 'ivanivan8@mail.ru', '$2y$10$BLtfctJCwrlwtsVQzR0zyegqnCPC3hmbK78Pu50dYxkJmNyiryewi', 'listener', NULL, 'user 1.svg', '2024-12-18 00:47:59', '2024-12-18 18:02:29'),
(3, 'ivanivan2', 'ivan2@mail.ru', '$2y$10$XSnLyvNMJF/vw56XJvVsOeROLu4LI7LeR472qGzPMShPQsruYKwAq', 'performer', NULL, 'user 1.svg', '2024-12-18 00:51:02', '2024-12-18 00:51:02'),
(4, 'puppy', 'puppy@puppy.puppy', '$2y$10$e6vrXetxgmTnzA2zC18aW.7EdD8Oh6BSr48MXkaaYdrkNinmn1alu', 'listener', NULL, 'user 1.svg', '2024-12-18 20:23:21', '2024-12-18 20:23:21'),
(5, 'performer0', 'x-x-x-x-2000-x-x@mail.ru', '$2y$10$.p/9W1rAi9wBA3bFN6mHyOYxwMGcBE0wfKFBom4XLV3dgQ/LoDOU.', 'performer', NULL, 'user 1.svg', '2024-12-18 20:28:01', '2024-12-20 16:41:43'),
(6, 'performer01', 'performer01@performer01.ru', '$2y$10$VVUk/bPrjgAjVO7LBAyyxel/IbYm4tPMoyT3dfDRZJFgTIz9HYzRK', 'performer', NULL, 'user 1.svg', '2024-12-18 20:28:58', '2024-12-18 20:28:58'),
(7, 'listener0', 'listener0@listener0.ru', '$2y$10$XjJcaTaIqlOQWUNLi6jcreGVxbfWUoQey4.a7F5fstwC8lobVW6Eu', 'listener', NULL, 'user 1.svg', '2024-12-18 20:31:15', '2024-12-18 20:31:15'),
(8, 'listener01', 'listener01@listener01.ru', '$2y$10$Srqmh08UF8m2khki0MueF.eth/cenbeteNfTUiWlOOAUH3Ni3Tcmi', 'listener', NULL, 'user 1.svg', '2024-12-18 20:41:49', '2024-12-18 20:41:49'),
(9, 'namename', 'namename@namename.ru', '$2y$10$qIYgOB6Nsbh0LKzQwdQeJurs8O5Av4q/5bvSAoHHuefb6nzwRJaVe', 'performer', NULL, 'user 1.svg', '2024-12-18 20:44:34', '2024-12-18 20:44:34'),
(10, 'listener02', 'listener02@listener02.ru', '$2y$10$dXhRHFBZce1.E1RP7NMy1.vQLzpzqr5MHIPl/m.WcJFfAHkHWhFXu', 'listener', NULL, 'user 1.svg', '2024-12-18 20:49:19', '2024-12-18 20:49:19'),
(11, 'Милана', 'shastoon@label.com', '$2y$10$TD/4ITAGsqMJ2BW4iTMPhedZ7XDuGBLugMIHWTQ.d9DpwBoWj.Ahu', 'performer', NULL, 'user 1.svg', '2024-12-20 19:14:55', '2024-12-20 19:14:55');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_performer_id_foreign` (`performer_id`);

--
-- Индексы таблицы `liked_posts`
--
ALTER TABLE `liked_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liked_posts_user_id_foreign` (`user_id`),
  ADD KEY `liked_posts_post_id_foreign` (`post_id`);

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
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_track_id_foreign` (`track_id`),
  ADD KEY `posts_performer_id_foreign` (`performer_id`);

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
  ADD KEY `tracks_performer_id_foreign` (`performer_id`),
  ADD KEY `tracks_album_id_foreign` (`album_id`);

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
-- AUTO_INCREMENT для таблицы `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `liked_posts`
--
ALTER TABLE `liked_posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `saves`
--
ALTER TABLE `saves`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_performer_id_foreign` FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `liked_posts`
--
ALTER TABLE `liked_posts`
  ADD CONSTRAINT `liked_posts_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `liked_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_from_foreign` FOREIGN KEY (`from`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_to_foreign` FOREIGN KEY (`to`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_performer_id_foreign` FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`);

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
  ADD CONSTRAINT `tracks_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`),
  ADD CONSTRAINT `tracks_performer_id_foreign` FOREIGN KEY (`performer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
