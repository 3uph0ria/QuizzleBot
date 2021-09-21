<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

if($_GET['method'] == 'add')
{
// Записываем в БД данные из формы
    $Database->AddAnswer($_POST['IdQuestion'], $_POST['Text'], $_POST['Correct']);
    $_SESSION['alert'] = "Ответ успешно добавлен";
}
else if($_GET['method'] == 'upd')
{
    $Database->UpdAnswer($_POST['Text'], $_POST['Correct'] , $_POST['Id']);
    $_SESSION['alert'] = "Ответ успешно обновлен";
}
else
{
    $Database->DelAnswer($_POST['Id']);
    $_SESSION['alert'] = "Ответ успешно удален";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
