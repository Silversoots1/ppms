<?php
include 'header.php';
require_once ('pages.php');
require_once ('page.php');

class EditPaymentInfo extends pages implements page
{ 
    public function create(): void
    {
        if(isset($_GET['ssuccess']) && $_GET['ssuccess'] === 'true')
        {
            echo $this->render('edit_payment_info.html.twig',['user_info' => $_SESSION['user_info']]);

        } else if (isset($_GET['ssuccess']) && $_GET['ssuccess'] === 'false') 
        {
            echo $this->render('edit_payment_info.html.twig',['error' => 'Incorrect input']);

        } else {
            echo $this->render('edit_payment_info.html.twig',[]);

        }
    }
}