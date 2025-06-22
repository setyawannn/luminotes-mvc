<?php

class Teams extends Controller
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
        $data['judul'] = 'Teams';
        $data['teams'] = $this->model('Team_model')->getAllTeam();
        $this->view('templates/auth/header', $data); 
        $this->view('profile/teams/index', $data);   
        $this->view('templates/auth/footer'); 
    }

    public function detail($id)
    {
        $teamModel = $this->model('Team_model');
        $data['judul'] = 'Detail Team';
        $teamDetails = $teamModel->getById($id); 

        $data['teamData'] = $teamDetails; 

        $this->view('templates/auth/header', $data);
        $this->view('profile/teams/detail', $data);
        $this->view('templates/auth/footer');
    }

    public function create()
    {
        $data['judul'] = 'Create Team';
        $this->view('templates/auth/header', $data);
        $this->view('profile/teams/create', $data); 
        $this->view('templates/auth/footer');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data_input = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description'])
            ];

            $errors = [];
            if (empty($data_input['name'])) {
                $errors['name_err'] = 'Nama tim tidak boleh kosong.';
            }
            if (empty($data_input['description'])) {
                $errors['description_err'] = 'Deskripsi tim tidak boleh kosong.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $data_input;
                header('Location: ' . BASEURL . '/teams');
                exit;
            } else {
                $team_data_to_create = [
                    'name' => $data_input['name'],
                    'description' => $data_input['description'],
                    'user_id' => $_SESSION['user_id'] 
                ];

                if ($this->model('Team_model')->createTeam($team_data_to_create)) {
                    unset($_SESSION['errors']);
                    unset($_SESSION['old_input']);
                    header('Location: ' . BASEURL . '/teams');
                    exit;
                } else {
                    $_SESSION['old_input'] = $data_input;
                    header('Location: ' . BASEURL . '/teams');
                    exit;
                }
            }
        } else {
            header('Location: ' . BASEURL . '/teams');
            exit;
        }
    }
    public function edit($id)
    {
        $teamModel = $this->model('Team_model');
        $teamDetails = $teamModel->getTeamOnlyById($id); 

        $data['team'] = $teamDetails; 
        $data['judul'] = 'Edit Team';

        $this->view('templates/auth/header', $data);
        $this->view('profile/teams/edit', $data);
        $this->view('templates/auth/footer');
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'user_id' => $_SESSION['user_id'], 
            ];

            if ($this->model('Team_model')->updateTeam($data['id'], $data)) {
                header('Location: ' . BASEURL . '/teams/detail/' . $id);
                exit;
            } else {
                header('Location: ' . BASEURL . '/teams/edit/' . $id);
                exit;
            }
        } else {
            $data['judul'] = 'Edit Team';
            $this->view('templates/auth/header', $data);
            $this->view('profile/teams/edit', $data); 
            $this->view('templates/auth/footer');
        }
    }

    public function deleteMember() {
        $teamId = $_POST['team_id'];
        $memberId = $_POST['member_id'];

        if (empty($teamId) || empty($memberId)) {
            echo json_encode(['status' => 'error', 'message' => 'ID tim atau ID anggota tidak valid.']); 
            exit;
        }

        $this->model('Team_model')->deleteMember($teamId, $memberId); 
        echo json_encode(['status' => 'success', 'message' => 'Anggota tim berhasil dihapus!']); 
        exit;
    }


    public function processJoin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/teams');
            exit;
        }

        $teamCode = $_POST['team_code'] ?? '';

        if (empty(trim($teamCode))) {
            header('Location: ' . BASEURL . '/teams');
            exit;
        }

        $userId = $_SESSION['user_id'];

        $teamModel = $this->model('Team_model');
        $result = $teamModel->joinTeamByCode($teamCode, $userId);

        header('Location: ' . BASEURL . '/teams');
        exit;
    }
}