--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.3.358.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 26.11.2015 20:03:42
-- Версия сервера: 5.5.29
-- Версия клиента: 4.1
--


-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE yii;

--
-- Описание для таблицы lb_author
--
DROP TABLE IF EXISTS lb_author;
CREATE TABLE lb_author (
  author_id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (author_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 6
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы lb_user
--
DROP TABLE IF EXISTS lb_user;
CREATE TABLE lb_user (
  user_id INT(11) NOT NULL AUTO_INCREMENT,
  created_at INT(11) NOT NULL,
  updated_at INT(11) NOT NULL,
  username VARCHAR(255) NOT NULL,
  auth_key VARCHAR(32) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  PRIMARY KEY (user_id),
  INDEX idx_user_email (email),
  INDEX idx_user_username (username)
)
ENGINE = INNODB
AUTO_INCREMENT = 9
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы lb_book
--
DROP TABLE IF EXISTS lb_book;
CREATE TABLE lb_book (
  book_id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  date_create INT(11) NOT NULL,
  date_update INT(11) NOT NULL,
  preview VARCHAR(255) NOT NULL DEFAULT '',
  date INT(11) NOT NULL,
  author_id INT(11) NOT NULL,
  PRIMARY KEY (book_id),
  CONSTRAINT FK_lb_book_lb_author_author_id FOREIGN KEY (author_id)
    REFERENCES lb_author(author_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 56
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Вывод данных для таблицы lb_author
--
INSERT INTO lb_author VALUES
(1, 'Киплинг Д.Р.'),
(2, 'Гоголь Н.В.'),
(3, 'Толстой Л.Н.');

-- 
-- Вывод данных для таблицы lb_user
--
INSERT INTO lb_user VALUES
(8, 1448544659, 1448544659, 'vayas', 'MFKb6rncdhL5E-cXuQRxLh9kxyya5MKh', '$2y$13$MMsi1FxOwtOKMpwuvOgvN.gE9HweGxrs9lo/2iMwGE7cvtZXL8tYG', 'backahell@rambler.ru');

-- 
-- Вывод данных для таблицы lb_book
--
INSERT INTO lb_book VALUES
(45, 'Мёртвые души', 1448548476, 1448548476, '1329838212_1.jpg', 1292112000, 2),
(46, 'Ночь перед рождеством', 1448548512, 1448548512, '1329838212_2.jpg', 1292112000, 2),
(47, 'Книга джунглей', 1448548545, 1448548545, '1329838212_3.jpg', 1292112000, 1),
(48, 'Рикки-Тикки-Тави', 1448548584, 1448548584, '1329838212_5.jpg', 1292112000, 1),
(49, 'Война и мир', 1448548598, 1448548598, '1329838212_4.jpg', 1292112000, 3);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;