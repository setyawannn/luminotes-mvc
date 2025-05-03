<?php

class Dashboard extends Controller
{
    public function index()
    {
        $data['judul'] = 'Dashboard';
        $data['notes'] = $this->model('Note_model')->getAllNote();
        $this->view('templates/auth/header', $data);
        $this->view('dashboard/index', $data);
        $this->view('templates/auth/footer');
    }
}