<?php
namespace Macbook\Core;

class Controller
{
    protected string $layout;
    public function __construct()
    {
        Session::openSession();
        $this->layout = "base";
    }
    public function redirectToRouter(string $path)
    {
        header("location:" . WEBROOT . "?$path");
        exit;
    }

    public function renderView(string $view, array $data = [])
    {
        ob_start();
        extract($data);
        require_once("$view.html.php");
        $content_view = ob_get_clean();
        require_once "../views/layout/$this->layout.layout.php";
    }

    public function renderJson(array $data = [])
    {
        echo json_encode($data);
    }
}
