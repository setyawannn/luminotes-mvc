<?php

class Team_model {
    private $table = 'teams';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllTeam() {
        return [
            [
                'id' => 1,
                'name' => 'Anacoda',
                'code' => 'ANC001',
                'created_at' => '2024-02-10'
            ],
            [
                'id' => 2,
                'name' => 'Kipas Angin',
                'code' => 'KPA002',
                'created_at' => '2024-02-12'
            ],
            [
                'id' => 3,
                'name' => 'Bismillah',
                'code' => 'BSM003',
                'created_at' => '2024-02-15'
            ],
            [
                'id' => 4,
                'name' => 'Semoga Berkah',
                'code' => 'SMB004',
                'created_at' => '2024-02-18'
            ],
            [
                'id' => 5,
                'name' => 'Ciboox',
                'code' => 'CBX005',
                'created_at' => '2024-02-20'
            ],
            [
                'id' => 6,
                'name' => 'Flexino',
                'code' => 'FLX006',
                'created_at' => '2024-02-22'
            ]
        ];
    }
    
    public function getById($id) {
        $teams = $this->getAllTeam();
        
        $teamData = null;
        foreach ($teams as $team) {
            if ($team['id'] == $id) {
                $teamData = $team;
                break;
            }
        }
        
        if ($teamData === null) {
            $teamData = [
                'id' => $id,
                'name' => 'Team Not Found',
                'code' => 'NOTFOUND',
                'created_at' => date('Y-m-d')
            ];
        }
        
        $leader = [
            'id' => 1,
            'name' => 'Aristoteles',
            'img' => 'person1.png'
        ];
        
        $members = [
            [
                'id' => 1,
                'name' => 'Aristoteles',
                'img' => 'person1.png'
            ],
            [
                'id' => 2,
                'name' => 'Max Marstepen',
                'img' => 'person2.png'
            ],
            [
                'id' => 3,
                'name' => 'Emma Watson',
                'img' => 'person3.png'
            ]
        ];
        
        return [
            'team' => $teamData,
            'leader' => $leader,
            'members' => $members
        ];
    }
}