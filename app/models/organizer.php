<?php

class Organizer extends BaseModel {

    public $organizer_id, $oname, $password, $email;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Organizer');
        $query->execute();
        $rows = $query->fetchAll();
        $organizers = array();

        foreach ($rows as $row) {
            $organizers[] = new Organizer(array(
                'organizer_id' => $row['organizer_id'],
                'oname' => $row['oname'],
                'password' => $row['password'],
                'email' => $row['email']));
        }

        return $organizers;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Organizer '
                . 'WHERE organizer_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $organizer = new Organizer(array(
                'organizer_id' => $row['organizer_id'],
                'oname' => $row['oname'],
                'password' => $row['password'],
                'email' => $row['email']
            ));
            return $organizer;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Organizer (oname, password, email) '
                . 'VALUES (:name, :pass, :email) RETURNING organizer_id');
        $query->execute(array(
            'name' => $this->oname,
            'pass' => $this->password,
            'email' => $this->email
        ));
        $row = $query->fetch();
        $this->organizer_id = $row['organizer_id'];
    }

}
