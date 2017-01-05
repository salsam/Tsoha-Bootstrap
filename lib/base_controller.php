<?php

class BaseController {

    public static function get_player_logged_in() {
        if (isset($_SESSION['player'])) {
            $player_id = $_SESSION['player'];
            $player = Player::find($player_id);
            return $player;
        }
        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
