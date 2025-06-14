<?php
class Note_model extends Model { 
    
    public function getFilteredNotes($searchQuery = '', $filterTopic = '', $startDate = '', $endDate = '', $ratingOperator = '', $ratingValue = '') {

        $sql = "SELECT
                    n.id, n.title, n.description, n.topics AS category, n.is_public,
                    n.team_id, n.file, n.thumbnail, n.status, n.created_at,
                    u.id AS creator_id, u.name AS creator_name, u.email AS creator_email,
                    u.description AS creator_profile
                FROM
                    notes n
                JOIN
                    users u ON n.creator_id = u.id
                WHERE 1=1"; 

        if (!empty($searchQuery)) {
            $escapedSearch = $this->db->real_escape_string($searchQuery);
            $sql .= " AND (n.title LIKE '%{$escapedSearch}%' OR n.description LIKE '%{$escapedSearch}%')";
        }
        if (!empty($filterTopic)) {
            $escapedTopic = $this->db->real_escape_string($filterTopic);
            $sql .= " AND n.topics = '{$escapedTopic}'";
        }
        if (!empty($startDate)) {
            $escapedStartDate = $this->db->real_escape_string($startDate);
            $sql .= " AND n.created_at >= '{$escapedStartDate} 00:00:00'";
        }
        if (!empty($endDate)) {
            $escapedEndDate = $this->db->real_escape_string($endDate);
            $sql .= " AND n.created_at <= '{$escapedEndDate} 23:59:59'";
        }

        $sql .= " ORDER BY n.created_at DESC";

        $result = $this->db->query($sql);
        $notes = [];
        if ($result) {
            $notes = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("MySQLi Query Error (getFilteredNotes): " . $this->db->error . " | SQL: " . $sql);
        }
        
        $formattedNotes = [];
        foreach ($notes as $note) {
            $formattedNotes[] = [
                'id' => $note['id'],
                'title' => $note['title'],
                'description' => $note['description'],
                'category' => $note['category'],
                'thumbnail' => $note['thumbnail'],
                'rating' => 0.0, // Tetap 0.0
                'created_at' => $note['created_at'],
                'creator' => [
                    'id' => $note['creator_id'],
                    'name' => $note['creator_name'],
                    'img' => $note['creator_profile'] ?? 'person_default.png',
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
        $creatorIdInt = (int)$creatorId;

        $sql = "SELECT
                    n.id, n.title, n.description, n.topics AS category, n.is_public,
                    n.team_id, n.file, n.thumbnail, n.status, n.created_at,
                    u.id AS creator_id, u.name AS creator_name, u.email AS creator_email,
                    u.description AS creator_profile
                FROM
                    notes n
                JOIN
                    users u ON n.creator_id = u.id
                WHERE
                    n.creator_id = $creatorIdInt
                ORDER BY
                    n.created_at DESC";
        
        $result = $this->db->query($sql);
        $notes = [];
        if($result) {
            $notes = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            error_log("MySQLi Query Error (getByCreator): " . $this->db->error . " | SQL: " . $sql);
        }

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
                    'img' => $note['creator_profile'] ?? 'person_default.png',
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
        $noteId = (int)$id;

        $sql = "SELECT
                    n.id, n.title, n.description, n.topics AS category, n.is_public,
                    n.team_id, n.file, n.thumbnail, n.status, n.created_at,
                    u.id AS creator_id, u.name AS creator_name, u.email AS creator_email,
                    u.description AS creator_profile
                FROM
                    notes n
                JOIN
                    users u ON n.creator_id = u.id
                WHERE
                    n.id = $noteId";
        
        $result = $this->db->query($sql);
        $note = null;
        if ($result) {
            $note = $result->fetch_assoc();
        } else {
             error_log("MySQLi Query Error (getNoteById): " . $this->db->error . " | SQL: " . $sql);
        }

        if ($note) {
            return [
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
                    'img' => $note['creator_profile'] ?? 'person_default.png',
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
        $title = $this->db->real_escape_string($data['title']);
        $description = $this->db->real_escape_string($data['description']);
        $topics = $this->db->real_escape_string($data['category']);
        $is_public = (int)($data['is_public'] ?? 0);
        $file = $this->db->real_escape_string($data['file'] ?? '');
        $thumbnail = $this->db->real_escape_string($data['thumbnail'] ?? '');
        $status = $this->db->real_escape_string($data['status'] ?? 'pending');
        $creator_id = (int)$data['creator_id'];

        $team_id = 'NULL';
        if (isset($data['team_id']) && !empty($data['team_id'])) {
            $team_id = (int)$data['team_id'];
        }

        $sql = "INSERT INTO notes (title, description, topics, is_public, team_id, file, thumbnail, status, creator_id)
                VALUES ('$title', '$description', '$topics', $is_public, $team_id, '$file', '$thumbnail', '$status', $creator_id)";
        
        $this->db->query($sql);
        return $this->db->affected_rows; 
    }

    public function deleteNote($id) {
        $noteId = (int)$id;
        $sql = "DELETE FROM notes WHERE id = $noteId";
        
        $this->db->query($sql);
        return $this->db->affected_rows;
    }

    public function updateNote($data) {
        $id = (int)$data['id'];
        $title = $this->db->real_escape_string($data['title']);
        $description = $this->db->real_escape_string($data['description']);
        $topics = $this->db->real_escape_string($data['category']);
        $is_public = (int)($data['is_public'] ?? 0);
        $file = $this->db->real_escape_string($data['file'] ?? '');
        $thumbnail = $this->db->real_escape_string($data['thumbnail'] ?? '');
        $status = $this->db->real_escape_string($data['status'] ?? 'pending');
        
        $team_id = 'NULL';
        if (isset($data['team_id']) && !empty($data['team_id'])) {
            $team_id = (int)$data['team_id'];
        }

        $sql = "UPDATE notes SET
                    title = '$title',
                    description = '$description',
                    topics = '$topics',
                    is_public = $is_public,
                    team_id = $team_id,
                    file = '$file',
                    thumbnail = '$thumbnail',
                    status = '$status'
                WHERE id = $id";
        
        $this->db->query($sql);
        return $this->db->affected_rows;
    }
}