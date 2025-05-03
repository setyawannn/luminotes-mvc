<?php

class Profile extends Controller
{
    public function index()
    {
        $data['judul'] = 'Profile';
        $data['notes'] = $this->model('Note_model')->getByCreator(1);
        $this->view('templates/auth/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/auth/footer');
    }
}