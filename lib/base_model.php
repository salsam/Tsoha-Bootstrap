<?php

class BaseModel {

// "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
// Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
// Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
// ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
// Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
// Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $add = $this->{$validator}();

            $errors = array_merge($errors, $add);
        }
        return $errors;
    }

    public function validate_not_null($param, $field) {
        $errors = array();

        if ($param == null) {
            $errors[] = $field . " can't be null";
        }

        return $errors;
    }

    public function validate_number($num, $field) {
        $errors = array();

        if ($num == null || (!is_numeric($num))) {
            $errors[] = $field . "must contain a number";
        }

        return $errors;
    }

    public function validate_string_min($str, $len, $field) {
        $errors = array();

        if ($str == '' || $str == null) {
            $errors[] = $field . " can't be empty!";
        }

        if (strlen($str) < $len) {
            $errors[] = $field . ' contains too short string! Minimum length: ' . $len;
        }

        return $errors;
    }

    public function validate_string_length($str, $len, $field) {
        $errors = array();

        if ($str == '' || $str == null) {
            $errors[] = $field . " can't be empty!";
        }

        if (strlen($str) > $len) {
            $errors[] = $field . " contains too long string. Please choose a string of length "
                    . $len . "or less!";
        }

        return $errors;
    }

    public function validate_past_date($date, $message) {
        $errors = array();

        if (time() - strtotime($date) < 0) {
            $errors[] = $message;
        }

        return $errors;
    }

    public function validate_future_date($date, $message) {
        $errors = array();

        if (strtotime($date) < time()) {
            $errors[] = $message;
        }

        return $errors;
    }

    public function validate_larger($smaller, $larger, $field1, $field2) {
        $errors = array_merge($this->validate_number($smaller, $field1)
                , $this->validate_number($larger, $field2));

        if (count($errors) == 0) {
            if ($larger < $smaller) {
                $error[] = $field1 . " must be smaller or equal than " . $field2;
            }
        }

        return $errors;
    }

}
