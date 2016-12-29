<?php

class PlayerController extends BaseController {

    public static function create() {
        View::make('player/new.html');
    }

    public static function store() {
        $params = $_POST;

        $player = new Player(array(
            'pname' => $params['pname'],
            'password' => $params['pword'],
            'email' => $params['email']
        ));

        $player->save();
        Redirect::to('/player/' . $player->player_id, array('message', 'Player has been added!'));
    }

}
