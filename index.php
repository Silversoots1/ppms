<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once ('vendor/autoload.php');
require_once ('config_session.php');


$loader = new \Twig\Loader\FilesystemLoader('html');
$twig = new \Twig\Environment($loader);
if(isset($_SESSION['user_id']))
{
    header("Location: pages/frontpage.php");
} else {
    echo $twig->render('header.html.twig',[]);
    echo $twig->render('login.html.twig',[]);
}


?>