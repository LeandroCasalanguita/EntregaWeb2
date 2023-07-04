<?php
require_once './ApiModels/user_model.php';
require_once './ApiView/api_view.php';

class user_controller{
    private $model;
    private $view;
    private $key;

    public function __construct(){
        $this->model = new user_model();
        $this->view = new api_view();
        $this->key = "Transporte";
    }
    public function gettoken(){
        $header=$this->getHeader();
        if(strpos($header,"Basic ")==0){
            $user = explode(" ",$header)[1];
            $user = base64_decode($user);
            $user = explode(":",$user);
            if(count($user)==2){
                $username = $user[0];
                $password = $user[1];
                if($this->validate($username,$password)){
                    $token=$this->newtoken($username);
                    $this->view->response("token = $token", 200);
                }
                else{
                    $this->view->response("No es un usuario registrado", 401);
                }
            }
        }
        return null;
    }
    function getHeader(){
        if(isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])){
            return $_SERVER["REDIRECT_HTTP_AUTHORIZATION"];
        }
        if(isset($_SERVER["HTTP_AUTHORIZATION"])){
            return $_SERVER["HTTP_AUTHORIZATION"];
        }
        return null;
    }
    public function validate($username,$password){
        $user = $this->model->checkuser($username);
        if((!empty($user)) && password_verify($password,$user->password)){
            return true;
        }
        else{
            return false;
        }       
    }
    public function newtoken($username){
        $header = $this->base64url_encode(json_encode(array("alg"=>"HS256","typ"=>"JWT")));
        $payload = $this->base64url_encode(json_encode(array("user"=>$username)));
        $firma = $this->base64url_encode(hash_hmac("SHA256","$header.$payload",$this->key,true));
        return "$header.$payload.$firma";   
    }
    public function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}