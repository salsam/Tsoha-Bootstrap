<?php

class HelloWorldController extends BaseController {

    public static function index() {
// make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function sandbox() {
        $a = Game::find(1);
        $players = Game::all();
        
        Kint::dump($players);
        Kint::dump($a);
    }

    public static function game_add() {
        View::make('suunnitelmat/game_add.html');
    }

    public static function game_details() {
        View::make('suunnitelmat/game_details.html');
    }

    public static function game_edit() {
        View::make('suunnitelmat/game_edit.html');
    }

    public static function game_history() {
        View::make('suunnitelmat/game_history.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function organizer_edit() {
        View::make('suunnitelmat/organizer_edit.html');
    }

    public static function organizer_register() {
        View::make('suunnitelmat/organizer_register.html');
    }

    public static function player_edit() {
        View::make('suunnitelmat/player_edit.html');
    }

    public static function register() {
        View::make('suunnitelmat/register.html');
    }

    public static function tournament_details() {
        View::make('suunnitelmat/tournament_details.html');
    }

    public static function tournament_list() {
        View::make('suunnitelmat/tournament_list.html');
    }

}
