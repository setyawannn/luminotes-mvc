<?php

class Home extends Controller {

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
        $data['judul'] = 'Home';
        $data['nama'] = 'John Doe';
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
