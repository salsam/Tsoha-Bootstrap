<?php

class Player extends BaseModel {

    public $player_id, $pname, $password, $email, $organizer;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Player');
        $query->execute();
        $rows = $query->fetchAll();
        $players = array();

        foreach ($rows as $row) {
            $players[] = new Player(array(
                'player_id' => $row['player_id'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email'],
                'organizer' => $row['organizer']));
        }

        return $players;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE player_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $player = new Player(array(
                'player_id' => $row['player_id'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email'],
                'organizer' => $row['organizer']
            ));
            return $player;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Player (pname, password, email, organizer) '
                . 'VALUES (:name, :pass, :email, :organizer) RETURNING player_id');
        $query->execute(array(
            'name' => $this->pname,
            'pass' => $this->password,
            'email' => $this->email,
            'organizer' => $this->organizer
        ));
        $row = $query->fetch();
        $this->player_id = $row['player_id'];
    }

    public function validate_name() {
        return $this->validate_string_length($this->pname, 20);
    }
    
    public function validate_password() {
        return $this->validate_string_length($this->password, 20);
    }
    
    public function validate_email() {
        $errors=array();
        
        
        
        return $errors;
    }

}
