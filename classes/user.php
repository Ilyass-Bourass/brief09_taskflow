<?php

class User {
    private $connexion;
    private $table = "users";

    private $id;
    private $name;
    private $email;

    public function __construct($db, $name, $email) {
        $this->connexion = $db;
        $this->name = $name;
        $this->email = $email;
    }

    public function get_id() {
        return $this->id;
    }

    public function get_name() {
        return $this->name;
    }

    public function get_email() {
        return $this->email;
    }

    public function set_id($id){
        $this->id=$id;
    }

    public function set_name($name){
        $this->name=$name;
    }

    public function set_email($email){
        $this->email=$email;
    }

    public function create() {
        $sql = "INSERT INTO " . $this->table . " (name, email) VALUES (:name, :email)";
        $query = $this->connexion->prepare($sql);
        
        return $query->execute([
            ':name' => $this->name,
            ':email' => $this->email
        ]);
    }
    public function getAllUser(){
        $query=$this->connexion->prepare("SELECT id_user, name FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
