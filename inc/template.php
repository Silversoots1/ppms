<?php
class Template {
    public function render(string $page_name, array $parameter = []): string
    {
        require_once ('../vendor/autoload.php');
        $loader = new \Twig\Loader\FilesystemLoader('../html');
        $twig = new \Twig\Environment($loader);
        return $twig->render($page_name, $parameter);
    }
}