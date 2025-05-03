<?php

class Profile extends Controller
{
    public function index()
    {
        $data['judul'] = 'Profile';
        $this->view('templates/auth/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/auth/footer');
    }
}