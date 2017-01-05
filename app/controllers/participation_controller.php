<?php

class ParticipationController extends BaseController {

    public static function delete($id) {
        $participation = Participation::find($id);

        if ($participation) {
            try {
                Participation::delete($id);
                unset($participation);
                Redirect::to('/participation/index', array($message => 'Participation has been deleted'));
            } catch (Exception $e) {
                
            }
        }
    }

    public static function index() {
        View::make('/participation/index.html');
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'tournament' => $params['tournament'],
            'entry_date' => date('Y/m/d')
        );

        $participation = new Participation($attributes);
        $errors = $participation->errors();

        if (count($errors) == 0) {
            $participation->save();
            Redirect::to('/player/index', array('message' => 'Participation has been added'));
        } else {
            throw new Exception("Tournament can't be joined");
        }
    }

}
