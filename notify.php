<?php
require_once('vendor/autoload.php');
require_once('data.php');
require_once('function.php');
require_once('config.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$sql_get_task_list_today = "SELECT * FROM tasks WHERE dt_doing > DATE_SUB(CURDATE(), INTERVAL 1 day) AND dt_doing 
< DATE_ADD(CURDATE(), INTERVAL 1 day) ORDER BY dt_doing DESC";

$date = date(d.m.Y);
$result = mysqli_query($link, $sql_get_task_list_today);
if ($result && mysqli_num_rows($result)) {
    $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $user_list = [];
    foreach ($task_list as $task) {
        $user_list[] = $task['user_id'];
    }
    foreach ($user_list as $user) {
        $sql_get_user_email_and_name = "SELECT email, name FROM users WHERE id = $user";
        $res = mysqli_query($link, $sql_get_user_email_and_name);
        $user_email_and_name = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $sql_get_user_task_list = "SELECT * FROM tasks WHERE user_id = $user and dt_doing > DATE_SUB(CURDATE(), INTERVAL 1 day) 
        AND dt_doing < DATE_ADD(CURDATE(), INTERVAL 1 day) ORDER BY dt_doing DESC";
        $res_task = mysqli_query($link, $sql_get_user_task_list);
        $user_task_list = mysqli_fetch_all($res_task, MYSQLI_ASSOC);

        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'DoingDone']);
        $message->setBcc($user_email_and_name[0]['email']);

        $msg_content = include_template('email.php', [
            'date' => $date,
            'task_list' => $task_list,
            'user' => $user_email_and_name[0]['name'],
        ]);
        $message->setBody($msg_content, 'text/plain');

        $result_email = $mailer->send($message);
        if ($result_email) {
            print("Рассылка успешно отправлена пользователю: ".$user_email_and_name[0]['name'])."<br>";
        }
        else {
            print("Не удалось отправить рассылку пользователю: ". $user_email_and_name[0]['name'])."<br>";
        }
    }
}




















//    $res = mysqli_query($link, "SELECT email, name FROM users");
//
//    if ($res && mysqli_num_rows($res)) {
//        $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
//        $recipients = [];
//
//        foreach ($users as $user) {
//            $recipients[$user['email']] = $user['name'];
//        }
//
//        $message = new Swift_Message();
//        $message->setSubject("Самые горячие гифки за этот месяц");
//        $message->setFrom(['keks@phpdemo.ru' => 'GifTube']);
//        $message->setBcc($recipients);
//
//        $msg_content = include_template('month_email.php', ['gifs' => $gifs]);
//        $message->setBody($msg_content, 'text/html');
//
//        $result = $mailer->send($message);
//
//        if ($result) {
//            print("Рассылка успешно отправлена");
//        }
//        else {
//            print("Не удалось отправить рассылку: " . $logger->dump());
//        }
//    }
//}