CREATE DATABASE doingDone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingDone;

CREATE TABLE `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` char(128 ) NOT NULL,
	`email` char(128) NOT NULL UNIQUE,
	`password` char(64) NOT NULL,
	`dt_add` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);

CREATE TABLE `tasks` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`project_id` int NOT NULL,
	`name_task` char(128) NOT NULL,
	`dt_create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`dt_doing` DATE,
	`status` tinyint(1) NOT NULL,
	`path` char(255),
	`dt_term` DATETIME,
	FULLTEXT (name_task),
	PRIMARY KEY (`id`)
);

CREATE TABLE `projects` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`title` char(128) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

ALTER TABLE `tasks` ADD CONSTRAINT `tasks_fk1` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`);

ALTER TABLE `projects` ADD CONSTRAINT `projects_fk0` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);

