<?php
namespace PaymentMethod;
include 'header.php';
require_once ('payment_method_abstract.php');
require_once ('payment_method_Interface.php');
use Database;

class ACH extends PaymentMethod implements PaymentMethodInterface
{

    protected $account_number;
    protected $routing_number;
    protected $accountholder_name;
    protected $status;

    public function __construct($account_number, $routing_number, $accountholder_name)
    {
        $this->account_number = $account_number;
        $this->routing_number = $routing_number;
        $this->accountholder_name = $accountholder_name;
    }

    public function setActive($active): void 
    {
        $query = sprintf('
            UPDATE 
                bank_account
            SET 
                status = %s
            WHERE
                account_number = "%s" 
            AND
                username = "%s"
            ',
            $active,
            $this->account_number,
            $_SESSION['username']
        );

        $database = new Database;
        $database->writeToDatabase($query);

        $this->isActive = $active;
    }

    public function isActive($status): bool {
        return boolval($status);
    }
}
?>
