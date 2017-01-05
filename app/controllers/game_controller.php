<?php

class GameController extends BaseController {

    public static function create() {
        self::check_logged_in();
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
        self::check_logged_in();
        $game = Game::find($id);
        if ($game != NULL) {
            View::make('game/details.html', array('game' => $game));
        } else {
            throw new Exception($message = 'Game not found');
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $game = Game::find($id);
        if ($game != NULL) {
            View::make('game/edit.html', array('game' => $game));
        } else {
            throw new Exception($message = 'Game not found');
        }
    }

    public static function history() {
        self::check_logged_in();
        $games = Game::allPlayedByUser(self::get_player_logged_in()->player_id);
        View::make('game/history.html', array('games' => $games));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $result = null;

        if (in_array('result', $params)) {
            $result = $params['result'];
        }

        $attributes = array(
            'player' => self::get_player_logged_in()->player_id,
            'tournament' => $params['tournament'],
            'game_date' => $params['game_date'],
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
            View::make('game/new.html', array('errors' => $errors, 'game' => $attributes));
        }
    }

    public static function update($id) {
        $params = $_POST;

        $attributes = array(
            'player' => self::get_player_logged_in()->player_id,
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
