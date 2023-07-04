<?php

    class api_view{


        public function response($data, $code){
            header("Content-Type: application/json");
            header("HTTP/1.1 " . $code . " " . $this-> requestStatus($code));
            echo json_encode($data);
        }

        private function requestStatus($code){
            $status = array(
              200 => "OK",
              201 => "Created",
              400 => "Bad Request",
              401 => "Unauthorized",
              404 => "Not found"
            );
            return (isset($status[$code]))? $status[$code] : $status[500];
          }
    }