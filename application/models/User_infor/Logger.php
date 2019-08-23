<?php 
    defined('BASEPATH') or exit('No direct script access allowed');
    require_once "BaseUserModel.php";
    
    class Logger extends BaseUserModel {

        // public function __contruct() {
        //     parent::__construct();
        // }

        public function login() {
            $is_found = $this->vMail(true);
            if(!$is_found["bool"]) {
                return $is_found;
            } else {
                $user = $is_found["user"];
                if(empty($this->passw)) {
                    return ["bool" => false, "message" => "Password Required"];
                } else if(!password_verify($this->passw, $user["passw"])) {
                    return ["bool" => false, "message" => "Invalid Password"];
                } else {
                    return ["bool" => true];
                }
            }
        }

        public function logout() {}
    }

?>