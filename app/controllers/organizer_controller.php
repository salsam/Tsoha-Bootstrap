<?php

class OrganizerController extends BaseController {

    public static function create() {
        View::make('organizer/new.html');
    }

    public static function store() {
        $params = $_POST;

        $organizer = new Organizer(array(
            'oname' => $params['oname'],
            'password' => $params['pword'],
            'email' => $params['email']
        ));

        $organizer->save();
        Redirect::to('/organizer/' . $organizer->organizer_id, array('message', 'Organizer has been added!'));
    }

}
