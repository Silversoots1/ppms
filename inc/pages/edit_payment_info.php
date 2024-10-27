<?php
include 'header.php';

require_once (getcwd() . '/../inc/patient.php');
require_once (getcwd() . '/../inc/template.php');

class EditPaymentInfo extends Template
{
    public function create(): void
    {
        $template = new Patient;

        if (isset($_GET['ssuccess']) && $_GET['ssuccess'] === 'false')
        {
            echo $this->render('edit_payment_info.html.twig',[
                'error' => 'Incorrect input'
            ]);

        } else {
            echo $this->render('edit_payment_info.html.twig',[
                'credit_cards' => $template->displayCreditCards(),
                'bank_accounts' => $template->displayBankAccounts()
            ]);

        }
    }
}