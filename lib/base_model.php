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

            if ($add != NULL and is_array($add)) {
                $errors = array_merge($errors, $add);
            }
        }
        return $errors;
    }

    public function validate_not_null($param) {
        $errors = array();

        if ($param == null) {
            $errors[] = "Attribute can't be null";
        }

        return $errors;
    }

    public function validate_number($num) {
        $errors = array();

        if ($num == null || (!is_numeric($num))) {
            $errors[] = $num . ' is not a number!';
        }

        return $errors;
    }

    public function validate_string_min($str, $len) {
        $errors = array();

        if ($str == '' || $str == null) {
            $errors[] = "Field can't be empty!";
        }

        if (strlen($str) < $len) {
            $errors[] = $str . ' is too short! Minimum length: ' . $len;
        }

        return $errors;
    }

    public function validate_string_length($str, $len) {
        $errors = array();

        if ($str == '' || $str == null) {
            $errors[] = "Field can't be empty!";
        }

        if (strlen($str) > $len) {
            $errors[] = $str . ' is too long! Please choose a string of length ' . $len . 'or less!';
        }

        return $errors;
    }

    public function validate_past_date($date) {
        $errors = array();

        if (time() - strtotime($date) < 0) {
            $errors[] = 'Date hasn"t been reached yet';
        } else if ((time() - strtotime($date)) / 60 / 60 / 24 / 365 > 100) {
            $errors[] = 'Date must be within last 100 years';
        }

        return $errors;
    }

    public function validate_future_date($date) {
        $errors = array();

        if (strtotime($date) < time()) {
            $errors[] = 'Date has to be in future';
        }

        return $errors;
    }

}
