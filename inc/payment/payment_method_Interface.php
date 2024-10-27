<?php

namespace PaymentMethod;

interface PaymentMethodInterface {
    public function getMaskedCardNumber(): string;
}

?>
