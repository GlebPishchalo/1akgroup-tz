-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 02 2023 г., 20:24
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
-- База данных: `library1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Authors`
--

CREATE TABLE `Authors` (
  `ID` int NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Authors`
--

INSERT INTO `Authors` (`ID`, `FirstName`, `LastName`, `MiddleName`) VALUES
(1, 'Достое́вский', 'Фёдор', 'Миха́йлович');

-- --------------------------------------------------------

--
-- Структура таблицы `BookLoans`
--

CREATE TABLE `BookLoans` (
  `ID` int NOT NULL,
  `ReaderID` int DEFAULT NULL,
  `BookID` int DEFAULT NULL,
  `LoanDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `BookLoans`
--

INSERT INTO `BookLoans` (`ID`, `ReaderID`, `BookID`, `LoanDate`, `ReturnDate`) VALUES
(2, 1, 1, '2023-09-01', '2023-09-01'),
(3, 1, 1, '2023-09-01', '2023-09-01'),
(4, 1, 1, '2023-09-01', '2023-09-01'),
(5, 1, 1, '2023-09-01', '2023-09-01');

-- --------------------------------------------------------

--
-- Структура таблицы `Books`
--

CREATE TABLE `Books` (
  `ID` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AuthorID` int DEFAULT NULL,
  `Available` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Books`
--

INSERT INTO `Books` (`ID`, `Title`, `AuthorID`, `Available`) VALUES
(1, 'Преступление и наказание', 1, 1),
(2, 'Бесы', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `Readers`
--

CREATE TABLE `Readers` (
  `ID` int NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `Patronymic` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Readers`
--

INSERT INTO `Readers` (`ID`, `LastName`, `FirstName`, `Patronymic`) VALUES
(1, 'Глеб', 'Устинов', 'Александрович'),
(2, 'Иванов', 'Иван', 'Александрович');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Authors`
--
ALTER TABLE `Authors`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `BookLoans`
--
ALTER TABLE `BookLoans`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ReaderID` (`ReaderID`),
  ADD KEY `BookID` (`BookID`);

--
-- Индексы таблицы `Books`
--
ALTER TABLE `Books`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Индексы таблицы `Readers`
--
ALTER TABLE `Readers`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Authors`
--
ALTER TABLE `Authors`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `BookLoans`
--
ALTER TABLE `BookLoans`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `Books`
--
ALTER TABLE `Books`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `Readers`
--
ALTER TABLE `Readers`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `BookLoans`
--
ALTER TABLE `BookLoans`
  ADD CONSTRAINT `bookloans_ibfk_1` FOREIGN KEY (`ReaderID`) REFERENCES `Readers` (`ID`),
  ADD CONSTRAINT `bookloans_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `Books` (`ID`);

--
-- Ограничения внешнего ключа таблицы `Books`
--
ALTER TABLE `Books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `Authors` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
