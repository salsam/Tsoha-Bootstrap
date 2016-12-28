<?php

class GameController extends BaseController {

    public static function history() {
        $games = Game::all();
        View::make('game/history.html', array('games' => $games));
    }

    public static function details($id) {
        $game = Game::find($id);
        if ($game != NULL) {
            View::make('game/details.html', array('game' => $game));
        } else {
            throw new Exception($message = 'Game not found');
        }
    }

}
