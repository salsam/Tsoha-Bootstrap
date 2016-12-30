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
            'email' => $params['email'],
            'organizer' => 'f'
        ));

        $player->save();
        Redirect::to('', array('message', 'Player has been added!'));
    }

}
