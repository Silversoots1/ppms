<?php
require_once ('patient_functions.php');
include 'header.php';

require_once (getcwd() . '/../inc/payment/credit_card.php');
require_once (getcwd() . '/../inc/payment/ach.php');

use PaymentMethod\CreditCard;
use PaymentMethod\ACH;

class Patient extends PatientFunctions
{
    private $first_name;
    private $last_name;
    private $date_of_birth;
    private $gender;
    private $address;

    public function getPatientInfo(): array
    {
        $query = sprintf('
            SELECT 
                user_id,
                username, 
                first_name, 
                last_name, 
                date_of_birth, 
                gender, 
                address 
            FROM 
                users
            WHERE
                user_id = %d',
            $_SESSION['user_id']);
                
        return $this->readFromDatabase($query)[0];
    }

    public function setPatientInfo(): void
    {
        $patient_data = $this->getPatientInfo();
        $this->first_name = $patient_data['first_name'];
        $this->last_name = $patient_data['last_name'];
        $this->date_of_birth = $patient_data['date_of_birth'];
        $this->gender = $patient_data['gender'];
        $this->address = $patient_data['address'];
    }

    public function addCreditCard(): bool
    {
        if(!$this->checkCreditCardInfo())
            return false;

        $query = sprintf('
            insert into credit_card(user_id, username, card_number, cardholder_name, expiration_date)
            VALUES("%s", "%s", "%s", "%s", "%s");',
            $_SESSION["user_id"],
            $_SESSION["username"],
            htmlspecialchars($_POST["card_number"]),
            htmlspecialchars($_POST["cardholder_name"]),
            $_POST["expiration_date"]
        );

        $database = new Database;
        $database->writeToDatabase($query);

        return true;
    }

    public function addBankAccount(): bool
    {
        if(!$this->checkBankAccountInfo())
            return false;
        
        $query = sprintf('
            insert into bank_account(user_id, username, account_number, routing_number, accountholder_name)
            VALUES("%s", "%s", "%s", "%s", "%s");',
            $_SESSION["user_id"],
            $_SESSION["username"],
            $_POST["account_number"],
            $_POST["routing_number"],
            htmlspecialchars($_POST["account_holder_name"])
        );

        $database = new Database;
        $database->writeToDatabase($query);

        return true;
    }

    public function getCreditCards(): array
    {
        $credit_card_query = sprintf('
            SELECT 
                *
            FROM 
                credit_card
            WHERE
                credit_card.user_id = %1$d',
            $_SESSION['user_id']);

        return $this->readFromDatabase($credit_card_query);
    }

    public function displayCreditCards(): array
    {
        $cards = $this->getCreditCards();
        $result = [];

        foreach($cards as $card)
        {
            if(!isset($card['expiration_date']))
                continue;

            $CreditCard = new CreditCard(
                $card['card_number'],
                $card['expiration_date'],
                $card['cardholder_name'],
                $card['status']
            );

            $explode_date = explode('-', $card['expiration_date']);

            $result[] = sprintf('Payment Method: CreditCard | Masked Number: **** **** **** %s (%d/%d) | Status: %s',
            $CreditCard->getMaskedCardNumber(),
            $explode_date[1],
            $explode_date[0],
            $CreditCard->isActive($card['status']) ? 'Active' : 'Inactive'
            );
        }

        return $result;
    }

    public function getBankAccounts(): array
    {
        $bank_account_query = sprintf('
            SELECT 
                *
            FROM 
                bank_account
            WHERE
                bank_account.user_id = %1$d',
            $_SESSION['user_id']);

        return $this->readFromDatabase($bank_account_query);
    }

    public function displayBankAccounts(): array
    {
        $cards = $this->getBankAccounts();
        $result = [];

        foreach($cards as $card)
        {
            $ach = new ACH(
                $card['account_number'],
                $card['routing_number'],
                $card['accountholder_name']
            );
            
            $account_number_len =  strlen($card['account_number']);
            $masked_account_number = substr($card['account_number'], $account_number_len -4, $account_number_len);

            $result[] = sprintf('Payment Method: ACH | Masked Number: *********%s | Status: %s',
            $masked_account_number,
            $ach->isActive($card['status']) ? 'Active' : 'Inactive'
            );
        }

        return $result;
    }
}