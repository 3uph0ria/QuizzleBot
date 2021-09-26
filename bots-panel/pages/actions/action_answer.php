<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';
if($_POST['Correct'] == 'Да') $Correct = 1; else $Correct = 0;

if($_GET['method'] == 'add')
{
// Записываем в БД данные из формы
    $Database->AddAnswer($_POST['IdQuestion'], base64_encode($_POST['Text']), $Correct);
    $_SESSION['alert'] = "Ответ успешно добавлен";
}
else if($_GET['method'] == 'upd')
{
    $Database->UpdAnswer(base64_encode($_POST['Text']), $Correct , $_POST['Id']);
    $_SESSION['alert'] = "Ответ успешно обновлен";
}
else
{
    $Database->DelAnswer($_POST['Id']);
    $_SESSION['alert'] = "Ответ успешно удален";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
