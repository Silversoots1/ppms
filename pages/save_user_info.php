<?php

require_once (getcwd() . '/../inc/save_user_info.php');
$page_class = new SaveUserInfo;
$page_class->saveAndCheck();
header("Location: ../index.php");
