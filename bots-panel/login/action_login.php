<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


session_start();
spl_autoload_register(function ($class_name)
{
    include $_SERVER['DOCUMENT_ROOT'].'/bots-panel/include/classes/'.$class_name.'.php';
});

$Database = new Database();

// Получаем данные из формы
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

// Получаем данные о пользователях с таким же логином
$user = $Database->GetPanelUser($login);

// Проверяем соответствует ли пароль хешу
if (password_verify($password, $user['Password'])) {

    $_SESSION['userId'] = $user['Id'];
    $_SESSION['userLogin'] = $user['Login'];

    header('Location: /bots-panel/');

} else {

    // Создаем сообщение и делаем редикрет
		$_SESSION['bedMessage'] = "Неверный логин или пароль";
    header('Location: /bots-panel/login/');
}
