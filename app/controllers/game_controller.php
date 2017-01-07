<?php

class GameController extends BaseController {

    public static function create() {
        self::check_logged_in();
        View::make('game/new.html', array(
            'participations' =>
            Participation::participations(self::get_player_logged_in()->player_id)));
    }

    public static function delete($id) {
        self::check_logged_in();
        $game = Game::find($id);
        if ($game != NULL) {
            if (BaseController::get_player_logged_in()->player_id == $game->player) {
                $game->delete();
                Redirect::to('/game', array('message' => 'Game has been deleted'));
            } else {
                Redirect::to('/', array('message' => 'You can only delete your own games'));
            }
        } else {
            Redirect::to('/game', array('message' => 'Game not found!'));
        }
    }

    public static function details($id) {
        self::check_logged_in();
        $game = Game::find($id);
        if ($game != NULL) {
            if (BaseController::get_player_logged_in()->player_id == $game->player) {
                $tournament = Tournament::find($game->tournament);
                View::make('game/details.html', array('game' => $game, 'tournament' => $tournament));
            } else {
                Redirect::to('/game', array('message' => 'You can only watch your own game data!'));
            }
        } else {
            Redirect::to('/game', array('message' => 'Game not found!'));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $game = Game::find($id);
        if ($game != NULL) {
            if (BaseController::get_player_logged_in()->player_id == $game->player) {
                View::make('game/edit.html', array(
                    'game' => $game,
                    'participations' =>
                    Participation::participations(self::get_player_logged_in()->player_id)));
            } else {
                Redirect::to('/game', array('message' => 'You can only edit your own games!'));
            }
        } else {
            Redirect::to('/game', array('message' => 'Game not found!'));
        }
    }

    public static function history() {
        self::check_logged_in();
        $games = Game::allPlayedByUser(self::get_player_logged_in()->player_id);
        View::make('game/history.html', array('games' => $games));
    }

    private static function setAttributes($params) {
        return array(
            'player' => self::get_player_logged_in()->player_id,
            'tournament' => $params['tournament'],
            'game_date' => $params['game_date'],
            'opponent' => $params['opponent'],
            'game_result' => $params['result'],
            'notes' => $params['notes'],
            'modified' => date('Y/m/d')
        );
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        if (!array_key_exists('result', $params)) {
            $params['result'] = 'not set';
        }

        $attributes = self::setAttributes($params);
        $game = new Game($attributes);
        $errors = $game->errors();

        if (count($errors) == 0) {
            $game->save();
            Redirect::to('/game/' . $game->game_id, array('message' => 'Game has been added'));
        } else {
            View::make('game/new.html', array('errors' => $errors, 'game' => $attributes,
                'participations' =>
                Participation::participations(self::get_player_logged_in()->player_id)));
        }
    }

    public static function update($id) {
        $params = $_POST;
        $attributes = self::updateAttributes($params, $id);
        $game = new Game($attributes);
        $errors = $game->errors();

        if (count($errors) == 0) {
            $game->update();
            Redirect::to('/game/' . $game->game_id, array('message' => 'Game has been edited!'));
        } else {
            View::make('game/edit.html', array('errors' => $errors, 'game' => $attributes,
                'participations' =>
                Participation::participations(self::get_player_logged_in()->player_id)));
        }
    }

    private static function updateAttributes($params, $id) {
        return array(
            'player' => self::get_player_logged_in()->player_id,
            'game_id' => $id,
            'tournament' => $params['tournament'],
            'game_date' => $params['game_date'],
            'opponent' => $params['opponent'],
            'game_result' => $params['result'],
            'notes' => $params['notes'],
            'modified' => date('Y/m/d')
        );
    }

}
