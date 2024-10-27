<?php
require_once(getcwd() . '/../inc/patient.php');

$page_class = new Patient;
$page_class->addCreditCard();
header("Location: edit_payment_info.php");
