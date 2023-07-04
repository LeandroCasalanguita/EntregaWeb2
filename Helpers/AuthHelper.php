<?php
require_once './ApiControllers/api_user_controller.php';

class Auth_user{
    private $controller_user;
    private $key;

    public function __construct(){
        $this->controller_user = new user_controller;
        $this->key = "Transporte";
    }

    //comprobamos el usuario
    public function checkuser(){
        $header = $this->controller_user->getHeader();
        if(strpos($header,"Bearer ")===0){
            $token=explode(" ",$header)[1];
            $desrm=explode(".",$token);
            if(count($desrm)==3){
                $header=$desrm[0];
                $payload=$desrm[1];
                $firma=$desrm[2];
                $newfirma=$this->controller_user->base64url_encode(hash_hmac("SHA256","$header.$payload",$this->key,true));
                if($firma==$newfirma){
                    $payload=json_decode(base64_decode($payload));
                    return $payload;
                }
            }

        }
        return null;
    }
}