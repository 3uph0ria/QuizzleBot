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

    public function GetPanelUser($login)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `PanelUsers` WHERE `login` = ?");
        $botUser->execute(array($login));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function GetUserResult($IdUser)
    {
        $botUser =  $this->link->prepare("SELECT COUNT(UserResults.Id), SUM(Answers.Correct) FROM UserResults INNER JOIN Answers WHERE UserResults.IdUser = ? AND UserResults.IdAnswer = Answers.Id");
        $botUser->execute(array($IdUser));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function GetUserResults($IdPanelUser)
    {
        $botUserAll = $this->link->query("SELECT Users.Id, Users.Platform, Users.TgName, Users.FullName, Users.Photo, Users.PeerId, COUNT(UserResults.Id), SUM(Answers.Correct), Tests.Name, UserResults.Date FROM `UserResults` INNER JOIN Answers INNER JOIN Users INNER JOIN Tests INNER JOIN Bots WHERE `IdPanelUser` = $IdPanelUser AND Users.Id = UserResults.IdUser AND UserResults.IdAnswer = Answers.Id AND Tests.Id = UserResults.IdTest GROUP BY UserResults.IdUser");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function GetTests($IdUser)
    {
        $botUserAll = $this->link->query("SELECT * FROM `Tests` WHERE `IdUser` = $IdUser");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function GetTest($IdTest)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `Tests` WHERE `Id` = ?");
        $botUser->execute(array($IdTest));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function GetBots($IdUser)
    {
        $botUserAll = $this->link->query("SELECT * FROM `Bots` WHERE `IdUserPanel` = $IdUser");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function GetBot($Id)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `Bots` WHERE `Id` = ?");
        $botUser->execute(array($Id));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function UpdRedirectTest($TextRedirect, $Redirect, $IdTest)
    {
        $addUser = $this->link->prepare("UPDATE `Tests` SET `TextRedirect` = ?, `Redirect` = ? WHERE `id` = ?");
        $addUser->execute(array($TextRedirect, $Redirect, $IdTest));
    }

    public function UpdResultViewed($idUser)
    {
        $addUser = $this->link->prepare("UPDATE `Users` SET `ResultViewed` = 1 WHERE `Id` = ?");
        $addUser->execute(array($idUser));
    }

    public function GetQuestions($IdTest)
    {
        $botUserAll = $this->link->query("SELECT * FROM `Questions` WHERE `IdTest` = $IdTest");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function GetAnswers($IdQuestion)
    {
        $botUserAll = $this->link->query("SELECT * FROM `Answers` WHERE `IdQuestion` = $IdQuestion");
        while ($botUser = $botUserAll->fetch(PDO::FETCH_ASSOC))
        {
            $botUserReturn[] = $botUser;
        }
        return $botUserReturn;
    }

    public function AddTest($IdUser, $name)
    {
        $addUser = $this->link->prepare("INSERT INTO `Tests` (`IdUser`, `Name`) VALUES (?, ?)");
        $addUser->execute(array($IdUser, $name));
    }

    public function AddBot($IdUser, $TestId, $Name, $Token, $ServerKey)
    {
        $addUser = $this->link->prepare("INSERT INTO `Bots` (`IdUserPanel`, `TestId`, `Name`, `Token`, `ServerKey`, `Platform`) VALUES (?, ?, ?, ?, ?, 'vk')");
        $addUser->execute(array($IdUser, $TestId, $Name, $Token, $ServerKey));
    }

    public function UpdBot($TestId, $Name, $Token, $ServerKey, $Id)
    {
        $addUser = $this->link->prepare("UPDATE `Bots` SET `TestId` = ?, `Name` = ?, `Token` = ?, `ServerKey` = ? WHERE `Id` = ?");
        $addUser->execute(array($TestId, $Name, $Token, $ServerKey, $Id));
    }



    public function GetUser($PeerId, $BotId)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `Users` WHERE `PeerId` = ? AND `IdBot` = ?");
        $botUser->execute(array($PeerId, $BotId));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function GetUserQuestion($UserId, $AnswerId)
    {
        $botUser =  $this->link->prepare("SELECT * FROM `UserResults` WHERE `IdUser` = ? AND `IdQuestion` = ?");
        $botUser->execute(array($UserId, $AnswerId));
        return $botUser->fetch(PDO::FETCH_ASSOC);
    }

    public function AddUserResult($IdUser, $IdTest, $IdQuestion, $IdAnswer, $Date, $IdUserPanel)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $addUser = $this->link->prepare("INSERT INTO `UserResults` (`IdUser`, `IdTest`, `IdQuestion`, `IdAnswer`, `Date`, `IdPanelUser`) VALUES (?, ?, ?, ?, ?, ?)");
        $addUser->execute(array($IdUser, $IdTest, $IdQuestion, $IdAnswer, $Date, $IdUserPanel));
    }

    public function DelUserResult($Id)
    {
        $addUser = $this->link->prepare("DELETE FROM `UserResults` WHERE `IdUser` = ?");
        $addUser->execute(array($Id));

        $addUser = $this->link->prepare("DELETE FROM `Users` WHERE `Id` = ?");
        $addUser->execute(array($Id));
    }

    public function AddUser($IdBot, $PeerId, $Photo, $FillName, $Platform, $TgName)
    {
        $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($TgName)
        {
            $addUser = $this->link->prepare("INSERT INTO `Users` (`IdBot`, `PeerId`, `Photo`, `FullName`, `Platform`, `TgName`, `ResultViewed`) VALUES (?, ?, ?, ?, ?, ?, 0)");
            $addUser->execute(array($IdBot, $PeerId, $Photo, $FillName, $Platform, $TgName));
        }
        else
        {
            $addUser = $this->link->prepare("INSERT INTO `Users` (`IdBot`, `PeerId`, `Photo`, `FullName`, `Platform`, `ResultViewed`) VALUES (?, ?, ?, ?, ?, 0)");
            $addUser->execute(array($IdBot, $PeerId, $Photo, $FillName, $Platform));
        }
    }

    public function AddAnswer($IdQuestion, $Text, $Correct)
    {
        $addUser = $this->link->prepare("INSERT INTO `Answers` (`IdQuestion`, `Text`, `Correct`) VALUES (?, ?, ?)");
        $addUser->execute(array($IdQuestion, $Text, $Correct));
    }

    public function UpdAnswer($Text, $Correct, $Id)
    {
        $addUser = $this->link->prepare("UPDATE `Answers` SET `Text` = ?, `Correct` = ? WHERE `id` = ?");
        $addUser->execute(array($Text, $Correct, $Id));
    }

    public function DelAnswer($Id)
    {
        $addUser = $this->link->prepare("DELETE FROM `Answers` WHERE `id` = ?");
        $addUser->execute(array($Id));
    }


    public function AddQuestion($IdTest, $Text, $Score, $Img)
    {
        $addUser = $this->link->prepare("INSERT INTO `Questions` (`IdTest`, `Text`, `Score`, `Img`) VALUES (?, ?, ?, ?)");
        $addUser->execute(array($IdTest, $Text, $Score, $Img));
    }

    public function UpdQuestion($Text, $Score, $Img, $Id)
    {
        $addUser = $this->link->prepare("UPDATE `Questions` SET `Text` = ?, `Score` = ?, `Img` = ? WHERE `id` = ?");
        $addUser->execute(array($Text, $Score, $Img, $Id));
    }

    public function DelQuestion($Id)
    {
        $addUser = $this->link->prepare("DELETE FROM `Questions` WHERE `id` = ?");
        $addUser->execute(array($Id));
    }

}
