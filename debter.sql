-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 06 2018 г., 10:01
-- Версия сервера: 10.1.30-MariaDB
-- Версия PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `debter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bancrupts_stage`
--

CREATE TABLE `bancrupts_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `total_summ` float(10,2) DEFAULT NULL,
  `real_summ` float(10,2) DEFAULT NULL,
  `terms` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `collection_stage`
--

CREATE TABLE `collection_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `stage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `content`
--

CREATE TABLE `content` (
  `id` int(10) NOT NULL,
  `title` varchar(25) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `content`
--

INSERT INTO `content` (`id`, `title`, `text`) VALUES
(1, 'about', '<div class=\"content\">\r\n      <h4><i class=\"fas fa-users\"></i> Для кого это приложение?</h4>\r\n      <p>Данный ресурс может быть использован кредитными орагизациями,которые имеют в своем портфеле низколиквидные активы, которые могут быть уступлены \r\n        по договору цессии коллекторским агенствам.</p>\r\n      <h4><i class=\"fas fa-question-circle\"></i> Зачем использовать данный веб-ресурс?</h4>\r\n      <p>Данный ресурс предназначен для повышения уровня автоматизации работы с проблемной задолженностью.</p>\r\n      <h4><i class=\"fas fa-plus-circle\"></i> Какие преимущества его использования?</h4>\r\n      <p>Приложение позволяет существенно сократить процедуру принятия решения по вопросам, связанным с уступкой прав,которые выносят сотрудники на кредитные комитеты.</p>\r\n      <h4><i class=\"fas fa-handshake\"></i> Насколько можно доверять его результатам работы?</h4>\r\n      <p>Логика приложения построена на анализе имущественного состояния должника, стадии взыскания, срока просрочки и таким образом впитывает в себя\r\n        традиционные методы оценки актива. Результаты работы могут приниматься к сведению членами комитета в качестве отправных точек и люфта торга.</p>\r\n    </div>'),
(2, 'rules', '<div class=\"content\">\r\n<h4><i class=\"fas fa-question-circle\"></i> Как начать работу с приложением?</h4>\r\n<p> Для начала работы пройдите процедуру регистрации.</p>\r\n<h4><i class=\"fas fa-question-circle\"></i> Что делать после регистрации?</h4>\r\n<p>После завершения процедуры регистрации нажмите на кнопку \"Начать работу\".</p>\r\n<h4><i class=\"fas fa-question-circle\"></i> Что делать в процессе работы программы?</h4>\r\n<p>В процессе работы программы необходимо последовательно отвечать на задаваемые вопросы, корректно заполняя поля форм.</p>\r\n<h4><i class=\"fas fa-question-circle\"></i> Как получить итоговый результат работы программы?</h4>\r\n<p>После внесения всей необходимой информации об активе нажмите на кнопку \"Запустить анализ\".</p>\r\n</div>\r\n\r\n\r\n</div>');

-- --------------------------------------------------------

--
-- Структура таблицы `debters`
--

CREATE TABLE `debters` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `execution_stage`
--

CREATE TABLE `execution_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `payments` varchar(50) DEFAULT NULL,
  `property` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `liquidation_stage`
--

CREATE TABLE `liquidation_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `total_summ` float(10,2) DEFAULT NULL,
  `real_summ` float(10,2) DEFAULT NULL,
  `term` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `main_parameters`
--

CREATE TABLE `main_parameters` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `main_debt` float(10,2) UNSIGNED NOT NULL,
  `persentage` float(10,2) UNSIGNED NOT NULL,
  `forfeit` float(10,2) UNSIGNED NOT NULL,
  `reserves` float(10,2) UNSIGNED NOT NULL,
  `days_of_delay` int(10) UNSIGNED NOT NULL,
  `full_expiration` varchar(50) NOT NULL,
  `reason_of_delay` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pledged_property`
--

CREATE TABLE `pledged_property` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `liquidity` varchar(50) DEFAULT NULL,
  `will_to_sell` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pretrial_stage_entity`
--

CREATE TABLE `pretrial_stage_entity` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `analysis` varchar(50) NOT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `restructuring_readiness` varchar(45) DEFAULT NULL,
  `property` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pretrial_stage_individual`
--

CREATE TABLE `pretrial_stage_individual` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `contact` varchar(10) NOT NULL,
  `property` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'banned');

-- --------------------------------------------------------

--
-- Структура таблицы `trial_pledged_property`
--

