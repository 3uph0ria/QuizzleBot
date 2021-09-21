<?php
session_start();
if(isset($_SESSION['userId']) == false)
{
    header('Location: /bots-panel/login/');
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/configs/project-config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/bots-panel/include/classes/Database.php';
$Database = new Database();
