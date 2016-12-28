<?php

class Player extends BaseModel {

    public $playerID, $pname, $password, $email;

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
                'playerID' => $row['playerID'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email']));
        }

        return $players;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Player WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $player = new Player(array(
                'playerID' => $row['playerID'],
                'pname' => $row['pname'],
                'password' => $row['password'],
                'email' => $row['email']
            ));
            return $player;
        }

        return null;
    }

}
