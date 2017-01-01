<?php

class TournamentController extends BaseController {

    public static function create() {
        View::make('/tournament/new.html');
    }

    public static function delete($id) {
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            $tourney->delete();
            Redirect::to("/tournament", array('message' => "Tournament deleted"));
        } else {
            throw new Exception($message = 'Tournament not found');
        }
    }

    public static function details($id) {
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            View::make('/tournament/details.html', array('tourney' => $tourney));
        } else {
            throw new Exception($message = 'Tournament not found!');
        }
    }

    public static function edit($id) {
        $tourney = Tournament::find($id);
        if ($tourney != NULL) {
            View::make('tournament/edit.html', array('tourney' => $tourney));
        } else {
            throw new Exception($message = 'Tournament not found!');
        }
    }

    public static function index() {
        $tourneys = Tournament::all();
        View::make('tournament/index.html', array('tourneys' => $tourneys));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'organizer' => intval($params['org']),
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

        $tourney = new Tournament($attributes);
        $errors = $tourney->errors();


        if (count($errors) > 0) {
            Redirect::to('tournament/new.html', array('errors' => $errors, 'attributes' => $attributes));
        } else {
            $tourney->save();
            Redirect::to('/tournament/' . $tourney->tournament_id, array('message' => 'Tournament has been added.'));
        }
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
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
