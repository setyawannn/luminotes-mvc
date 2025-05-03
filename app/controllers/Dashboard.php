<?php

class Dashboard extends Controller
{
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['nama'] = $this->model('User_model')->getUser();
        $this->view('templates/auth/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/auth/footer');
    }
}