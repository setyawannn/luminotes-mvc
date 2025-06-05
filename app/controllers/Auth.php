<?php

class Auth extends Controller {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
        $data['judul'] = 'Login';
        $this->view('templates/header', $data); 
        $this->view('auth/login');
        $this->view('templates/footer');
    }

    public function prosesLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? ''; 

        if (empty($email) || empty($password)) {
            Flasher::setFlash('Email dan password', 'tidak boleh kosong.', 'danger');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $userModel = $this->model('User_model');
        $user = $userModel->getUserByEmail($email);

        if (!password_verify($password, $user['password'])) {
            Flasher::setFlash('Password', 'salah.', 'danger');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_desc'] = $user['description'] ?? 'Tidak ada deskripsi';

        Flasher::setFlash('Login', 'berhasil!', 'success');
        header('Location: ' . BASEURL . '/dashboard');
        exit;
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
        $data['judul'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('auth/register');
        $this->view('templates/footer');
    }

    public function prosesRegister()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? ''; 
        $confirm_password = $_POST['confirm_password'] ?? '';
        $description = $_POST['description'] ?? null;

        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            Flasher::setFlash('Semua field wajib', 'diisi (kecuali deskripsi).', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        if (strlen($password) < 6) { 
            Flasher::setFlash('Password minimal', '6 karakter.', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        if ($password !== $confirm_password) {
            Flasher::setFlash('Konfirmasi password', 'tidak cocok.', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        $userModel = $this->model('User_model');
        if ($userModel->getUserByEmail($email)) {
            Flasher::setFlash('Email', 'sudah terdaftar.', 'warning');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $dataToCreate = [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'description' => $description
        ];

        if ($userModel->createUser($dataToCreate)) {
            Flasher::setFlash('Registrasi', 'berhasil! Silakan login.', 'success');
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        } else {
            Flasher::setFlash('Registrasi', 'gagal disimpan ke database, coba lagi.', 'danger');
            header('Location: ' . BASEURL . '/auth/register');
            exit;
        }
    }

    public function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        Flasher::setFlash('Anda telah', 'berhasil logout.', 'success');
        header('Location: ' . BASEURL . '/auth/login');
        exit;
    }
}