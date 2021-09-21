<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

if($_GET['method'] == 'del')
{
// Записываем в БД данные из формы
    $Database->DelUserResult($_POST['Id']);
    $_SESSION['alert'] = "Результат успешно удален";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
