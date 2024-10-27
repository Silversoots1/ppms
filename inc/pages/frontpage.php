<?php
include 'header.php';
require_once (getcwd() . '/../inc/template.php');

class Frontpage
{
    public function create(): void
    {
        $template = new Template;

        echo $template->render('frontpage.html.twig',[]);
    }
}