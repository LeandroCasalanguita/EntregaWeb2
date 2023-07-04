<?php
require_once './ApiModels/travel_model.php';
require_once './Helpers/AuthHelper.php';
require_once './ApiView/api_view.php';
    class api_travel_controller{
        private $model;
        private $view;
        private $data;
        private $autentic;
        function __construct(){
            $this->model = new travel_model();
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
                elseif(!empty($_GET['id_travel'])){
                    $this->filter_for($orden);
                }
                elseif(isset($_GET['pag'])&&isset($_GET['amount'])){
                    $this->pag_amount($orden,$atributo,$order);
                }             
                elseif(($_GET['resource']==='travel')){
                    $travels = $this->model->getAll($orden,$atributo,$order);
                    $this->view->response($travels,200);
                }
                else{
                    $this->view->response("No existe respuesta",404);
                }
        }
        public function getOne($params = null){
            $id = $params[':ID'];
            if(is_numeric($id)){
                $travel = $this->model->getOne($id);
                if(!empty($travel)){
                    $this->view->response($travel,200);
                }
                else{
                    $this->view->response("No se encontro el viaje con el id: $id",404);
                }
            }
            else{
                $this->view->response("$id no es un id valido",400);
            }
        }
        public function delete($params = null){
            $id = $params[':ID'];
            if(is_numeric($id)){
                $travel = $this->model->getOne($id);
                if($travel){
                    $this->model->delete($id);
                    $this->view->response("Se borro exitosamente",200);
                }
                else{
                    $this->view->response("No se encontro el viaje $id",404);
                }
            }
            else{
                $this->view->response("$id no es un id valido",400);
            }
            
        }
        public function add(){
            $user=$this->autentic->checkuser();
            if($user!=null){
                $data = $this->getData();
                try{
                    if(!empty($data->id_load) && !empty($data->kilometer) && !empty($data->amount_fuel && !empty($data->truck) && !empty($data->driver))){
                        $id_load = $data->id_load;
                        $kilometer = $data->kilometer;
                        $amount_fuel = $data->amount_fuel;
                        $truck = $data->truck;
                        $driver = $data->driver;
                        $id = $this->model->add($id_load,$kilometer, $amount_fuel,$truck,$driver);
                        $travel = $this->model->getOne($id);
                        if($travel){
                            $this->view->response($travel,201);
                        }
                        else{
                            $this->view->response("No se pudo agregar el viaje",404);
                        }
                    }       
                    else{
                        $this->view->response("Verificar que los datos sean correctos",400);
                    }
                }
                catch (Exception){
                    $this->view->response("$id_load no es una carga valida",404);
                }
            }
            else{
                $this->view->response("No esta autorizado para esta accion",401);
            }   
        }
        public function update($params = null) {
            $user=$this->autentic->checkuser();
            if($user!=null){
                $id = $params[':ID'];
                if(is_numeric($id)){
                $travel = $this->model->getOne($id);
                    if ($travel) {
                        $data = $this->getData();
                        try{
                            if(!empty($data->id_load) && !empty($data->kilometer) && !empty($data->amount_fuel && !empty($data->truck) && !empty($data->driver))){
                                $id_load = $data->id_load;
                                $kilometer = $data->kilometer;
                                $amount_fuel = $data->amount_fuel;
                                $truck = $data->truck;
                                $driver = $data->driver;
                                $this->model->update($id_load,$kilometer,$amount_fuel,$truck,$driver,$id);
                                $travel=$this->model->getOne($id);
                                $this->view->response($travel, 200);
                            }
                            else{
                                $this->view->response("Verificar que los datos sean correctos",400);
                            }
                        }
                        catch(Exception){
                            $this->view->response("$id_load no es una carga valida",404);
                        }
                        
                    }
                    else{
                        $this->view->response("No se encontro el viaje con id: $id",404);
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
        public function orderby(){
            $atributo = strtolower($_GET['atributo']);
            $orden = strtolower($_GET['order']);
            $orderby = "ORDER BY";
            if($atributo=="id_travel"||$atributo=="kilometer"||$atributo=="amount_fuel"||$atributo=="truck"||$atributo=="driver"||$atributo=="id_load"){
                $atributo = ("travel.".$_GET['atributo']);
                if($orden=="desc"|| $orden=="DESC"|| $orden=="asc"|| $orden=="ASC"){
                    $travels = $this->model->getAll($orderby,$atributo,$orden);
                    $this->view->response($travels,200);
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
            if(($_GET['id_travel']=="<"||$_GET['id_travel']==">"||$_GET['id_travel']=="=")&& (is_numeric($_GET['a'])&&((int)$_GET['a'])>0)){
                $atributo = ("travel.id_travel".$_GET['id_travel'].$_GET['a']);
                $orderby = "WHERE";
                $travels = $this->model->getAll($orderby,$atributo,$orden);
                if($travels==[]){
                    $this->view->response("No se encontraron viajes con esa condicion",404);
                }
                else{
                    $this->view->response($travels,200);
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
                $travels = $this->model->getAll($orden,$atributo,$order);
                $amount_travels = count($travels);
                if($amount_travels > $amount){
                    if($pag == 1){
                        $this->mostrar($pag-1,$travels,$amount_travels,$max);
                    }
                    else{
                        $this->mostrar($amount * ($pag - 1),$travels,$amount_travels,$max);
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
        public function mostrar($inicio,$travels,$amount_travels,$max){
            if($amount_travels <= $max && $amount_travels > $inicio){
                for($i=$inicio; $i<$amount_travels; $i++){
                    $travel_pag[]=$travels[$i];
                }
                $this->view->response($travel_pag,200);
            }
            else if($inicio >= $amount_travels){
                $this->view->response("No hay mas viajes",404);
            }
            else{
                for($i=$inicio; $i<$max; $i++){
                    $travel_pag[]=$travels[$i];
                }
                $this->view->response($travel_pag,200);
            }
        } 
    }
//