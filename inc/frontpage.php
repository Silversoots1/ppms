<?php
include 'header.php';
require_once ('pages.php');
require_once ('page.php');

class Frontpage extends pages implements page
{
    public function create(): void
    {
        require_once ('../vendor/autoload.php');
        $loader = new \Twig\Loader\FilesystemLoader('../html');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('frontpage.html.twig',[]);
    }
}