INSERT INTO users
SET name = "Геннадий", email = "Gennadiy@mail.ru", password = "secret1";
INSERT INTO users
SET name = "Константин", email = "Konstantin@mail.ru", password = "secret2";
INSERT INTO users
SET name = "Владимир", email = "Vladimir@mail.ru", password = "secret3";

INSERT INTO projects
SET  user_id = "1", title = "Входящие";
INSERT INTO projects
SET  user_id = "1", title = "Учеба";
INSERT INTO projects
SET  user_id = "1", title = "Работа";
INSERT INTO projects
SET  user_id = "1", title = "Домашние дела";
INSERT INTO projects
SET  user_id = "1", title = "Авто";

INSERT INTO projects
SET  user_id = "2", title = "Входящие";
INSERT INTO projects
SET  user_id = "2", title = "Учеба";
INSERT INTO projects
SET  user_id = "2", title = "Работа";
INSERT INTO projects
SET  user_id = "2", title = "Домашние дела";
INSERT INTO projects
SET  user_id = "2", title = "Авто";

INSERT INTO projects
SET  user_id = "3", title = "Входящие";
INSERT INTO projects
SET  user_id = "3", title = "Учеба";
INSERT INTO projects
SET  user_id = "3", title = "Работа";
INSERT INTO projects
SET  user_id = "3", title = "Домашние дела";
INSERT INTO projects
SET  user_id = "3", title = "Авто";

INSERT INTO tasks
SET  user_id = "1", project_id = "3", name_task = "Собеседование в IT компании", dt_doing = "2019-03-23", status = "0";
INSERT INTO tasks
SET  user_id = "1", project_id = "3", name_task = "Выполнить тестовое задание", dt_doing = "2019-03-25", status = "0";
INSERT INTO tasks
SET  user_id = "1", project_id = "2", name_task = "Сделать задание первого раздела", dt_doing = "2019-03-21", status = "1";
INSERT INTO tasks
SET  user_id = "1", project_id = "1", name_task = "Встреча с другом", dt_doing = "2019-12-22", status = "0";
INSERT INTO tasks
SET  user_id = "1", project_id = "4", name_task = "Купить корм для кота", status = "0";
INSERT INTO tasks
SET  user_id = "1", project_id = "4", name_task = "Заказать пиццу", status = "0";

INSERT INTO tasks
SET  user_id = "2", project_id = "8", name_task = "Собеседование в IT компании", dt_doing = "2019-03-23", status = "0";
INSERT INTO tasks
SET  user_id = "2", project_id = "8", name_task = "Выполнить тестовое задание", dt_doing = "2019-03-25", status = "0";
INSERT INTO tasks
SET  user_id = "2", project_id = "7", name_task = "Сделать задание первого раздела", dt_doing = "2019-03-21", status = "1";
INSERT INTO tasks
SET  user_id = "2", project_id = "6", name_task = "Встреча с другом", dt_doing = "2019-03-22", status = "0";
INSERT INTO tasks
SET  user_id = "2", project_id = "9", name_task = "Купить корм для кота", status = "0";

INSERT INTO tasks
SET  user_id = "3", project_id = "13", name_task = "Собеседование в IT компании", dt_doing = "2019-03-08", status = "0";
INSERT INTO tasks
SET  user_id = "3", project_id = "12", name_task = "Сделать задание первого раздела", dt_doing = "2019-03-05", status = "1";
INSERT INTO tasks
SET  user_id = "3", project_id = "11", name_task = "Встреча с другом", dt_doing = "2019-03-05", status = "0";
INSERT INTO tasks
SET  user_id = "3", project_id = "14", name_task = "Заказать пиццу", status = "0";
INSERT INTO tasks
SET  user_id = "3", project_id = "15", name_task = "Визит в автосервис", status = "0";

-- вывести все названия проектов пользователя
SELECT projects.title FROM projects WHERE projects.user_id = "1";
-- вывести все задачи пользователя Геннадий, относящиеся к проекту Входящие
SELECT tasks.name_task FROM tasks WHERE tasks.user_id = "1" and tasks.project_id = "1";
-- отметить задачу Собеседование пользователя Владимир как выполненную
UPDATE tasks SET tasks.status = "1" WHERE tasks.id = "1" and user_id = "1";
-- вывести названия задач на завтра
SELECT tasks.name_task FROM tasks WHERE tasks.dt_doing BETWEEN NOW() + INTERVAL 1 DAY AND NOW() + INTERVAL 2 DAY;
-- обновить имя задачи по ее идентификатору
UPDATE tasks SET tasks.name_task = "Проверка" WHERE tasks.id = "3";