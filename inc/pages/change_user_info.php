<?php
include 'header.php';
require_once (getcwd() . '/../inc/patient.php');
require_once (getcwd() . '/../inc/template.php');

class ChangeUserInfo extends template
{
    public function create(): void
    {
        $template = new Patient;

        if(isset($_GET['ssuccess']) && $_GET['ssuccess'] === 'true')
        {
            echo $this->render('change_user_info.html.twig',['user_info' => $_SESSION['user_info']]);

        } else if (isset($_GET['ssuccess']) && $_GET['ssuccess'] === 'false') 
        {
            echo $this->render('change_user_info.html.twig',['error' => 'Incorrect input']);

        } else {
            echo $this->render('change_user_info.html.twig',['user_info' => $template->getPatientInfo()]);
        }
    }
}