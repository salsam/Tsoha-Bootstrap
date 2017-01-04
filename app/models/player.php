<?php

class Player extends BaseModel {

    public $player_id, $pname, $password, $email, $organizer;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password', 'validate_email');
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

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Player '
                . 'WHERE pname=:name AND password=:pass LIMIT 1');
        $query->execute(array('name' => $username, 'pass' => $password));
        $row=$query->fetch();
        
        if ($row) {
            $player = new Player(array(
                'player_id' => $row['player_id'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email'],
                'organizer' => $row['organizer']
            ));
            return $player;
        } else {
            return null;
        }
    }

    public function delete() {
        try {
            $query = DB::connection()->prepare('DELETE FROM Player WHERE player_id=:id');
            $query->execute(array('id' => $this->player_id));
            echo 'Player deleted successfully';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
        return array_merge($this->validate_string_length($this->password, 20), $this->validate_string_min($this->password, 5));
    }

    public function validate_email() {
        return $this->validate_string_length($this->email, 30);
    }

    public function validate_organizer() {
        $errors = array();

        if (!is_bool($this->organizer)) {
            $errors[] = 'Organizer must be true or false';
        }

        return $errors;
    }

}
