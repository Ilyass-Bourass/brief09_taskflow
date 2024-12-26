<?php

class User {
    private $connexion;
    //private $table = "users";

    public $id;
    public $name;
    public $email;

    public function __construct($db) {
        $this->connexion = $db;
    }

    
    public function create() {
        $sql = "INSERT INTO " . $this->table . " (name, email) VALUES (:name, :email)";
        $query = $this->connexion->prepare($sql);
        
        return $query->execute([
            ':name' => $this->name,
            ':email' => $this->email
        ]);
    }
}
