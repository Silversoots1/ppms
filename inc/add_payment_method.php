<?php
include 'header.php';
require_once ('pages.php');
require_once ('page.php');

class AddPaymentInfo extends pages implements page
{ 
    public function create(): void
    {
        if(isset($_GET['card']) && $_GET['card'] === 'true')
        {
            echo $this->render('add_credit_card.html.twig',[]);

        } else if (isset($_GET['account']) && $_GET['account'] === 'true') 
        {
            echo $this->render('add_bank_account.html.twig',[]);

        } else {
            header("Location: edit_payment_info.php");
        }
    }
}