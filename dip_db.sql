-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 16 2017 г., 18:37
-- Версия сервера: 5.7.14
-- Версия PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dip_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(30) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 NOT NULL,
  `passhash` varchar(32) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(10) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `email`, `passhash`, `password`, `phone`, `status`) VALUES
(1, 1, 'Олексій', 'Мірошниченко', 'admin@gmail.com', '9240167557d2a949601b68a840de7644', 'pass123', '0930626768', '1'),
(2, 2, 'Іван', 'Іванов', 'ivanov@gmail.com', '9240167557d2a949601b68a840de7644', 'pass123', '0930123565', '1'),
(3, 2, 'Петро', 'Петренко', 'petya@gmail.com', '69ac428872f20ee13afa1dd2bf4402dc', 'petya12', '0981221276', '1'),
(4, 1, 'Вікторія', 'Резанова', 'rezanova.vg@knutd.com.ua', '3507432efeebace9faaa275ad1ed2c1e', 'qwe123', '', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users_log`
--

CREATE TABLE `users_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `user_ip` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users_log`
--

INSERT INTO `users_log` (`id`, `user_id`, `date_time`, `user_ip`) VALUES
(1, 1, '2017-11-26 20:50:46', 0),
(2, 4, '2017-11-26 20:50:54', 0),
(3, 4, '2017-11-26 20:50:54', 0),
(4, 1, '2017-11-26 20:51:44', 0),
(5, 3, '2017-11-26 20:51:50', 0),
(6, 1, '2017-11-26 20:51:57', 0),
(7, 1, '2017-11-26 21:03:39', 2130706433),
(8, 2, '2017-11-26 21:03:44', 2130706433),
(9, 1, '2017-11-27 00:23:27', 2130706433),
(10, 1, '2017-11-27 11:49:01', 2130706433),
(11, 1, '2017-11-28 11:48:21', 2130706433),
(12, 1, '2017-11-30 14:25:00', 2130706433),
(13, 1, '2017-12-03 15:23:04', 2130706433),
(14, 1, '2017-12-07 12:22:04', 2130706433),
(15, 1, '2017-12-10 17:35:13', 2130706433),
(16, 1, '2017-12-10 23:39:33', 2130706433),
(17, 1, '2017-12-10 23:43:58', 2130706433),
(18, 1, '2017-12-16 15:41:57', 2130706433);

-- --------------------------------------------------------

--
-- Структура таблицы `users_role`
--

CREATE TABLE `users_role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users_role`
--

INSERT INTO `users_role` (`id`, `role_name`) VALUES
(1, 'Адмін'),
(2, 'Науковець');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_log`
--
ALTER TABLE `users_log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users_log`
--
ALTER TABLE `users_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `users_role`
--
ALTER TABLE `users_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
