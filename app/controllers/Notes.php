<?php

class Notes extends Controller {
    public function detail($id) {
        $data['judul'] = 'Detail Catatan';
        $data['note'] = $this->model('Note_model')->getNoteById($id);

        // Jika catatan tidak ditemukan, arahkan kembali ke halaman home
        if (!$data['note']) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        // Memuat view detail catatan
        $this->view('templates/header', $data); // Asumsi ada header umum
        $this->view('notes/detail', $data); // Memuat view detail catatan
        $this->view('templates/footer'); // Asumsi ada footer umum
    }

    // Anda bisa menambahkan metode lain seperti add(), edit(), delete() di sini
    public function add() {
        $data['judul'] = 'Tambah Catatan';
        $this->view('templates/header', $data);
        $this->view('notes/add', $data); // View untuk form tambah catatan (Anda perlu membuatnya)
        $this->view('templates/footer');
    }

    // Metode untuk memproses penambahan catatan
    public function create() {
        if ($this->model('Note_model')->addNote($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success');
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger');
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }

    // Metode untuk memproses penghapusan catatan
    public function delete($id) {
        if ($this->model('Note_model')->deleteNote($id) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }

    // Metode untuk menampilkan form edit catatan
    public function edit($id) {
        $data['judul'] = 'Edit Catatan';
        $data['note'] = $this->model('Note_model')->getNoteById($id);

        if (!$data['note']) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('notes/edit', $data); // View untuk form edit catatan
        $this->view('templates/footer');
    }

    // Metode untuk memproses pembaruan catatan
    public function update() {
        if ($this->model('Note_model')->updateNote($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success');
            header('Location: ' . BASEURL . '/home');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger');
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