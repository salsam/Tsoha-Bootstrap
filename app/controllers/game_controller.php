<?php

class GameController extends BaseController {

    public static function create() {
        View::make('game/new.html');
    }

    public static function delete($id) {
        $game = Game::find($id);
        if ($game != NULL) {
            $game->delete();
        } else {
            throw new Exception($message = 'Game not found!');
        }
        Redirect::to('/game', array('message', 'Game has been deleted'));
    }

    public static function details($id) {
        $game = Game::find($id);
        if ($game != NULL) {
            View::make('game/details.html', array('game' => $game));
        } else {
            throw new Exception($message = 'Game not found');
        }
    }

    public static function edit($id) {
        $game = Game::find($id);
        if ($game != NULL) {
            View::make('game/edit.html', array('game' => $game));
        } else {
            throw new Exception($message = 'Game not found');
        }
        Redirect::to('/game/' . $game->game_id, array('message', 'Game has been edited'));
    }

    public static function history() {
        $games = Game::all();
        View::make('game/history.html', array('games' => $games));
    }

    public static function store() {
        $params = $_POST;

        if (array_key_exists('victory', $params)) {
            $result = 'victory';
        } else if (array_key_exists('draw', $params)) {
            $result = 'draw';
        } else {
            $result = 'loss';
        }

        $attributes = array(
            'tournament' => $params['tournament'],
            'played' => $params['played'],
            'opponent' => $params['opponent'],
            'game_result' => $result,
            'notes' => $params['notes'],
            'modified' => date('Y/m/d')
        );

        $game = new Game($attributes);
        $errors = $game->errors();

        if (count($errors) == 0) {
            $game->save();
            Redirect::to('/game/' . $game->game_id, array('message' => 'Game has been added'));
        } else {
            View::make('game/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function update() {
        
    }

}
