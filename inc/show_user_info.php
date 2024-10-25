<?php
include 'header.php';
require_once ('pages.php');
require_once ('page.php');

class ShowUserInfo extends pages implements page
{
    // public function showError(): void
    // {
    //     echo $this->render('change_user_info.html.twig',[]);
    // }

    public function create($error = null): void
    {
        echo $this->render('change_user_info.html.twig',['error' => $error]);
    }
}