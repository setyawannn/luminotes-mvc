<?php

class Notes extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
    }

    private function _checkDir($path) {
        if (!is_dir($path)) {
            if (!@mkdir($path, 0755, true)) {
                throw new Exception("Gagal membuat folder upload di '{$path}'. Periksa izin server.");
            }
        }
    }

    public function detail($id) {
        $data['judul'] = 'Detail Catatan';
        $data['note'] = $this->model('Note_model')->getNoteById($id);

        if (!$data['note']) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $this->view('templates/header', $data); 
        $this->view('notes/detail', $data);
        $this->view('templates/footer'); 
    }

    public function add() {
        $data['judul'] = 'Add Notes';
        $data['teams'] = $this->model('Team_model')->getAllTeam();

        $this->view('templates/header', $data);
        $this->view('notes/add', $data);
        $this->view('templates/footer');
    }

     public function preview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/notes/add');
            exit;
        }

        try {
            if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("File PDF wajib diupload atau terjadi error saat upload.");
            }

            $fileTmpPath = $_FILES['pdf_file']['tmp_name'];
            $fileName = $_FILES['pdf_file']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            if ($fileExtension !== 'pdf') {
                throw new Exception("Hanya file dengan format .pdf yang diizinkan.");
            }

            $pdfFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/notes/'; 
            
            $this->_checkDir($uploadFileDir);
            
            $dest_path = $uploadFileDir . $pdfFileName;

            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                throw new Exception("Gagal memindahkan file PDF yang diupload. Periksa izin folder.");
            }

            $_SESSION['note_preview_data'] = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'topics' => $_POST['topics'],
                'is_public' => $_POST['is_public'],
                'team_id' => !empty($_POST['team_id']) ? $_POST['team_id'] : null,
                'pdf_filename' => $pdfFileName, 
                'pdf_file_url' => BASEURL . '/uploads/notes/' . $pdfFileName 
            ];
            
            $data['judul'] = 'Preview Catatan';
            $data['preview_data'] = $_SESSION['note_preview_data'];
            $this->view('templates/header', $data);
            $this->view('notes/preview', $data);
            $this->view('templates/footer');

        } catch (Exception $e) {
            header('Location: ' . BASEURL . '/notes/add');
            exit;
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['note_preview_data'])) {
            header('Location: ' . BASEURL . '/notes/add');
            exit;
        }

        $thumbnailFileName = null; 
        $pdfFilePathForUnlink = './uploads/notes/' . $_SESSION['note_preview_data']['pdf_filename'];

        try {
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
                $fileName = $_FILES['thumbnail']['name'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($fileExtension, $allowedImageExtensions)) {
                    throw new Exception("Format thumbnail tidak valid. Hanya gambar (jpg, png, gif) yang diizinkan.");
                }

                $thumbnailFileName = md5(time() . 'thumb' . $fileName) . '.' . $fileExtension;
                $uploadFileDir = './uploads/thumbnails/';
                
                $this->_checkDir($uploadFileDir);

                $dest_path = $uploadFileDir . $thumbnailFileName;

                if(!move_uploaded_file($fileTmpPath, $dest_path)) {
                    throw new Exception("Gagal mengupload thumbnail.");
                }
            }

            $pdfFullUrl = $_SESSION['note_preview_data']['pdf_file_url'];
            $thumbnailFullUrl = null;
            if ($thumbnailFileName) {
                $thumbnailFullUrl = BASEURL . '/uploads/thumbnails/' . $thumbnailFileName;
            }

            $finalData = [
                'title' => $_SESSION['note_preview_data']['title'],
                'description' => $_SESSION['note_preview_data']['description'],
                'category' => $_SESSION['note_preview_data']['topics'],
                'is_public' => $_SESSION['note_preview_data']['is_public'],
                'team_id' => $_SESSION['note_preview_data']['team_id'],
                'file' => $pdfFullUrl, 
                'thumbnail' => $thumbnailFullUrl, 
                'status' => 'pending',
                'creator_id' => $_SESSION['user_id']
            ];

            if ($this->model('Note_model')->addNote($finalData) <= 0) {
                throw new Exception("Gagal menyimpan data catatan ke database.");
            }

            unset($_SESSION['note_preview_data']);
            header('Location: ' . BASEURL . '/dashboard');
            exit;

        } catch (Exception $e) {
            if (file_exists($pdfFilePathForUnlink)) {
                unlink($pdfFilePathForUnlink);
            }
            if ($thumbnailFileName !== null && file_exists('./uploads/thumbnails/' . $thumbnailFileName)) {
                unlink('./uploads/thumbnails/' . $thumbnailFileName);
            }
            
            unset($_SESSION['note_preview_data']);
            header('Location: ' . BASEURL . '/notes/add');
            exit;
        }
    }

    public function delete($id) {
        if ($this->model('Note_model')->deleteNote($id) > 0) {
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }
    

    public function edit($id) {
        $data['judul'] = 'Edit Catatan';
        $data['note'] = $this->model('Note_model')->getNoteById($id);

        if (!$data['note']) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('notes/edit', $data);
        $this->view('templates/footer');
    }

    public function update() {
        if ($this->model('Note_model')->updateNote($_POST) > 0) {
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }

    public function search() {
        $keyword = $_POST['keyword'] ?? '';
        $data['judul'] = 'Hasil Pencarian';
        $data['notes'] = $this->model('Note_model')->getFilteredNotes($keyword); 

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}