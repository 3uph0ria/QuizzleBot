-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Сен 21 2021 г., 19:13
-- Версия сервера: 5.7.27-30
-- Версия PHP: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `u1332733_testing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Answers`
--

CREATE TABLE `Answers` (
  `Id` int(11) NOT NULL,
  `IdQuestion` int(11) NOT NULL,
  `Text` varchar(500) NOT NULL,
  `Correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Answers`
--

INSERT INTO `Answers` (`Id`, `IdQuestion`, `Text`, `Correct`) VALUES
(2, 1, 'ответ1', 0),
(3, 1, 'ответ3', 0),
(5, 1, 'ответ4', 1),
(6, 2, 'ответ1', 1),
(7, 2, 'ответ2', 0),
(8, 2, 'ответ3', 0),
(9, 2, 'ответ4', 0),
(10, 1, 'ответ2', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `Bots`
--

CREATE TABLE `Bots` (
  `Id` int(11) NOT NULL,
  `ClubId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Bots`
--

INSERT INTO `Bots` (`Id`, `ClubId`, `Name`) VALUES
(1, 207271263, 'Тестирование №1');

-- --------------------------------------------------------

--
-- Структура таблицы `PanelUsers`
--

CREATE TABLE `PanelUsers` (
  `Id` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `DateRental` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `PanelUsers`
--

INSERT INTO `PanelUsers` (`Id`, `Login`, `Password`, `DateRental`) VALUES
(1, 'admin', '$2y$10$8HiDvXwnqeYugrxqYivcluEz0kiJl7382oi5S8Scq7BF.iLRjVBxy', '2021-09-25');

-- --------------------------------------------------------

--
-- Структура таблицы `Questions`
--

CREATE TABLE `Questions` (
  `Id` int(11) NOT NULL,
  `IdTest` int(11) NOT NULL,
  `Text` varchar(500) NOT NULL,
  `Score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Questions`
--

INSERT INTO `Questions` (`Id`, `IdTest`, `Text`, `Score`) VALUES
(1, 1, 'Вопрос1', 1),
(2, 1, 'вопрос2', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Tests`
--

CREATE TABLE `Tests` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Tests`
--

INSERT INTO `Tests` (`Id`, `Name`, `IdUser`) VALUES
(1, 'Тестовый тест', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `UserResults`
--

CREATE TABLE `UserResults` (
  `Id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `IdTest` int(11) NOT NULL,
  `IdQuestion` int(11) NOT NULL,
  `IdAnswer` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `IdPanelUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `UserResults`
--

INSERT INTO `UserResults` (`Id`, `IdUser`, `IdTest`, `IdQuestion`, `IdAnswer`, `Date`, `IdPanelUser`) VALUES
(29, 8, 1, 1, 2, '2021-09-21 05:09:22', 1),
(30, 8, 1, 2, 8, '2021-09-21 05:09:24', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `Id` int(11) NOT NULL,
  `IdBot` int(11) NOT NULL,
  `Photo` varchar(250) NOT NULL,
  `PeerId` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`Id`, `IdBot`, `Photo`, `PeerId`, `FullName`) VALUES
(8, 1, 'https://sun1-87.userapi.com/s/v1/ig2/Fdj1OWhavkIjv19JTzorV74FuLu4WR9nSBi63S4ObknqjlTPh6ydik65zzP-riVdSqMX4J3QNxf-VkC5xKDIZa98.jpg?size=50x50&quality=95&crop=0,2,1476,1476&ava=1', 212386903, 'СергейКоваль'),
(9, 1, 'https://sun1-20.userapi.com/s/v1/ig2/HT3EnBhTLmPchhK2E4_Nt9iKAmTpr_jiIgYqfrA1KXzNBf4dMiVFktnEE4QaNhqyEyrQ4pz144yutimOExKpqmVF.jpg?size=50x50&quality=96&crop=0,0,542,542&ava=1', 548992603, 'АринаПетрова'),
(10, 1, 'https://vk.com/images/camera_50.png', 676148091, 'WilliamArnold'),
(11, 1, 'https://vk.com/images/camera_50.png', 676198709, 'MichaelRodriguez'),
(12, 1, 'https://vk.com/images/camera_50.png', 676316712, 'JeffAnderson'),
(13, 1, 'https://sun6-22.userapi.com/s/v1/ig2/g_WAqMO1R6RbWh6Tio0SyJGl37wy3t9rU2gWgFmpuoBHm-UMASGizOGB2ixIXYGK6Od6FH6fme_r1OWOUR2oD6Qu.jpg?size=50x50&quality=96&crop=0,0,453,453&ava=1', 374245530, 'МарияАлмазова');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Answers`
--
ALTER TABLE `Answers`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Bots`
--
ALTER TABLE `Bots`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `PanelUsers`
--
ALTER TABLE `PanelUsers`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Tests`
--
ALTER TABLE `Tests`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `UserResults`
--
ALTER TABLE `UserResults`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Answers`
--
ALTER TABLE `Answers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `Bots`
--
ALTER TABLE `Bots`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `PanelUsers`
--
ALTER TABLE `PanelUsers`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `Questions`
--
ALTER TABLE `Questions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `Tests`
--
ALTER TABLE `Tests`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `UserResults`
--
ALTER TABLE `UserResults`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
