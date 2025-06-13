<?php

class Note_model {
    private $db;
    private $table = 'notes';

    public function __construct() {
        $this->db = new Database;
    }

    public function getFilteredNotes($searchQuery = '', $filterTopic = '', $startDate = '', $endDate = '', $ratingOperator = '', $ratingValue = '') {
        $sql = "
            SELECT
                n.id,
                n.title,
                n.description,
                n.topics AS category,
                n.is_public,
                n.team_id,
                n.file,
                n.thumbnail,
                n.status,
                n.created_at,
                u.id AS creator_id,
                u.name AS creator_name,
                u.email AS creator_email,
                u.profile AS creator_profile -- Mengambil kolom 'profile' dari tabel users sebagai 'creator_profile'
            FROM
                " . $this->table . " n
            JOIN
                users u ON n.creator_id = u.id
            WHERE 1=1
        ";

        if (!empty($searchQuery)) {
            $sql .= " AND (n.title LIKE :search_query OR n.description LIKE :search_query)";
        }

        if (!empty($filterTopic)) {
            $sql .= " AND n.topics = :filter_topic";
        }

        if (!empty($startDate)) {
            $sql .= " AND n.created_at >= :start_date";
        }
        if (!empty($endDate)) {
            $sql .= " AND n.created_at <= :end_date";
        }

        $sql .= " ORDER BY n.created_at DESC";

        $this->db->query($sql);

        if (!empty($searchQuery)) {
            $this->db->bind(':search_query', '%' . $searchQuery . '%');
        }
        if (!empty($filterTopic)) {
            $this->db->bind(':filter_topic', $filterTopic);
        }
        if (!empty($startDate)) {
            $this->db->bind(':start_date', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $this->db->bind(':end_date', $endDate . ' 23:59:59');
        }
        
        $notes = $this->db->resultSet();

        $formattedNotes = [];
        foreach ($notes as $note) {
            $formattedNotes[] = [
                'id' => $note['id'],
                'title' => $note['title'],
                'description' => $note['description'],
                'category' => $note['category'],
                'thumbnail' => $note['thumbnail'],
                'rating' => 0.0, // Tetap 0.0 karena tidak ada di DB, atau sesuaikan jika ditambahkan
                'created_at' => $note['created_at'],
                'creator' => [
                    'id' => $note['creator_id'],
                    'name' => $note['creator_name'],
                    'img' => $note['creator_profile'] ?? 'person_default.png', // Menggunakan 'creator_profile' dari alias SQL
                    'email' => $note['creator_email']
                ],
                'is_public' => (bool)$note['is_public'],
                'team_id' => $note['team_id'],
                'file' => $note['file'],
                'status' => $note['status']
            ];
        }

        return $formattedNotes;
    }

    public function getAllNote() {
        return $this->getFilteredNotes();
    }

    public function getByCreator($creatorId) {
        $this->db->query("
            SELECT
                n.id,
                n.title,
                n.description,
                n.topics AS category,
                n.is_public,
                n.team_id,
                n.file,
                n.thumbnail,
                n.status,
                n.created_at,
                u.id AS creator_id,
                u.name AS creator_name,
                u.email AS creator_email,
                u.profile AS creator_profile -- Mengambil kolom 'profile' dari tabel users sebagai 'creator_profile'
            FROM
                " . $this->table . " n
            JOIN
                users u ON n.creator_id = u.id
            WHERE
                n.creator_id = :creator_id
            ORDER BY
                n.created_at DESC
        ");

        $this->db->bind(':creator_id', $creatorId);

        $notes = $this->db->resultSet();

        $creatorNotes = [];
        foreach ($notes as $note) {
            $creatorNotes[] = [
                'id' => $note['id'],
                'title' => $note['title'],
                'description' => $note['description'],
                'category' => $note['category'],
                'thumbnail' => $note['thumbnail'],
                'rating' => 0.0,
                'created_at' => $note['created_at'],
                'creator' => [
                    'id' => $note['creator_id'],
                    'name' => $note['creator_name'],
                    'img' => $note['creator_profile'] ?? 'person_default.png', // Menggunakan 'creator_profile' dari alias SQL
                    'email' => $note['creator_email']
                ],
                'is_public' => (bool)$note['is_public'],
                'team_id' => $note['team_id'],
                'file' => $note['file'],
                'status' => $note['status']
            ];
        }

        return $creatorNotes;
    }

    public function getNoteById($id) {
        $this->db->query("
            SELECT
                n.id,
                n.title,
                n.description,
                n.topics AS category,
                n.is_public,
                n.team_id,
                n.file,
                n.thumbnail,
                n.status,
                n.created_at,
                u.id AS creator_id,
                u.name AS creator_name,
                u.email AS creator_email,
                u.profile AS creator_profile -- Mengambil kolom 'profile' dari tabel users sebagai 'creator_profile'
            FROM
                " . $this->table . " n
            JOIN
                users u ON n.creator_id = u.id
            WHERE
                n.id = :id
        ");

        $this->db->bind(':id', $id);
        $note = $this->db->single();

        if ($note) {
            return [
                'id' => $note['id'],
                'title' => $note['title'],
                'description' => $note['description'],
                'category' => $note['category'],
                'thumbnail' => $note['thumbnail'],
                'rating' => 0.0, // Rating tidak ada di DB, set ke default 0.0 atau sesuaikan
                'created_at' => $note['created_at'],
                'creator' => [
                    'id' => $note['creator_id'],
                    'name' => $note['creator_name'],
                    'img' => $note['creator_profile'] ?? 'person_default.png', // Menggunakan 'creator_profile' dari alias SQL
                    'email' => $note['creator_email']
                ],
                'is_public' => (bool)$note['is_public'],
                'team_id' => $note['team_id'],
                'file' => $note['file'],
                'status' => $note['status']
            ];
        }
        return null;
    }

    public function addNote($data) {
        $query = "INSERT INTO " . $this->table . " (title, description, topics, is_public, team_id, file, thumbnail, status, creator_id)
                  VALUES (:title, :description, :topics, :is_public, :team_id, :file, :thumbnail, :status, :creator_id)";

        $this->db->query($query);
        $this->db->bind('title', $data['title']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('topics', $data['category']);
        $this->db->bind('is_public', $data['is_public'] ?? 0);
        $this->db->bind('team_id', $data['team_id'] ?? null);
        $this->db->bind('file', $data['file'] ?? '');
        $this->db->bind('thumbnail', $data['thumbnail'] ?? '');
        $this->db->bind('status', $data['status'] ?? 'pending');
        $this->db->bind('creator_id', $data['creator_id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteNote($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateNote($data) {
        $query = "UPDATE " . $this->table . " SET
                    title = :title,
                    description = :description,
                    topics = :topics,
                    is_public = :is_public,
                    team_id = :team_id,
                    file = :file,
                    thumbnail = :thumbnail,
                    status = :status
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('title', $data['title']);
        $this->db->bind('description', $data['description']);
        $this->db->bind('topics', $data['category']);
        $this->db->bind('is_public', $data['is_public'] ?? 0);
        $this->db->bind('team_id', $data['team_id'] ?? null);
        $this->db->bind('file', $data['file'] ?? '');
        $this->db->bind('thumbnail', $data['thumbnail'] ?? '');
        $this->db->bind('status', $data['status'] ?? 'pending');
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }
}