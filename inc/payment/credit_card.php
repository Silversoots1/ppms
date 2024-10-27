<?php
namespace PaymentMethod;
include 'header.php';
require_once ('payment_method_abstract.php');
require_once ('payment_method_Interface.php');

class CreditCard extends PaymentMethod implements PaymentMethodInterface
{
    
    protected $card_number;
    protected $expirationDate;
    protected $cardholder_name;
    protected $isActive;


    public function __construct($card_number, $expiration_date, $cardholder_name, $status)
    {
        $this->card_number = $card_number;
        $this->expirationDate = $expiration_date;
        $this->cardholder_name = $cardholder_name;
        $this->isActive = $this->isActive($status);
    }

    public function isExpired(): bool {
        $currentDate = new \DateTime();
        $expirationDate = \DateTime::createFromFormat('Y-m-d', $this->expirationDate);
        return $expirationDate < $currentDate;
    }

    public function isActive($status): bool {
        return boolval($status) && !$this->isExpired();
    }

    public function getMaskedCardNumber(): string {
        return str_pad(substr($this->card_number, -4), strlen($this->cardNumberOrAccountNumber), '*', STR_PAD_LEFT);
    }
}

?>
