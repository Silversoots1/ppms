<?php

class ErrorManagement{
    public function logErrorToFile($error_message, $error_type, $login_enabled = true):void
    {
        if($login_enabled)
        {
            $filename = $error_type . '_error';
            file_put_contents('../error_logs/'.$filename, $error_message, FILE_APPEND);
        }
    }
}