<?php
require_once (getcwd() . '/../inc/template.php');

class CreateAccount extends template
{
    public function create(): void
    {

        echo $this->render('change_user_info.html.twig',[]);

    }
}