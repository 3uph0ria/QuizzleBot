<?php

class Database
{
    private $link;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * @return $this
     */
    private function connect()
    {
        $config = require_once 'config_bd.php';
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['dbName'].';charset='.$config['charset'];
        $this->link = new PDO($dsn, $config['userName'], $config['password']);

        return $this;
    }

    //============================= Users ================================//
    public function GetUser($fromId)
    {
        $user =  $this->link->prepare("SELECT * FROM `users` WHERE `from_id` = ?");
        $user->execute(array($fromId));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function AddUser($fromId, $firstName)
    {
        $user = $this->link->prepare("INSERT INTO `users`(`from_id`, `first_name`) VALUES(?, ?)");
        $user->execute(array($fromId, $firstName));
    }

    //============================= Quizzle ================================//
    public function GetQuizzle()
    {
        $user =  $this->link->query("SELECT * FROM `quizzle`");
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    //============================= questions ================================//
    public function GetQuestions($idQuizzle)
    {
        $chatWeekStatsAll = $this->link->prepare("SELECT * FROM `questions` WHERE `quizzle_id` = ?");
        $chatWeekStatsAll->execute(array($idQuizzle));
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    //============================= questions ================================//
    public function GetAnswers($questionId)
    {
        $chatWeekStatsAll = $this->link->prepare("SELECT * FROM `answers` WHERE `question_id` = ?");
        $chatWeekStatsAll->execute(array($questionId));
        while ($chatWeekStatsRow = $chatWeekStatsAll->fetch(PDO::FETCH_ASSOC))
        {
            $chatWeekStats[] = $chatWeekStatsRow;
        }
        return $chatWeekStats;
    }

    //============================= quizzleUsers ================================//
    public function GetQuizzleUsers($quizzleUsersId)
    {
        $user =  $this->link->prepare("SELECT * FROM `quizzleUsers` INNER JOIN questions WHERE questions.id = quizzleUsers.question_id AND  quizzleUsers.question_id = ?");
        $user->execute(array($quizzleUsersId));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function RightAnswers($userId)
    {
        $user =  $this->link->prepare("SELECT SUM(answers.score), SUM(answers.answer_right) FROM `quizzleUsers` INNER JOIN questions INNER JOIN answers WHERE questions.id = quizzleUsers.question_id AND answers.id = quizzleUsers.answer_id AND quizzleUsers.user_id = ?");
        $user->execute(array($userId));
        return $user->fetch(PDO::FETCH_ASSOC);
    }

    public function AddQuizzleUsers($questionId, $answerId, $userId, $date)
    {
        $user = $this->link->prepare("INSERT INTO `quizzleUsers`(`question_id`, `answer_id`, `user_id`, `date_answer`) VALUES(?, ?, ?, ?)");
        $user->execute(array($questionId, $answerId, $userId, $date));
    }
}