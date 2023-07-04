<?php
class truck_load_model {
    private $db;
    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_transport;charset=utf8', 'root', '');
    }
    public function getAll($orderby,$atributo,$orden) {
        $sql = "SELECT truck_load.id_load, truck_load.type_load, truck_load.value FROM truck_load $orderby $atributo $orden";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ); 
    }
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM truck_load WHERE `id_load` = ?");
        $query->execute([$id]);
    }
    public function getOne($id){
        $query = $this->db->prepare("SELECT * FROM truck_load WHERE truck_load.id_load = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function update($type_load,$value,$id){
        $query = $this->db->prepare("UPDATE truck_load SET type_load= ?, value=? WHERE id_load=?");
        $query->execute([$type_load,$value,$id]);
    }
    public function add($type_load,$value){
        $query= $this->db->prepare("INSERT INTO `truck_load` (`type_load`, `value`) VALUES (?,?)");
        $query->execute([$type_load,$value]);
        return $this->db->lastInsertId();
    }
}