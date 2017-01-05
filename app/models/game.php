<?php

class Game extends BaseModel {

    public $game_id, $player, $tournament, $game_date, $opponent, $game_result,
            $notes, $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_game_date', 'validate_opponent',
            'validate_tournament');
    }

    public static function allPlayedByUser($id) {
        $query = DB::connection()->prepare('SELECT * FROM Game WHERE player=:id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $games = array();

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $games[] = new Game(array(
                    'game_id' => $row['game_id'],
                    'player' => $row['player'],
                    'tournament' => $row['tournament'],
                    'game_date' => $row['game_date'],
                    'opponent' => $row['opponent'],
                    'game_result' => $row['game_result'],
                    'notes' => $row['notes'],
                    'modified' => $row['modified']
                ));
            }
        }

        return $games;
    }

    public function delete() {
        try {
            $query = DB::connection()->prepare('DELETE FROM Game WHERE game_id=:id');
            $query->execute(array('id' => $this->game_id));
            echo 'Game deleted successfully!';
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
                'game_date' => $row['game_date'],
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
                . 'game_date, opponent, game_result, notes, modified) '
                . 'VALUES (:player, :tournament, :game_date, :opponent, :result, '
                . ':notes, :modifie) RETURNING game_id');
        $query->execute(array(
            'player' => $this->player,
            'tournament' => $this->tournament,
            'game_date' => $this->game_date,
            'opponent' => $this->opponent,
            'result' => $this->game_result,
            'notes' => $this->notes,
            'modifie' => $this->modified
        ));
        $row = $query->fetch();
        $this->game_id = $row['game_id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Game SET (player, tournament, '
                . 'game_date, opponent, game_result, notes, modified) '
                . '=(:player, :tournament, :game_date, :opponent, :result, '
                . ':notes, :modified) WHERE game_id=:id');
        $query->execute(array(
            'player' => $this->player,
            'tournament' => $this->tournament,
            'game_date' => $this->game_date,
            'opponent' => $this->opponent,
            'result' => $this->game_result,
            'notes' => $this->notes,
            'modified' => $this->modified,
            'id' => $this->game_id
        ));
    }

    public function validate_game_date() {
        return $this->validate_past_date($this->game_date, "Game date must be earlier or today");
    }

    public function validate_opponent() {
        return $this->validate_string_length($this->opponent, 20, "Opponent");
    }

    public function validate_player() {
        return $this->validate_number($this->player, "Player");
    }

    public function validate_tournament() {
        return $this->validate_number($this->tournament, "Tournament");
    }

}
