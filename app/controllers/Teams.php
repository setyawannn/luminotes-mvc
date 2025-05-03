<?php

class Teams extends Controller
{
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
        $data['judul'] = 'Detail Teams';
        $data['teamData'] = $this->model('Team_model')->getById($id);
        $this->view('templates/auth/header', $data);
        $this->view('profile/teams/detail', $data);
        $this->view('templates/auth/footer');
    }
}