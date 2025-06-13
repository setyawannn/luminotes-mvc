<?php

class Home extends Controller {
    public function index() {
        $data['judul'] = 'Home';
        $data['nama'] = $this->model('User_model')->getUser();

        $searchQuery = $_GET['search'] ?? '';
        $filterTopic = $_GET['topic'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $ratingOperator = $_GET['rating_op'] ?? '';
        $ratingValue = $_GET['rating_val'] ?? '';

        $data['notes'] = $this->model('Note_model')->getFilteredNotes(
            $searchQuery,
            $filterTopic,
            $startDate,
            $endDate,
            $ratingOperator,
            $ratingValue
        );

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
