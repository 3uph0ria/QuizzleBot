<?
$time = microtime(true);
include '../class/tgLib.php';
include '../class/Database.php';
$Database = new Database();

$bot = new tgBot('1490312113:AAETSP0x6olyFFVh91pcm9xg--WMIpPzq9g');
$data = json_decode(file_get_contents('php://input'),true);
$text = mb_strtolower($data['message']['text'], 'utf-8');
$chat_id = $data['message']['chat']['id'];
$from_id = $data['message']['from']['id'];
$first_name = $data['message']['from']['first_name'];

if($text)
{
    $user = $Database->GetUser($from_id);
    if($user)
    {
        $quizzle = $Database->GetQuizzle(); // Получаем тесты
        $questions = $Database->GetQuestions($quizzle['id']); // Вопросы
        for($i = 0; $i < Count($questions); $i++)
        {
            // Проверяем ответил ли пользователь на этот вопрос
            $check = $Database->GetQuizzleUsers($questions[$i]['id']);
            if(!$check)
            {
                $botQuestion = $questions[$i]['question'] . "\n";
                $answers = $Database->GetAnswers($questions[$i]['id']); // Получаем ответы

                if($text == 'начать')
                {
                    for($j = 0; $j < Count($answers); $j++)
                    {
                        $botQuestion .= $j + 1 . $answers[$j]['answer'] . "\n";
                    }
                    $bot->reply($from_id,   $botQuestion);
                    exit;
                }

                if(is_numeric($text))
                {
                    if($text <= Count($answers))
                    {
                        $Database->AddQuizzleUsers($questions[$i]['id'], $answers[$text - 1]['id'], $user['id'], date('Y-m-d'));

                        $botQuestion = $questions[$i + 1]['question'] . "\n";
                        if($questions[$i + 1]['id'])
                        {
                            $answers = $Database->GetAnswers($questions[$i + 1]['id']); // Получаем новый вопрос
                            for($j = 0; $j < Count($answers); $j++)
                            {
                                $botQuestion .= $j + 1 . $answers[$j]['answer'] . "\n";
                            }
                            $bot->reply($from_id, $botQuestion);
                            exit;
                        }
                        else
                        {
                            $rightAnswers = $Database->RightAnswers($user['id']);
                            $bot->reply($from_id,   $first_name . ', Вы успешно прошли тест правильных ответов ' . $rightAnswers['SUM(answers.answer_right)'] . '/' .  $rightAnswers['SUM(answers.score)']);
                            exit;
                        }
                    }
                    else
                    {
                        $bot->reply($from_id,   'Такого варианта ответа нету');
                    }
                }
                else
                {
                    $bot->reply($from_id,   'Ответ должен быть цифрой');
                }

                for($j = 0; $j < Count($answers); $j++)
                {
                    $botQuestion .= $j + 1 . $answers[$j]['answer'] . "\n";
                }
                $bot->reply($from_id,   $botQuestion);
                exit;
            }
        }
        $rightAnswers = $Database->RightAnswers($user['id']);
        $bot->reply($from_id,   $first_name . ', Вы успешно прошли тест правильных ответов ' . $rightAnswers['SUM(answers.answer_right)'] . '/' .  $rightAnswers['SUM(answers.score)']);
    }
    else
    {
        $Database->AddUser($from_id, $first_name);
        $bot->reply($from_id, $first_name  . ' Вас приветствует компания ..' . "\n" . 'Сейчас начнется тестированием, Вам нужно выбрать один из варинтов ответа, ответ должен быть цифрой' . "\n" . 'Для начала тестирования напишите команду "Начать"');
    }
}

exit('ok');