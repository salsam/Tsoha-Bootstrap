<?php

class Tournament extends BaseModel {

    public $tournament_id,
            $organizer,
            $tname,
            $start_date,
            $end_date,
            $game_format,
            $tournament_format,
            $participants,
            $capacity,
            $details,
            $modified;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_start', 'validate_end', 'validate_duration',
            'validate_capacity', 'validate_name');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tournament');
        $query->execute();
        $rows = $query->fetchAll();
        $tourneys = array();

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $tourneys[] = self::tournamentFromRow($row, null);
            }
        }

        return $tourneys;
    }

    public function delete() {
        try {
            $query = DB::connection()->prepare('DELETE FROM Tournament WHERE tournament_id=:id');
            $query->execute(array('id' => $this->tournament_id));
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT tournament_id, organizer, '
                . 'tname,start_date, end_date,game_format, tournament_format,'
                . 'count(player) AS participants, capacity, details, modified '
                . 'FROM Tournament LEFT JOIN Participation '
                . 'ON Tournament.tournament_id=Participation.tournament '
                . 'WHERE tournament_id=:id '
                . 'GROUP BY tournament_id,organizer, tname, start_date, end_date, '
                . 'game_format, tournament_format, capacity, details, modified');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $tourney = self::tournamentFromRow($row, $row['participants']);
            return $tourney;
        }
        return null;
    }

    public static function findByName($name) {
        $query = DB::connection()->prepare('SELECT tournament_id, organizer, '
                . 'tname,start_date, end_date,game_format, tournament_format,'
                . 'count(player) AS participants, capacity, details, modified '
                . 'FROM Tournament LEFT JOIN Participation '
                . 'ON Tournament.tournament_id=Participation.tournament '
                . 'WHERE tname=:name '
                . 'GROUP BY tournament_id,organizer, tname, start_date, end_date, '
                . 'game_format, tournament_format, capacity, details, modified');
        $query->execute(array('name' => $name));
        $row = $query->fetch();

        if ($row) {
            $tourney = self::tournamentFromRow($row, $row['participants']);
            return $tourney;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tournament (organizer, tname, '
                . 'start_date, end_date, game_format, tournament_format, '
                . 'capacity, details, modified) '
                . 'VALUES (:org, :name, :start, :end, :gameform, :tourform, '
                . ':cap, :details, :mod) RETURNING tournament_id');
        $query->execute(array(
            'org' => intval($this->organizer),
            'name' => $this->tname,
            'start' => $this->start_date,
            'end' => $this->end_date,
            'gameform' => $this->game_format,
            'tourform' => $this->tournament_format,
            'cap' => intval($this->capacity),
            'details' => $this->details,
            'mod' => $this->modified
        ));

        $row = $query->fetch();
        $this->tournament_id = $row['tournament_id'];
    }

    public static function tournamentFromRow($row, $participants) {
        return new Tournament(array(
            'tournament_id' => $row['tournament_id'],
            'organizer' => $row['organizer'],
            'tname' => $row['tname'],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'game_format' => $row['game_format'],
            'tournament_format' => $row['tournament_format'],
            'participants' => $participants,
            'capacity' => $row['capacity'],
            'details' => $row['details'],
            'modified' => $row['modified']
        ));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Tournament SET (tname, '
                . 'start_date, end_date, game_format, tournament_format, '
                . 'capacity, details, modified) '
                . '= (:name, :start, :end, :gameform, :tourform, '
                . ':cap, :details, :mod) WHERE tournament_id=:id');
        $query->execute(array(
            'id' => $this->tournament_id,
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
        return $this->validate_future_date($this->start_date, "Tournament start date must be in the future!");
    }

    public function validate_end() {
        return $this->validate_future_date($this->start_date, "Tournament end date must be in the future!");
    }

    public function validate_duration() {
        $errors = array();
        if (count($errors) == 0) {
            if (strtotime($this->end_date) < strtotime($this->start_date)) {
                $errors[] = "Start date must be smaller or equal than end date";
            }
        }
        return $errors;
    }

    public function validate_capacity() {
        $errors = $this->validate_number($this->capacity, "Capacity");

        if ($this->capacity < 2 || $this->capacity > 1000) {
            $errors[] = 'Capacity must be between 2 and 1000';
        }

        return $errors;
    }

    public function validate_name() {
        $errors = array_merge($this->validate_string_length($this->tname, 20, "Name")
                , $this->validate_string_min($this->tname, 1, "Name"));
        $errors = array_merge($errors, $this->validate_not_whitespace($this->tname, "Name"));

        $match = self::findByName($this->tname);
        if ($match && $this->tournament_id != $match->tournament_id) {
            $errors[] = 'Name has been taken. Please try different name!';
        }

        return $errors;
    }

}
