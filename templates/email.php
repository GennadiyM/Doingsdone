<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h1> Уважаемый,  <?=esc($user['name'])?>. У вас запланирована задача на <?=$date?></h1>
    <p>Предлагаем вашему вниманию три самых популярных гифки, добавленные за этот месяц:</p>
    <table>
        <?php foreach($task_list as $item) : ?>
            <tr>
                <td>
                    <?=esc($item['name_task'])?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>