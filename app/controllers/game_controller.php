<?php

class GameController extends BaseController {

    public static function create() {
        View::make('game/new.html');
    }

    public static function delete($id) {
        $game = Game::find($id);
        if ($game != NULL) {
            $game->delete();
            Redirect::to('/game', array('message' => 'Game has been deleted'));
        } else {
            throw new Exception($message = 'Game not found!');
        }
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
    }

    public static function history() {
        $games = Game::all();
        View::make('game/history.html', array('games' => $games));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'player' => BaseController::get_user_logged_in()->player_id,
            'tournament' => $params['tournament'],
            'game_date' => $params['game_date'],
            'opponent' => $params['opponent'],
            'game_result' => $params['result'],
            'notes' => $params['notes'],
            'modified' => date('Y/m/d')
        );

        $game = new Game($attributes);
        $errors = $game->errors();

        if (count($errors) == 0) {
            $game->save();
            Redirect::to('/game/' . $game->game_id, array('message' => 'Game has been added'));
        } else {
            View::make('game/new.html', array('errors' => $errors, 'game' => $attributes));
        }
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'game_id' => $id,
            'tournament' => $params['tournament'],
            'game_date' => $params['game_date'],
            'opponent' => $params['opponent'],
            'game_result' => $params['result'],
            'notes' => $params['notes'],
            'modified' => date('Y/m/d')
        );

        $game = new Game($attributes);
        $errors = $game->errors();

        if (count($errors) == 0) {
            $game->update();
            Redirect::to('/game/' . $game->game_id, array('message' => 'Game has been edited!'));
        } else {
            View::make('game/edit.html', array('errors' => $errors, 'game' => $game));
        }
    }

}
