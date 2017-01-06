<?php

class ParticipationController extends BaseController {

    public static function delete($tournament) {
        self::check_logged_in();
        $participation = Participation::find(self::get_player_logged_in()->player_id, $tournament);

        if ($participation) {
            try {
                Participation::delete(self::get_player_logged_in()->player_id, $tournament);
                Redirect::to('/participation', array('message' => 'Participation has been deleted'));
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public static function index() {
        self::check_logged_in();
        $participations = Participation::participations(self::get_player_logged_in()->player_id);
        $player = Player::find(self::get_player_logged_in()->player_id);
        View::make('/participation/index.html', array('participated' => $participations, 'player' => $player));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'tournament' => $params['tournament'],
            'player' => self::get_player_logged_in()->player_id,
            'entry_date' => date('Y/m/d')
        );

        $participation = new Participation($attributes);
        $errors = $participation->errors();

        if (count($errors) == 0) {
            $participation->save();
            Redirect::to('/participation', array('message' => 'Participation has been added'));
        } else {
            throw new Exception("Tournament can't be joined");
        }
    }

}
