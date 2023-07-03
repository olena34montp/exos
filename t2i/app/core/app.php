<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (is_null($url)) {
            $url[0] = 'Home';
        }

        if (file_exists('app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }
        require('app/controllers/' . $this->controller . 'Controller.php');
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
        include_once 'app/views/template/footer.php';
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = filter_var(str_replace(' ', '%20', $_GET['url']), FILTER_SANITIZE_URL);
            $url = explode('/', rtrim($url, '/'));
            return $url;
        }
    }
}