<?php

class Note_model {
    private $db;
    private $table = 'notes';


    public function getAllNote() {
        return [
            [
                'id' => 1,
                'title' => 'Pemrograman Dasar Tiper Variable',
                'description' => 'Menjelaskan tentang variable yang ada pada java',
                'category' => 'Pemrograman',
                'thumbnail' => 'java.png',
                'rating' => 4.5,
                'created_at' => '2024-02-16',
                'creator' => [
                    'id' => 1,
                    'name' => 'Aristoteles',
                    'image' => 'person1.png'
                ]
            ],
            [
                'id' => 2,
                'title' => 'Matematika Diskrit Teori Bilangan',
                'description' => 'Menjelaskan tentang variable yang ada pada java',
                'category' => 'Matematika',
                'thumbnail' => 'math.png',
                'rating' => 4.5,
                'created_at' => '2024-02-16',
                'creator' => [
                    'id' => 2,
                    'name' => 'Max Varstepen',
                    'image' => 'person2.png'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Algoritma dan Struktur Data',
                'description' => 'Pengenalan dasar algoritma dan struktur data',
                'category' => 'Pemrograman',
                'thumbnail' => 'java.png',
                'rating' => 4.2,
                'created_at' => '2024-02-10',
                'creator' => [
                    'id' => 1,
                    'name' => 'Aristoteles',
                    'image' => 'person1.png'
                ]
            ],
            [
                'id' => 4,
                'title' => 'Kalkulus Dasar',
                'description' => 'Pengenalan konsep dasar kalkulus',
                'category' => 'Matematika',
                'thumbnail' => 'math.png',
                'rating' => 4.7,
                'created_at' => '2024-02-05',
                'creator' => [
                    'id' => 3,
                    'name' => 'Emma Watson',
                    'image' => 'person3.png'
                ]
            ]
        ];
    }
    
    public function getByCreator($creatorId) {
        $notes = $this->getAllNote();
        
        $creatorNotes = [];
        foreach ($notes as $note) {
            if ($note['creator']['id'] == $creatorId) {
                $creatorNotes[] = $note;
            }
        }
        
        return $creatorNotes;
    }
}