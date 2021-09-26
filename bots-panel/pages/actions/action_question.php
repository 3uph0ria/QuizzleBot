<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

if($_GET['method'] == 'add')
{
// Записываем в БД данные из формы
    $Database->AddQuestion($_POST['IdTest'], base64_encode($_POST['Text']), $_POST['Score'], $_POST['Img']);
    $_SESSION['alert'] = "Вопрос успешно добавлен";
}
else if($_GET['method'] == 'upd')
{
    // Записываем в БД данные из формы
    $Database->UpdQuestion(base64_encode($_POST['Text']), $_POST['Score'], $_POST['Img'], $_POST['Id']);
    $_SESSION['alert'] = "Вопрос успешно изменен";
}
else
{
    // Записываем в БД данные из формы
    $Database->DelQuestion($_POST['Id']);
    $_SESSION['alert'] = "Вопрос успешно удален";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
