<?php

class Dashboard extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }   
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['notes'] = $this->model('Note_model')->getAllNote();
        $this->view('templates/auth/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/auth/footer');
    }
}