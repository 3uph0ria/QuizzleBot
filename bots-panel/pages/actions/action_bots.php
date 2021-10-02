<?php

// Подключаем классы
$title = "OCH BOT"; include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/header/action_header.php';

if($_GET['method'] == 'add')
{
// Записываем в БД данные из формы
    $Database->AddBot($_SESSION['userId'], $_POST['TestId'], $_POST['Name'], $_POST['Token'], $_POST['ServerKey']);
    $bots = $Database->GetBots($_SESSION['userId']);
    $_SESSION['alert'] = "Бот успешно добавлен. Это 'http://bots-panel.royal-webhost.ru/vk/bots/bot" . $bots[Count($bots) - 1]['Id'] . "/index.php' нужно вставить поле 'Адрес'";

    mkdir($_SERVER['DOCUMENT_ROOT']."/vk/bots/bot".$bots[Count($bots) - 1]['Id']."/", 0755, true);

    // config
    $fp = fopen($_SERVER['DOCUMENT_ROOT']."/vk/bots/bot".$bots[Count($bots) - 1]['Id']."/config.php", "w+");
    $mytext =
        "<?php
        define('BotId', ".$bots[Count($bots) - 1]['Id'].");";
    $test = fwrite($fp, $mytext);
    fclose($fp);

    // index
    $fp = fopen($_SERVER['DOCUMENT_ROOT']."/vk/bots/bot".$bots[Count($bots) - 1]['Id']."/index.php", "w+");
    $mytext =
        "<?php
        require_once '../bots_code.php';";
    $test = fwrite($fp, $mytext);
    fclose($fp);
}
else if($_GET['method'] == 'upd')
{
    $Database->UpdBot($_POST['TestId'], $_POST['Name'], $_POST['Token'], $_POST['ServerKey'], $_POST['Id']);
    $_SESSION['alert'] = "Бот успешно обновлен. Это 'http://bots-panel.royal-webhost.ru/vk/bots/bot" . $_POST['Id'] . "/index.php' нужно вставить поле 'Адрес'";
}
else
{
    $Database->DelAnswer($_POST['Id']);
    $_SESSION['alert'] = "Бот успешно удален";
}

//Редирект обратно
header("Location: ". $_SERVER['HTTP_REFERER']);
