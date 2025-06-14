<?php

class Profile extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            Flasher::setFlash('Akses ditolak!', 'Silakan login terlebih dahulu.', 'danger');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }
    public function index()
    {
        $data['judul'] = 'Profile';
        $data['notes'] = $this->model('Note_model')->getByCreator(1);
        $this->view('templates/auth/header', $data);
        $this->view('profile/index', $data);
        $this->view('templates/auth/footer');
    }
}