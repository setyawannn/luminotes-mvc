<?php
class Team_model extends Model { 
    
    public function getAllTeam() {
        if (!isset($_SESSION['user_id'])) {
            return []; 
        }
        $loggedInUserId = (int)$_SESSION['user_id']; 

        $sql = "SELECT 
                    t.id, t.name, t.description, t.code, t.created_at, t.updated_at
                FROM
                    teams t
                INNER JOIN 
                    team_members tm ON t.id = tm.team_id
                WHERE
                    tm.user_id = $loggedInUserId
                ORDER BY
                    t.created_at DESC";
        
        $result = $this->db->query($sql);
        
        $teams = [];
        if ($result) { 
            $teams = $result->fetch_all(MYSQLI_ASSOC); 
        }
        
        return $teams;
    }

    public function getTeamOnlyById($id) {
        $teamId = (int)$id;
        
        $sql = "SELECT * FROM teams WHERE id = $teamId";
        
        $result = $this->db->query($sql);
        
        $teams = [];
        if ($result) { 
            $teams = $result->fetch_assoc(); 
        }
        
        return $teams;  
    }
    
    public function getById($id) {
        $teamId = (int)$id;
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $loggedInUserId = (int)$_SESSION['user_id'];

        $membership = "SELECT COUNT(*) as member_count FROM team_members WHERE team_id = $teamId AND user_id = $loggedInUserId";
        $check = $this->db->query($membership);
        $isMember = false;
        if ($check) {
            $rowCheck = $check->fetch_assoc();
            if ($rowCheck && $rowCheck['member_count'] > 0) {
                $isMember = true;
            }
        } 

        if (!$isMember) {
            return false; 
        }

        $sqlDetails = "SELECT 
                        t.id as team_id, t.name as team_name, t.description as team_description, t.code as team_code, 
                        t.created_at as team_created_at, t.updated_at as team_updated_at,
                        tm.role as member_role,
                        u.id as user_id, u.name as user_name, u.email as user_email 
                    FROM teams t
                    LEFT JOIN team_members tm ON t.id = tm.team_id
                    LEFT JOIN users u ON tm.user_id = u.id
                    WHERE t.id = $teamId
                    ORDER BY CASE WHEN tm.role = 'leader' THEN 0 ELSE 1 END, u.name ASC"; 

        $resultDetails = $this->db->query($sqlDetails);
        $allRows = [];
        if ($resultDetails) {
            $allRows = $resultDetails->fetch_all(MYSQLI_ASSOC);
        } 

        if (empty($allRows)) {
            return false; 
        }

        $teamData = null; $leader = null; $members = [];
        $firstRow = $allRows[0];
        $teamData = [
            'id' => $firstRow['team_id'], 'name' => $firstRow['team_name'],
            'description' => $firstRow['team_description'], 'code' => $firstRow['team_code'],
            'created_at' => $firstRow['team_created_at'], 'updated_at' => $firstRow['team_updated_at']
        ];
        foreach ($allRows as $row) {
            if ($row['user_id'] !== null) { 
                $memberInfo = [
                    'id' => $row['user_id'], 'name' => $row['user_name'],
                    'email' => $row['user_email'], 'role' => $row['member_role']
                ];
                if ($row['member_role'] === 'leader' && $leader === null) { $leader = $memberInfo; }
                if (!($row['member_role'] === 'leader' && $leader !== null && $leader['id'] == $row['user_id'])) {
                     if($row['member_role'] !== 'leader'){ $members[] = $memberInfo; } 
                     else if ($leader['id'] != $row['user_id']) { $members[] = $memberInfo; }
                }
            }
        }
        if($leader === null && isset($allRows[0]['user_id']) && $allRows[0]['member_role'] === 'leader'){
             $leader = ['id' => $allRows[0]['user_id'], 'name' => $allRows[0]['user_name'], 
                        'email' => $allRows[0]['user_email'], 'role' => $allRows[0]['member_role']];
        }
        return ['team' => $teamData, 'leader' => $leader, 'members' => $members];
    }
    
    private function generateUniqueTeamCode($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[rand(0, strlen($characters) - 1)];
            }
            $escapedCode = $this->db->real_escape_string($code);
            $sqlCheck = "SELECT id FROM teams WHERE code = '$escapedCode'";
            $result = $this->db->query($sqlCheck);
            $isFound = ($result && $result->num_rows > 0);
        } while ($isFound);
        return $code;
    }

    public function createTeam($data) {
        $name = $this->db->real_escape_string($data['name']);
        $description = $this->db->real_escape_string($data['description']);
        $userId = (int)$data['user_id'];

        $teamCode = $this->generateUniqueTeamCode();
       

        $sqlTeams = "INSERT INTO teams (name, description, code) VALUES ('$name', '$description', '$teamCode')";
        
        $this->db->query($sqlTeams); 
        
        $teamId = $this->db->insert_id; 


        $role = 'leader'; 
        $sqlTeamMembers = "INSERT INTO team_members (team_id, user_id, role) VALUES ($teamId, $userId, '$role')";
        
        return $this->db->query($sqlTeamMembers); 
    }

    public function updateTeam($id, $data) {
        $teamId = (int)$id;
        $name = $this->db->real_escape_string($data['name']);
        $description = $this->db->real_escape_string($data['description']);

        $sql = "UPDATE teams SET name = '$name', description = '$description', updated_at = current_timestamp() WHERE id = $teamId";
        return $this->db->query($sql);
    }

    public function joinTeamByCode($teamCode, $userId) {
        $escapedTeamCode = $this->db->real_escape_string($teamCode);
        $currentUserId = (int)$userId;

        $sqlFindTeam = "SELECT id FROM teams WHERE code = '$escapedTeamCode'";
        $resultFindTeam = $this->db->query($sqlFindTeam);
        
        $teamId = null;
        if ($resultFindTeam && $resultFindTeam->num_rows > 0) {
            $teamRow = $resultFindTeam->fetch_assoc();
            $teamId = (int)$teamRow['id'];
        } 

        if ($teamId === null) {
            return ['status' => 'error', 'message' => 'Tim dengan kode tersebut tidak ditemukan.'];
        }

        $sqlCheckMembership = "SELECT id FROM team_members WHERE team_id = $teamId AND user_id = $currentUserId";
        $resultCheckMembership = $this->db->query($sqlCheckMembership);

        if ($resultCheckMembership && $resultCheckMembership->num_rows > 0) {
            return ['status' => 'warning', 'message' => 'Anda sudah menjadi anggota tim ini.'];
        }

        $defaultRole = 'member';
        $sqlInsertMember = "INSERT INTO team_members (team_id, user_id, role) VALUES ($teamId, $currentUserId, '$defaultRole')";
        if ($this->db->query($sqlInsertMember)) {
            return ['status' => 'success', 'message' => 'Berhasil bergabung dengan tim!'];
        } else {
            return ['status' => 'error', 'message' => 'Gagal bergabung dengan tim. Terjadi kesalahan internal.'];
        }
    }

    public function deleteMember($teamId, $memberId) {
        $teamId = (int)$teamId;
        $memberId = (int)$memberId;
        $sqlDeleteMember = "DELETE FROM team_members WHERE team_id = $teamId AND user_id = $memberId";
        return $this->db->query($sqlDeleteMember);
    }
}