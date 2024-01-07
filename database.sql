CREATE DATABASE IF NOT EXISTS `let`;

USE `let`;

CREATE TABLE IF NOT EXISTS `users`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL UNIQUE,
    `password` VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS `admin`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS `files`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `filename` VARCHAR(30) NOT NULL,
    `description` VARCHAR(300) NOT NULL,
    `file` VARCHAR(300) NOT NULL,
    `date_uploaded` DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS `yt_link`(
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `link_name` VARCHAR(30) NOT NULL,
    `description` VARCHAR(300) NOT NULL,
    `link_add` VARCHAR(300) NOT NULL,
    `date_uploaded` DATE NOT NULL
);




INSERT INTO `admin`(`username`,`password`)
VALUES
('admin','admin');