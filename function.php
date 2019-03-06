<?php
/**
 * Подключает шаблон, находящийся в заданной директории
 *
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
 * Преобразует специальные символы в HTML-сущности
 *
 * @param $str данные от польщователя
 * @return string строка, очищенная от опасных спецсимволов
 */
function esc($str) {
    $text = htmlspecialchars($str);
    return $text;
}

/**
 * Сравнивает время оставщееся до выполнения задачи с заданным лимитом времени
 *
 * @param $date дата выполнения задачи
 * @return bool вернет true если осталось меньше или равное лимиту число часов до выполнения задачи
 */
function check_burning_tasks($date, $time_limit) {
    if ($date === null) {
        return false;
    }
    $second_in_hour = 3600;
    $date_of_completion = strtotime($date);
    $time_now = time();
    $hours_to_complete = floor(($date_of_completion - $time_now)/$second_in_hour);
    if ($hours_to_complete <= $time_limit) {
        return true;
    }
    return false;
}

/**
 * Устанавливает соединение с бд
 *
 * @param $data_base информация для подключения
 * @return mysqli ресурс соединения
 * @throws Exception если соединение не установлено вызовет исключение
 */
function getConnection($data_base){
    $con = mysqli_connect($data_base['host'], $data_base['user'], $data_base['password'], $data_base['database']);
    if (!$con) {
        throw new Exception("Ошибка MySQL");
    }
    mysqli_set_charset($con, "utf-8");
    return $con;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

/**
 * Получение записей из БД
 *
 * @param $link ресурс соединения
 * @param $sql sql запрос
 * @param array $data массив со значениями
 * @return array|null
 */
function db_fetch_data($link, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

/**
 * Преобразует дату полученную из БД в другой формат, ecли дата не задана вернет пустую строку
 *
 * @param $string_data дата, полученая из БД
 * @return false|string преобразованная дата
 */
function date_arr_in_date_str($string_data){
    if (is_null($string_data)) {
        return '';
    }
    $int_end_str = date_create($string_data);
    return date_format($int_end_str, "d.m.Y");
}

/**
 * Возвращает уникальное имя файла с учетом его расширения
 *
 * @param $file_type тип загружаемого файла
 * @return string уникальное название загружаемого файла и расширение
 */
function getFileName($file_type){
    if ($file_type == "text/plain") {
        return uniqid() . '.txt';
    }
    return uniqid() . "." . pathinfo($_FILES['doc']['name'])['extension'];
}

/**
 * Добавление новой записи в БД
 *
 * @param $link ресурс соединения
 * @param $sql sql запрос
 * @param array $data массив со значениями
 * @return bool|int|string id последней записи
 */
function db_insert_data($link, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($link);
    }
    return $result;
}

/**
 *
 * Проверяет в базе данных наличи проекта у пользователя, если проекта не будет вернет код ответа 404
 *
 * @param $link ресурс соединения
 * @param $sql_existence_check_tab_in_bd - sql запрос на проверку наличия в бд
 * @param $user_id id пользователя
 * @param $project_id id проекта
 */
function verification_existence_project($link,$sql_existence_check_tab_in_bd, $user_id, $project_id) {
    $result_existence_check_tab_in_bd = db_fetch_data($link, $sql_existence_check_tab_in_bd, [$user_id, $project_id]);
    if ($result_existence_check_tab_in_bd[0]['result_check'] == 0) {
        http_response_code(404);
        echo '404 Not Found';
        exit;
    }
}
