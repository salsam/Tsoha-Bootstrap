<?php

class Participation extends BaseModel {

    public $tournament, $player, $entry_date;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Participation WHERE player=:id');
        $query->execute(array('id' => $_SESSION['player']));
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Participation '
                . '(tournament, player, entry_date) VALUES (:tournament, :player, :entry_date)');
        $query->execute(array(
            'tournament' => $this->entry_date,
            'player' => $this->player,
            'entry_date' => $this->entry_date));
    }

}
