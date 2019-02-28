<?php
/**
 * @param $task_list список задач в виде массива
 * @param $project_name название проекта
 * @return int число задач для переданного проекта
 */
function count_tasks($task_list, $project_name) {
    $count = 0;
    foreach ($task_list as $value) {
        if ($value['categories'] === $project_name) {
            $count++;
        }
    }
    return $count;
}

/**
 * @param $name имя файла шаблона
 * @param $data ассоциативный массив с данными для этого шаблона
 * @return false|string итоговый HTML-код с подставленными данными
 */
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * @param $str данные от польщователя
 * @return string строка, очищенная от опасных спецсимволов
 */
function esc($str) {
    $text = htmlspecialchars($str);
    return $text;
}

/**
 * @param $date дата выполнения задачи
 * @return bool вернет true если осталось меньше или 24 часов до выполнения задачи
 */
function check_burning_tasks($date, $time_limit) {
    if ($date === "Нет") {
        return false;
    }
    $second_in_hour = 3600;
    $date_of_completion = strtotime($date);
    $time_now = time();
    $hours_to_complete = floor(($date_of_completion - $time_now)/$second_in_hour);
    if ($hours_to_complete <= $time_limit) {
        return true;
    } else {
        return false;
    }
}