-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Час створення: Сер 13 2022 р., 03:59
-- Версія сервера: 10.3.32-MariaDB
-- Версія PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `auth`
--

-- --------------------------------------------------------

--
-- Структура таблиці `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `login` varchar(20) NOT NULL,
  `pswd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп даних таблиці `students`
--

INSERT INTO `students` (`id`, `name`, `surname`, `middlename`, `login`, `pswd`) VALUES
(1, 'ivan', 'ivanov', 'ivanovich', '111', '$2y$10$bEpeRY2YvrwSxt4dsi.FpuJ8Ojj6DvTVYpp5DgKEf1kbc4JIKmtHG'),
(2, 'oleg', 'olegov', 'olegovich', '222', '$2y$10$Nar2T.YRBQFoivhYJlW19O/wx/sacvxQPGSL9.tCNov9a9ZJlJJWi'),
(3, 'Андрій', 'Машковський', 'Леонідович', 'login', '$2y$10$GnI9ZwdCIFBgrWiEJu44kOZeGC7YImXTiqrCB2NTrcXOWCTIc969a'),
(4, 'Імя', 'Прізвище', 'По батькові', 'Логін', '$2y$10$JFFBYwZRlEPKeG32RiTzL.8HPi/Tw1jmpCyaTzYMBqjmATe4anROy');

-- --------------------------------------------------------

--
-- Структура таблиці `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `token` varchar(32) NOT NULL,
  `tokentime` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп даних таблиці `tokens`
--

INSERT INTO `tokens` (`id`, `student_id`, `login`, `token`, `tokentime`) VALUES
(6, 2, '222', '14522', 2147483647),
(116, 1, '111', 'efd1494ca08a6c7ff478a86cdde7c932', 1660348156),
(193, 4, 'Логін', '29532b67e7310475d4dc1a78fe42153f', 1660352283);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Індекси таблиці `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
