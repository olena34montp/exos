<?php

class Home extends M_Home
{
    protected $model;
    public function __construct()
    {
        $this->model = new M_Home();
    }
    public function index()
    {
        $this->model->view('home/index');
    }

    public function create() 
    {
        if(isset($_SESSION['create-client'])) {
            $newClient = $_SESSION['create-client'];
            $_SESSION['message'] = $this->model->createClient($newClient);

            unset($_SESSION['create-client']);
            $this->model->redirect('home/index');
        } else {
            $this->model->redirect('home/index');
        }
    }
}
