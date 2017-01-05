<?php

class Participation extends BaseModel {

    public $tournament, $player, $entry_date;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators=array();
    }

    public static function allByUser($id) {
        $query = DB::connection()->prepare('SELECT * FROM Participation WHERE player=:id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $participations = array();

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $participations[] = new Participation(array(
                    'tournament' => $row['tournament'],
                    'player' => $row['player'],
                    'entry_date' => $row['entry_date']
                ));
            }
        }

        return $participations;
    }

    public static function delete($player, $tournament) {
        $query = DB::connection()->prepare('DELETE FROM Participation '
                . 'WHERE player=:player AND tournament=:tournament');
        $query->execute(array('player' => $player, 'tournament' => $tournament));
    }

    public static function find($player, $tournament) {
        $query = DB::connection()->prepare('SELECT * FROM Participation WHERE '
                . 'player=:player AND tournament=:tournament LIMIT 1');
        $query->execute(array('player' => $player, 'tournament' => $tournament));
        $row = $query->fetch();
        if ($row) {
            return new Participation(array(
                'tournament' => $row['tournament'],
                'player' => $row['player'],
                'entry_date' => $row['entry_date']
            ));
        } else {
            return null;
        }
    }

    public static function tournamentsParticipatedIn($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tournament INNER JOIN Participation '
                . 'ON Tournament.tournament_id=Participation.tournament '
                . 'WHERE Participation.player=:id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $tourneys = array();

        if ($rows) {
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Participation '
                . '(tournament, player, entry_date) VALUES (:tournament, :player, :entry_date)');
        $query->execute(array(
            'tournament' => $this->tournament,
            'player' => $this->player,
            'entry_date' => $this->entry_date));
    }

}
