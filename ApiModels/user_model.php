<?php
class user_model{
    private $db;
    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_transport;charset=utf8', 'root', '');
    }
    public function checkuser($username){
        $query = $this->db->prepare('SELECT * FROM user WHERE username=?');
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function insertUser($username, $password, $email){
        $query = $this->db->prepare("INSERT INTO user (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $query->execute(array($username,$password,$email));
    }
}