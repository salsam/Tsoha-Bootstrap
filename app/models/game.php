<?php

class Game extends BaseModel {

    public $game_id, $player, $tournament, $played, $opponent, $game_result, $moves,
            $notes, $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Game');
        $query->execute();
        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new Game(array(
                'game_id' => $row['game_id'],
                'player' => $row['player'],
                'tournament' => $row['tournament'],
                'played' => $row['played'],
                'opponent' => $row['opponent'],
                'game_result' => $row['game_result'],
                'moves' => $row['moves'],
                'notes' => $row['notes'],
                'modified' => $row['modified']
            ));
        }

        return $games;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Game WHERE game_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $player = new Game(array(
                'game_id' => $row['game_id'],
                'player' => $row['player'],
                'tournament' => $row['tournament'],
                'played' => $row['played'],
                'opponent' => $row['opponent'],
                'game_result' => $row['game_result'],
                'moves' => $row['moves'],
                'notes' => $row['notes'],
                'modified' => $row['modified']
            ));
            return $player;
        }

        return null;
    }

}
