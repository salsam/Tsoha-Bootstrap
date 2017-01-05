<?php

class Participation extends BaseModel {
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query=DB::connection()->prepare('SELECT * FROM Participation WHERE player=:id');
         $query->execute('id'=>  BaseController::get_user_logged_in());
    }
    
    
}

