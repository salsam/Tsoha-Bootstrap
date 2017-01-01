<?php

class Tournament extends BaseModel {

    public $tournament_id, $organizer, $tname, $start_date, $end_date, $game_format,
            $tournament_format, $participants, $capacity, $details, $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_start');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tournament');
        $query->execute();
        $rows = $query->fetchAll();
        $tourneys = array();

        if (!empty($rows)) {
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
                    'details' => $row['details'],
                    'modified' => $row['modified']
                ));
            }
        }

        return $tourneys;
    }

    public function delete() {
        try {
            $query = DB::connection()->prepare('DELETE FROM Tournament WHERE tournament_id=:id');
            $query->execute(array('id' => $this->tournament_id));
            unset($this);
            echo 'Tournament deleted successfully';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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
                'details' => $row['details'],
                'modified' => $row['modified']
            ));
            return $tourney;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tournament (organizer, tname, '
                . 'start_date, end_date, game_format, tournament_format, '
                . 'participants, capacity, details, modified) '
                . 'VALUES (:org, :name, :start, :end, :gameform, :tourform, '
                . ':part, :cap, :details, :mod) RETURNING tournament_id');
        $query->execute(array(
            'org' => intval($this->organizer),
            'name' => $this->tname,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'gameform' => $this->game_format,
            'tourform' => $this->tournament_format,
            'part' => intval($this->participants),
            'cap' => intval($this->capacity),
            'details' => $this->details,
            'mod' => $this->modified
        ));

        $row = $query->fetch();
        $this->tournament_id = $row['tournament_id'];
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Tournament SET (tname, '
                . 'start_date, end_date, game_format, tournament_format, '
                . 'capacity, details, modified) '
                . '= (:name, :start, :end, :gameform, :tourform, '
                . ':cap, :details, :mod)');
        $query->execute(array(
            'name' => $this->tname,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'gameform' => $this->game_format,
            'tourform' => $this->tournament_format,
            'cap' => $this->capacity,
            'details' => $this->details,
            'mod' => $this->modified
        ));
    }
    
    

    public function validate_start() {
        return $this->validate_future_date($this->start_date);
    }

}
