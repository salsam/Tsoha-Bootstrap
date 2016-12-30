<?php

class Tournament extends BaseModel {

    public $tournament_id, $organizer, $tname, $start_date, $end_date, $game_format,
            $tournament_format, $participants, $capacity, $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tournament');
        $query->execute();
        $rows = $query->fetchAll();
        $tourneys = array();

        foreach ($rows as $row) {
            $tourneys[] = new Tournament(array(
                'tournament_id' => $row['tournament_id'],
                'organizer' => $row['organizer'],
                'tname' => $row['tname'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'game_format' => $row['game_format'],
                'tournament_format' => $row['tournament_format'],
                'participants' => $row['participants'],
                'capacity' => $row['capacity'],
                'modified' => $row['modified']
            ));
        }

        return $tourneys;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tournament '
                . 'WHERE tournament_id=:id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tourney = new Tournament(array(
                'tournament_id' => $row['tournament_id'],
                'organizer' => $row['organizer'],
                'tname' => $row['tname'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'game_format' => $row['game_format'],
                'tournament_format' => $row['tournament_format'],
                'participants' => $row['participants'],
                'capacity' => $row['capacity'],
                'modified' => $row['modified']
            ));
            return $tourney;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tournament (organizer, tname, '
                . 'start_date, end_date, game_format, tournament_format, '
                . 'participants, capacity, modified) '
                . 'VALUES (:org, :name, :start, :end, :gameform, :tournform, '
                . ':part, :cap, :mod) RETURNING tournament_id');
        $query->execute(array(
            'org' => $this->organizer,
            'name' => $this->tname,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'gameform' => $this->game_format,
            'tournform' => $this->tournament_format,
            'part' => $this->participants,
            'cap' => $this->capacity,
            'mod' => $this->modified
        ));
        $row = $query->fetch();
        $this->tournament_id = $row['tournament_id'];
    }

}