CREATE TABLE `trial_pledged_property` (
  `id` int(10) NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `price` float(10,2) NOT NULL,
  `liquidity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `trial_stage`
--

CREATE TABLE `trial_stage` (
  `id` int(10) UNSIGNED NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL,
  `prospects` varchar(50) DEFAULT NULL,
  `terms` int(10) DEFAULT NULL,
  `property` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `type_of_debter`
--

CREATE TABLE `type_of_debter` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(45) NOT NULL,
  `debters_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `patronymic` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `roles_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `patronymic`, `lastname`, `mail`, `login`, `password`, `roles_id`) VALUES
(5, 'Александр', 'Юрьевич', 'Анохин', 'anohin.vangazi@yandex.ru', 'Alex', '$2y$10$8wduH8I9YnBm.Rw0vbn0ju0IbG7IibzspGDqFM1dGnXlHOt6l3KLi', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_session`
--

CREATE TABLE `users_session` (
  `id` int(10) NOT NULL,
  `users_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `session` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bancrupts_stage`
--
ALTER TABLE `bancrupts_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debter_id_idx` (`debters_id`);

--
-- Индексы таблицы `collection_stage`
--
ALTER TABLE `collection_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `debters`
--
ALTER TABLE `debters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_ibfk_1` (`user_id`);

--
-- Индексы таблицы `execution_stage`
--
ALTER TABLE `execution_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `liquidation_stage`
--
ALTER TABLE `liquidation_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debter_id_idx` (`debters_id`);

--
-- Индексы таблицы `main_parameters`
--
ALTER TABLE `main_parameters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `pledged_property`
--
ALTER TABLE `pledged_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `pretrial_stage_entity`
--
ALTER TABLE `pretrial_stage_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debter_id_idx` (`debters_id`);

--
-- Индексы таблицы `pretrial_stage_individual`
--
ALTER TABLE `pretrial_stage_individual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_ibfk_1` (`user_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `trial_pledged_property`
--
ALTER TABLE `trial_pledged_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id` (`debters_id`);

--
-- Индексы таблицы `trial_stage`
--
ALTER TABLE `trial_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `type_of_debter`
--
ALTER TABLE `type_of_debter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `debters_id_idx` (`debters_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_id` (`roles_id`);

--
-- Индексы таблицы `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_session_ibfk_1` (`users_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bancrupts_stage`
--
ALTER TABLE `bancrupts_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `collection_stage`
--
ALTER TABLE `collection_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `content`
--
ALTER TABLE `content`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `debters`
--
ALTER TABLE `debters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `execution_stage`
--
ALTER TABLE `execution_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `liquidation_stage`
--
ALTER TABLE `liquidation_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `main_parameters`
--
ALTER TABLE `main_parameters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `pledged_property`
--
ALTER TABLE `pledged_property`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `pretrial_stage_entity`
--
ALTER TABLE `pretrial_stage_entity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `pretrial_stage_individual`
--
ALTER TABLE `pretrial_stage_individual`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `trial_pledged_property`
--
ALTER TABLE `trial_pledged_property`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `trial_stage`
--
ALTER TABLE `trial_stage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `type_of_debter`
--
ALTER TABLE `type_of_debter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bancrupts_stage`
--
ALTER TABLE `bancrupts_stage`
  ADD CONSTRAINT `bankrupt_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `collection_stage`
--
ALTER TABLE `collection_stage`
  ADD CONSTRAINT `collection_stage_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `debters`
--
ALTER TABLE `debters`
  ADD CONSTRAINT `debters_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `execution_stage`
--
ALTER TABLE `execution_stage`
  ADD CONSTRAINT `execution_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `liquidation_stage`
--
ALTER TABLE `liquidation_stage`
  ADD CONSTRAINT `liquidation_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `main_parameters`
--
ALTER TABLE `main_parameters`
  ADD CONSTRAINT `params_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pledged_property`
--
ALTER TABLE `pledged_property`
  ADD CONSTRAINT `pledged_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pretrial_stage_entity`
--
ALTER TABLE `pretrial_stage_entity`
  ADD CONSTRAINT `pretrial_legal_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pretrial_stage_individual`
--
ALTER TABLE `pretrial_stage_individual`
  ADD CONSTRAINT `pretrial_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `trial_pledged_property`
--
ALTER TABLE `trial_pledged_property`
  ADD CONSTRAINT `trial_pledged_property_ibfk_1` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `trial_stage`
--
ALTER TABLE `trial_stage`
  ADD CONSTRAINT `trial_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `type_of_debter`
--
ALTER TABLE `type_of_debter`
  ADD CONSTRAINT `type_key` FOREIGN KEY (`debters_id`) REFERENCES `debters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_session`
--
ALTER TABLE `users_session`
  ADD CONSTRAINT `users_session_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
