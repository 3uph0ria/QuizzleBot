<?php

//$start = microtime(true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/vk.php');
require_once('config.php');
$Database = new Database();
$vkRequest = new vk();

//$botUser = $Database->SelectBotUser(userLogin);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/simplevk/autoload.php'); // Подключение библиотеки

use DigitalStar\vk_api\VK_api as vk_api; // Основной класс
use DigitalStar\vk_api\VkApiException; // Обработка ошибок

$vk = vk_api::create(TOKEN, VERSION)->setConfirm(KEY);

$data = json_decode(file_get_contents('php://input')); //Получает и декодирует JSON пришедший из ВК

if($_POST['mailingText'])
{
    $users = $Database->GetBotUsers(userId);
    for($i = 0; $i < Count($users); $i++)
    {
        $vk->sendMessage($users[$i]['peer_id'], $_POST['mailingText']);
    }
    header('Location: https://gs-och.ru/bots-panel/pages/mailing.php');
}

$vk->sendOK(); //Говорим vk, что мы приняли callback

$message = $data->object->message->text;
$button = json_decode($data->object->message->payload);
$peer_id = $data->object->message->peer_id;

if($message)
{
    $vk->sendMessage($peer_id, 'test');

    $user = $Database->GetUser($peer_id, 1);
    if(!$user)
    {
        $searchUser = $vkRequest->request("users.get", ["user_ids" => $peer_id, "fields" => "photo_50"]);
        $Database->AddUser(1, $peer_id, $searchUser[0]['photo_50'], $searchUser[0]['first_name'] . '' . $searchUser[0]['last_name']);
    }

    if($button->command && $message != 'начать')
    {
        $tmp = explode('_', $button->command);
        $IdQuestion = $tmp[1];
        $IdAnswer = $tmp[2];

        $Database->AddUserResult($user['Id'], 1, $IdQuestion, $IdAnswer, date('Y-m-d H:i:s'), 1);
    }

    $question = $Database->GetQuestions(1);

    for($i = 0; $i < Count($question); $i++)
    {
        $userQuestion = $Database->GetUserQuestion($user['Id'], $question[$i]['Id']);
        if(!$userQuestion)
        {
            $answers = $Database->GetAnswers($question[$i]['Id']);
            for($j = 0; $j < Count($answers); $j++)
            {
                $alert = $question[$i]['Text'];
                $commends[$j][0] = $vk->buttonText($answers[$j]['Text'], "white", ['command' => 'btn_' . $question[$i]['Id'] . '_' . $answers[$j]['Id']]);
            }
            break;
        }
    }

    if(!$commends)
    {
        $result = $Database->GetUserResult($user['Id']);
        $vk->sendMessage($peer_id, $user['FullName'] . ', Вы успешно прошли тест' . "\n" . 'Результат: ' . $result['SUM(Answers.Correct)'] . '/' . $result['COUNT(UserResults.Id)'] . ' баллов' . "\n" . 'Приглашаем Вас в наш канал ... сссылка');
    }

    if($alert) $buttonMessage = $alert;
    else $buttonMessage = 'выберите действие';
    $vk->sendButton($peer_id, $buttonMessage, $commends);
}
