<?php

class Player extends BaseModel {

    public $player_id, $pname, $password, $email;

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
                'email' => $row['email']
            ));
        }

        return $players;
    }

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Player '
                . 'WHERE pname=:name AND password=:pass LIMIT 1');
        $query->execute(array('name' => $username, 'pass' => $password));
        $row = $query->fetch();

        if ($row) {
            $player = new Player(array(
                'player_id' => $row['player_id'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email']
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
                'email' => $row['email']
            ));
            return $player;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Player (pname, password, email) '
                . 'VALUES (:name, :pass, :email) RETURNING player_id');
        $query->bindValue('name', $this->pname, PDO::PARAM_STR);
        $query->bindValue('pass', $this->password, PDO::PARAM_STR);
        $query->bindValue('email', $this->email, PDO::PARAM_STR);
        $query->execute();

        $row = $query->fetch();
        $this->player_id = $row['player_id'];
    }

    public function validate_name() {
        return $this->validate_string_length($this->pname, 20, "Name");
    }

    public function validate_password() {
        return array_merge($this->validate_string_length($this->password, 20, "Password"), $this->validate_string_min($this->password, 5, "Password"));
    }

    public function validate_email() {
        return $this->validate_string_length($this->email, 30, "Email");
    }

}
