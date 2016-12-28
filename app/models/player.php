<?php

class Player extends BaseModel {

    public $player_id, $pname, $password, $email;

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
                'email' => $row['email']));
        }

        return $players;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE player_id = :id LIMIT 1');
        $query->bindParam(':id', $id);
        $query->execute();
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

}
