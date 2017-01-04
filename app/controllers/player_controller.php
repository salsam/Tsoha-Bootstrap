<?php

class PlayerController extends BaseController {

    public static function create() {
        View::make('player/new.html');
    }

    public static function delete($id) {
        $player = Player::find($id);

        if ($player != null) {
            $player->delete();
            unset($player);
            Redirect::to('/player', array('message' => 'Player has been deleted'));
        } else {
            throw new Exception(array('message' => 'Player not found'));
        }
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'pname' => $params['pname'],
            'password' => $params['pword'],
            'email' => $params['email'],
            'organizer' => FALSE
        );

        $player = new Player($attributes);
        $errors = $player->errors();

        if (count($errors) == 0) {
            $player->save();
            Redirect::to('', array('message', 'Player has been added!'));
        } else {
            View::make('player/new.html', array(
                'errors' => $errors,
                'attributes' => $attributes));
        }
    }

}
