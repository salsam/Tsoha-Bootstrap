<?php

class PlayerController extends BaseController {

    public static function create() {
        View::make('player/new.html');
    }

    public static function delete($id) {
        self::check_logged_in();
        $player = Player::find($id);

        if ($player != null) {
            if (self::get_player_logged_in()->player_id == $id) {
                $player->delete();
                Redirect::to('/', array('message' => 'Player has been deleted'));
            } else {
                Redirect::to('/', array('message' => "You are only allowed to delete you own profile!"));
            }
        } else {
            Redirect::to('/', array('message' => 'Player not found!'));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $player = Player::find($id);

        if ($player) {
            if (self::get_player_logged_in()->player_id == $id) {
                View::make('player/edit.html', array('player' => $player));
            } else {
                Redirect::to('/', array('message' => 'You can only edit your own profile!'));
            }
        } else {
            Redirect::to('/', array('message' => 'Player not found!'));
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

    public static function show($id) {
        self::check_logged_in();
        $player = Player::find($id);

        if ($player) {
            View::make('player/profile.html', array('player' => $player));
        } else {
            Redirect::to('/', array('message' => 'Player not found!'));
        }
    }

    public static function storePlayer() {
        $params = $_POST;
        $player = self::playerFromRow($params);
        $errors = $player->errors();

        if (count($errors) == 0) {
            try {
                $player->save();
                Redirect::to('/', array('message', 'Player has been added!'));
            } catch (PDOException $e) {
                self::handleUniqueness($player);
            }
        } else {
            View::make('player/new.html', array(
                'errors' => $errors,
                'player' => $player));
        }
    }

    private static function handleUniqueness($player) {
        $errors = array();

        if (Player::checkEmailAvailability($player->email)) {
            $errors[] = "There is already a user registered with given email.";
        }

        if (Player::checkNameAvailability($player->pname)) {
            $errors[] = "Username has been taken. Please choose different name!";
        }

        View::make('player/new.html', array(
            'errors' => $errors,
            'player' => $player));
    }

    private static function playerFromRow($row) {
        return new Player(array(
            'pname' => $row['pname'],
            'password' => $row['pword'],
            'email' => $row['email']
        ));
    }

}
