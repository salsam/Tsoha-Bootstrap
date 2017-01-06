<?php

class PlayerController extends BaseController {

    public static function create() {
        View::make('player/new.html');
    }

    public static function delete($id) {
        self::check_logged_in();
        $player = Player::find($id);

        if ($player != null) {
            $player->delete();
            unset($player);
            Redirect::to('/player', array('message' => 'Player has been deleted'));
        } else {
            throw new Exception(array('message' => 'Player not found'));
        }
    }

    public static function handle_login() {
        $params = $_POST;

        $player = Player::authenticate($params['username'], $params['password']);

        if (!$player) {
            View::make('player/login.html', array('error' => 'Wrong username or password!'
                , 'username' => $params['username']));
        } else {
            $_SESSION['player'] = $player->player_id;
            Redirect::to('/', array('message' => 'Welcome back ' . $player->pname . '!'));
        }
    }

    public static function login() {
        View::make('player/login.html');
    }

    public static function logout() {
        $_SESSION['player'] = null;
        Redirect::to('/', array('message' => 'You have been successfully logged out! Have a nice day!'));
    }

    public static function storePlayer() {
        $params = $_POST;

        $attributes = array(
            'pname' => $params['pname'],
            'password' => $params['pword'],
            'email' => $params['email'],
            'organizer' => False
        );

        $player = new Player($attributes);
        $errors = $player->errors();

        if (count($errors) == 0) {
            $player->save();
            Redirect::to('/', array('message', 'Player has been added!'));
        } else {
            View::make('player/new.html', array(
                'errors' => $errors,
                'attributes' => $attributes));
        }
    }

}
