<?php
require_once './Helpers/AuthHelper.php';
require_once './ApiModels/truck_load_model.php';
require_once './ApiView/api_view.php';

class api_truck_load_controller{
    private $model;
    private $view;
    private $data;
    private $autentic;

    public function __construct(){
        $this->model = new truck_load_model();
        $this->view = new api_view();
        $this->autentic = new Auth_user;
        $this->data = file_get_contents("php://input");
    }
    
    public function getData() {
        return json_decode($this->data);
    }

    public function getAll(){
        $orden = NULL;
        $atributo = NULL;
        $order = NULL;
            if(!empty($_GET['atributo']) && !empty($_GET['order'])){
                $this->orderby();
            }
            elseif(isset($_GET['value'])&&isset($_GET['a'])){
                $this->filter_for($orden);
            }
            elseif(isset($_GET['pag'])&&isset($_GET['amount'])){
                $this->pag_amount($orden,$atributo,$order);
            }             
            elseif($_GET['resource']==='truck_load'){
                $truck_load = $this->model->getAll($orden,$atributo,$order);
                $this->view->response($truck_load,200);
            }
            else{
                $this->view->response("No existe respuesta",404);
            }
    }
    public function getOne($params = null){
        $id = $params[':ID'];
        if(is_numeric($id)){
            $truck_load = $this->model->getOne($id);
            if(!empty($truck_load)){
                $this->view->response($truck_load,200);
            }
            else{
                $this->view->response("No se encontro el tipo de carga $id",404);
            }
        }
        else{
            $this->view->response("$id no es un id valido",400);
        }
    }
    public function update($params = null) {
        $user=$this->autentic->checkuser();
        if($user!=null){
            $id = $params[':ID'];
            if(is_numeric($id)){
                $truck_load = $this->model->getOne($id);
                if ($truck_load) {
                    $data = $this->getData();
                    if(!empty($data->type_load) && (!empty($data->value)&&is_numeric($data->value))){
                        $type_load = $data->type_load;
                        $value = $data->value;
                        $this->model->update($type_load,$value,$id);
                        $truck_load = $this->model->getOne($id);
                        $this->view->response($truck_load, 200);
                    }
                    else{
                        $this->view->response("Verificar que los datos sean correctos",400);
                    }
                }
                else{
                    $this->view->response("No se encontro la carga con id: $id",404);
                }
            }
            else{
                $this->view->response("$id no es un id valido",400);
            }
        }
        else{
            $this->view->response("No esta autorizado para esta accion",401);
        }   
    }
    public function add(){
        $user=$this->autentic->checkuser();
        if($user!=null){
            $data = $this->getData();
            if(!empty($data->type_load) && (!empty($data->value)&&is_numeric($data->value))){
                $type_load = $data->type_load;
                $value = $data->value;
                $id = $this->model->add($type_load,$value);
                $truck_load = $this->model->getOne($id);
                if($truck_load){
                    $this->view->response($truck_load,201);
                }
                else{
                    $this->view->response("No se pudo agregar la carga",404);
                }
            }       
            else{
                $this->view->response("Verificar que los datos sean correctos",400);
            } 
        }
        else{
            $this->view->response("No esta autorizado para esta accion",401);
        }
    }
    public function delete($params = null){
        $id = $params[':ID'];
        if(is_numeric($id)){
            $truck_load = $this->model->getOne($id);
            if($truck_load){
                $this->model->delete($id);
                $this->view->response("Se borro exitosamente",200);
            }
            else{
                $this->view->response("No se encontro la carga $id",404);
            }
        }
        else{
            $this->view->response("$id no es un id valido",400);
        }
    }
    public function orderby(){
        $atributo = strtolower($_GET['atributo']);
        $orden = strtolower($_GET['order']);
        $orderby = "ORDER BY";
        if($atributo=="id_load" || $atributo=="type_load" || $atributo=="value"){
            $atributo = ("truck_load.".$_GET['atributo']);
            if($orden=="desc"||$orden=="asc"){
                $truck_load = $this->model->getAll($orderby,$atributo,$orden);
                $this->view->response($truck_load,200);
            }
            else{
                $this->view->response("$orden no es un orden valido",400);
            }
        }
        else{
            $this->view->response("$atributo no es un atributo valido",400);
        }
    }
    public function filter_for($orden){
        if(($_GET['value']=="<"||$_GET['value']==">"||$_GET['value']=="=")&& (is_numeric($_GET['a'])&&((int)$_GET['a'])>0)){
            $atributo = ("truck_load.value".$_GET['value'].$_GET['a']);
            $orderby = "WHERE";
            $truck_load = $this->model->getAll($orderby,$atributo,$orden);
            if($truck_load==[]){
                $this->view->response("No se encontraron cargas con esa condicion",404);
            }
            else{
                $this->view->response($truck_load,200);
            }
        }
        else{
            $this->view->response("No se ingresaron los datos correctamente",400);
        }
    }
    public function pag_amount($orden,$atributo,$order){
        $pag = $_GET['pag'];
        $amount = $_GET['amount'];
        if((is_numeric($pag)&&((int)$pag>0))&&(is_numeric($amount)&&((int)$amount)>0)){
            $max = $pag * $amount;
            $truck_load = $this->model->getAll($orden,$atributo,$order);
            $amount_truck_load = count($truck_load);
            if($amount_truck_load > $amount){
                if($pag == 1){
                    $this->mostrar($pag-1,$truck_load,$amount_truck_load,$max);
                }
                else{
                    $this->mostrar($amount * ($pag - 1),$truck_load,$amount_truck_load,$max);
                }
            }
            else{
                $this->view->response("No existen $amount elementos",404);
            }
        }
        else{
            $this->view->response("Los datos ingresados son incorrectos",400);
        }

    }
    public function mostrar($inicio,$truck_load,$amount_truck_load,$max){
        if($amount_truck_load <= $max && $amount_truck_load > $inicio){
            for($i=$inicio; $i<$amount_truck_load; $i++){
                $truck_load_pag[]=$truck_load[$i];
            }
            $this->view->response($truck_load_pag,200);
        }
        else if($inicio >= $amount_truck_load){
            $this->view->response("No hay mas cargas",404);
        }
        else{
            for($i=$inicio; $i<$max; $i++){
                $truck_load_pag[]=$truck_load[$i];
            }
            $this->view->response($truck_load_pag,200);
        }
    }















}

