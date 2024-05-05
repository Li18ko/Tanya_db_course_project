-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 19 2024 г., 20:44
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_4sem`
--

-- --------------------------------------------------------

--
-- Структура таблицы `priority`
--

CREATE TABLE `priority` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `priority`
--

INSERT INTO `priority` (`id`, `name`) VALUES
(1, 'Низкий'),
(2, 'Средний'),
(3, 'Высокий');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Новая'),
(2, 'В работе'),
(3, 'Завершена');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status_id` int DEFAULT NULL,
  `priority_id` int DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `name`, `description`, `status_id`, `priority_id`, `date_creation`) VALUES
(1, 1, 'Выполнить лабораторную 3 по бд', 'Необходимо выполнить лабораторную, отправить ее на проверку', 2, 3, '2024-04-02 15:24:42'),
(3, 1, 'Убрать в квартире', 'Убрать в квартире', 2, 2, '2024-04-06 09:25:20'),
(4, 3, 'Сходить в магазин', 'Купить: хлеб, кашу, молоко', 3, 2, '2024-04-01 12:25:20'),
(9, 4, 'Задача 2', 'Задача 222222', 1, 1, '2024-03-15 11:25:20'),
(10, 4, 'Сходить в магазин', 'Купить 15 сырков', 1, 3, '2024-04-07 22:59:41'),
(11, 4, 'Убрать', 'Кухня + ванная', 1, 2, '2024-04-07 23:00:05'),
(13, 4, 'Съездить на физру', 'Надо получить баллы за посещение и сдать нормативы', 2, 3, '2024-04-08 01:27:42'),
(14, 4, '1234567887654321', '1234567898765432', 1, 3, '2024-04-17 19:18:47');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`) VALUES
(1, 'Иванов Иван Иванович', 'users1', 'b2255c5d029d69e44374a99e9d03921d'),
(2, 'Кочеткова Татьяна Александровна', 'tanya_tanya', '28dc6ff614c6019c1e5fc6854ec4c4f3'),
(3, 'tea', 'tea_tea', '11a9e4996da8b4104e3cd7c26537db59'),
(4, 'Петров Петр Петрович', 'pet_pet', '2d88fa06bef2eb1b3707b959be80ad0a'),
(5, 'lkjhgrewhgfds', 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `priority_id` (`priority_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
