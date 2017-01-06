<?php

class TournamentController extends BaseController {

    public static function create() {
        self::check_logged_in();
        View::make('/tournament/new.html');
    }

    public static function delete($id) {
        self::check_logged_in();
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            $tourney->delete();
            Redirect::to("/tournament", array('message' => "Tournament deleted"));
        } else {
            throw new Exception($message = 'Tournament not found');
        }
    }

    public static function details($id) {
        self::check_logged_in();
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            View::make('/tournament/details.html', array(
                'tourney' => $tourney,
                'participation' =>
                Participation::find(self::get_player_logged_in()->player_id, $id))
            );
        } else {
            throw new Exception($message = 'Tournament not found!');
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            View::make('tournament/edit.html', array('tourney' => $tourney));
        } else {
            throw new Exception($message = 'Tournament not found!');
        }
    }

    public static function index() {
        self::check_logged_in();
        $tourneys = Tournament::all();
        View::make('tournament/index.html', array('tourneys' => $tourneys));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = self::argumentsForTourney($params);
        $tourney = new Tournament($attributes);
        $errors = $tourney->errors();


        if (count($errors) > 0) {
            Redirect::to('/tournament/new', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tourney->save();
            Redirect::to('/tournament/' . $tourney->tournament_id, array('message' => 'Tournament has been added.'));
        }
    }

    private static function argumentsForTourney($params) {

        return array(
            'organizer' => BaseController::get_player_logged_in()->player_id,
            'tname' => $params['name'],
            'start_date' => $params['start'],
            'end_date' => $params['end'],
            'game_format' => $params['gameform'],
            'tournament_format' => $params['tourform'],
            'participants' => 0,
            'capacity' => intval($params['cap']),
            'details' => $params['details'],
            'modified' => date('Y/m/d')
        );
    }

    private static function updatedArguments($params) {
        return array(
            'tournament_id' => $id,
            'tname' => $params['name'],
            'start_date' => $params['start'],
            'end_date' => $params['end'],
            'game_format' => $params['gameform'],
            'tournament_format' => $params['tourform'],
            'capacity' => intval($params['cap']),
            'details' => $params['details'],
            'modified' => date('Y/m/d')
        );
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;

        $attributes = self::updatedArguments($params);
        $tourney = new Tournament($attributes);
        $errors = $tourney->errors();

        if (count($errors) == 0) {
            $tourney->update();
            Redirect::to('/tournament/' . $tourney->tournament_id, array('message' => 'Tournament has been edited'));
        } else {
            View::make('tournament/edit.html', array('errors' => $errors, 'tourney' => $tourney));
        }
    }

}
