<?php

namespace PaymentMethod;

abstract class PaymentMethod 
{
    protected $cardNumberOrAccountNumber;
    protected $isActive = false;

    public function getMaskedCardNumber(): string {
        return str_pad(substr($this->cardNumberOrAccountNumber, -4), strlen($this->cardNumberOrAccountNumber), '*', STR_PAD_LEFT);
    }

    public function isActive($status) {
    }

    public function setActive(bool $active): void {
        $this->isActive = $active;
    }
}
?>
