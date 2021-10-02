<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

if($_GET['method'] == 'add')
{
// Записываем в БД данные из формы
    $Database->AddTest($_POST['IdUserPanel'], $_POST['Name']);
    $_SESSION['alert'] = "Тест успешно создан";
}

if($_GET['method'] == 'updRedirect')
{
// Записываем в БД данные из формы
    $Database->UpdRedirectTest($_POST['TextRedirect'], $_POST['Redirect'], $_POST['IdTest']);
    $_SESSION['alert'] = "Сообщение успешно обновлено";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
