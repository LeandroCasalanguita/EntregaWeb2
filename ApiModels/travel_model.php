<?php
    class travel_model{
        private $db;
        function __construct(){
            $this->db = new PDO('mysql:host=localhost;'.'dbname=db_transport;charset=utf8', 'root', '');
        }
        public function getAll($orderby,$atributo,$orden){
            $sql = "SELECT travel.id_travel, truck_load.type_load, travel.kilometer,travel.amount_fuel, travel.truck,travel.driver FROM travel INNER JOIN truck_load ON travel.id_load = truck_load.id_load $orderby $atributo $orden";
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ); 
        }
        public function getOne($id){
            $query = $this->db->prepare('SELECT travel.id_travel, truck_load.type_load, travel.kilometer,travel.amount_fuel, travel.truck,travel.driver FROM travel INNER JOIN truck_load ON travel.id_load = truck_load.id_load WHERE id_travel = ?');
            $query->execute([$id]);
            $travel = $query->fetch(PDO::FETCH_OBJ);
            return ($travel);
        }
        public function delete($id){
            $query = $this->db->prepare('DELETE FROM travel WHERE id_travel = ?');
            $query->execute([$id]);
           
        }
        function add($id_load,$kilometer, $amount_fuel,$truck,$driver){
            $query= $this->db->prepare('INSERT INTO travel (id_load,kilometer,amount_fuel,truck,driver) VALUES (?, ?, ?, ?, ?)');
            $query->execute(array($id_load,$kilometer,$amount_fuel,$truck,$driver));
            return $this->db->lastInsertId();
        }
        public function update($id_load,$kilometer,$amount_fuel,$truck,$driver,$id){
            $query = $this->db->prepare('UPDATE travel SET id_load=?, kilometer=?, amount_fuel=?, truck=?, driver=? WHERE id_travel=?');
            $query->execute(array($id_load, $kilometer, $amount_fuel, $truck, $driver, $id));
        }

    }