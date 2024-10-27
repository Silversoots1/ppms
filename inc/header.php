<?php
require_once ('../config_session.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    die();
}
?>