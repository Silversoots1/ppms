<?php
require_once ('database.php');
include 'header.php';

class PatientFunctions extends Database
{
    protected function checkDate($date): bool
    {
        $explode_date = explode('-', $date);
        if(count($explode_date) === 3)
        {
            return checkdate($explode_date[1], $explode_date[2], $explode_date[0]);
        } else {
            return false;
        }
    }

    protected function isCreditCardNumber($number): bool
    {
        $strip_number = str_replace(' ', '', $number);

        if(!is_numeric($strip_number))
            return false;
        return strlen($strip_number) === 16;
    }

    protected function checkCreditCardInfo(): bool
    {
        return $this->isCreditCardNumber($_POST["card_number"]) &&
            isset($_POST["cardholder_name"]) &&
            $this->checkDate($_POST["expiration_date"]);
    }

    protected function checkBankAccountInfo(): bool
    {
        return is_numeric($_POST["account_number"]) &&
            is_numeric($_POST["routing_number"]) &&
            isset($_POST["account_holder_name"]);
    }

    protected function checkUserInput(): bool
    {
        return isset($_POST["user_first_name"]) && 
        isset($_POST["user_last_name"]) && 
        isset($_POST["username"]) && 
        isset($_POST["password"]) && 
        isset($_POST["user_date_of_birth"]) &&
        $this->checkDate($_POST["user_date_of_birth"]) &&
        isset($_POST["user_gender"]);
    }

}