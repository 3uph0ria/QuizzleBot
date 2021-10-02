<?
$time = microtime(true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/tgLib.php');
require_once('config.php');
$Database = new Database();

$bot = new tgBot(TOKEN);
$data = json_decode(file_get_contents('php://input'),true);
$message = mb_strtolower($data['message']['text'], 'utf-8');
$chat_id = $data['message']['chat']['id'];
$peer_id = $data['message']['from']['id'];
$username = $data['message']['from']['username'];
$first_name = $data['message']['from']['first_name'];

$test = $Database->GetTest(1);
$question = $Database->GetQuestions(1);
$trans = array("!" => " ", "@" => " ", "#" => " ", "$" => " ", "%" => " ", "^" => " ", "&" => " ", "*" => " ", "(" => " ", ")" => " ", "_" => " ", "+" => " ", "<td>" => "", "'" => "", "`" => "");


if($message)
{
    $user = $Database->GetUser($peer_id, 1);
    if(!$user)
    {
        $Database->AddUser(1, $peer_id, 'test', $first_name, 'tg', $username);
        $bot->reply($peer_id,
            'Здравствуйте' . "\n" . 'Тебе дается 4 варианта ответа'  . "\n" . 'выбери тот который считаешь нужным'  . "\n" . 'для ответа напиши цифру от 1 до 4');
    }

    if($message > 0 && $message < 5)
    {
        if(is_numeric($message))
        {
            for($i = 0; $i < Count($question); $i++)
            {
                $userQuestion = $Database->GetUserQuestion($user['Id'], $question[$i]['Id']);
                if(!$userQuestion)
                {
                    $answers = $Database->GetAnswers($question[$i]['Id']);
                    $Database->AddUserResult($user['Id'], 1, $question[$i]['Id'], $answers[$message - 1]['Id'], date('Y-m-d H:i:s'), 1);
                    break;
                }
            }
        }
    }

    for($i = 0; $i < Count($question); $i++)
    {
        $userQuestion = $Database->GetUserQuestion($user['Id'], $question[$i]['Id']);
        if(!$userQuestion)
        {
            $answers = $Database->GetAnswers($question[$i]['Id']);
            $alert = base64_decode($question[$i]['Text']) . "\n";
            for($j = 0; $j < Count($answers); $j++)
            {
                $alert .= base64_decode($answers[$j]['Text']) . "\n";
            }
            break;
        }
    }

    if(!$alert)
    {
        $result = $Database->GetUserResult($user['Id']);
        $bot->reply($peer_id, $user['FullName'] . ', Вы успешно прошли тест' . "\n" . 'Результат: ' . $result['SUM(Answers.Correct)'] . '/' . $result['COUNT(UserResults.Id)'] . ' баллов' . "\n" . $test['TextRedirect'] . "\n" . $test['Redirect']);
    }
    else
    {
        $bot->reply($peer_id, trim(strtr($alert, $trans)));
    }
}

exit('ok');
