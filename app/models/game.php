<?php

class Game extends BaseModel {

    public $game_id, $player, $tournament, $played, $opponent, $game_result,
            $notes, $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_played', 'validate_opponent',
             'validate_tournament');
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
                'notes' => $row['notes'],
                'modified' => $row['modified']
            ));
        }

        return $games;
    }

    public function delete() {
        try {
            $query = DB::connection()->prepare('DELETE FROM Game WHERE game_id=:id');
            $query->execute(array('id' => $this->game_id));
            unset($this);
            echo 'Record deleted successfully!';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
                'notes' => $row['notes'],
                'modified' => $row['modified']
            ));
            return $player;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Game (player, tournament, '
                . 'played, opponent, game_result, notes, modified) '
                . 'VALUES (:player, :tournament, :played, :opponent, :result, '
                . ':notes, :modified) RETURNING game_id');
        $query->execute(array(
            'player' => $this->player,
            'tournament' => $this->tournament,
            'played' => $this->played,
            'opponent' => $this->opponent,
            'result' => $this->game_result,
            'notes' => $this->notes,
            'modified' => $this->modified
        ));
        $row = $query->fetch();

        $this->game_id = $row['game_id'];
    }

    public function validate_played() {
        return $this->validate_past_date($this->played);
    }

    public function validate_opponent() {
        return $this->validate_string_length($this->opponent, 20);
    }

    public function validate_player() {
        return $this->validate_number($this->player);
    }

    public function validate_tournament() {
        return $this->validate_number($this->tournament);
    }

}
