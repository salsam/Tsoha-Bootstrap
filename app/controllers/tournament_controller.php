<?php

class TournamentController extends BaseController {

    public static function create() {
        View::make('/tournament/new.html');
    }

    public static function details($id) {
        $tourney = Tournament::find($id);
        if ($tourney) {
            View::make('/tournament/details.html', array('tourney' => $tourney));
        } else {
            throw new Exception('Tournament not found!');
        }
    }

    public static function index() {
        $tourneys = Tournament::all();
        View::make('tournament/index.html', array('tourneys' => $tourneys));
    }

    public static function store() {
        $params = $_POST;

        $tourney = new Tournament(array(
            'organizer' => $params['org'],
            'tname' => $params['name'],
            'start_date' => $params['start'],
            'end_date' => $params['end'],
            'game_format' => $params['gameform'],
            'tournament_format' => $params['tourform'],
            'participants' => 0,
            'capacity' => $params['cap'],
            'modified' => date('Y/m/d')
        ));

        $tourney->save();
        Redirect::to('/tournament/' . $tourney->tournament_id, 'Tournament has been added.');
    }

}
