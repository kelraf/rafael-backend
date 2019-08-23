<?php 

    require_once "BaseUserModel.php";

    class UserInfor extends BaseUserModel {
        

        public function __construct() {
            parent::__construct();
        }

        public function register() {
            $vmail = $this->vMail();
            if(!$vmail["bool"]) {
                return $vmail;
            } else {
                $vpasswords = $this->vPasswords();
                if(!$vpasswords["bool"]) {
                    return $vpasswords;
                } else {
                    $data = [];
                    $data["email"] = $this->email;
                    $data["passw"] = $this->passw;
                    $data["conf_passw"] = $this->conf_passw;
                    $this->db->insert("user", $data);
                    return ["bool" => true, "message" => "Successfully Registered", "data" => $data];
                }
            }

        }

        public function getUser() {
            $done = $this->idExists(true);
            return $done;
        }

        public function updatePassw() {
            
        }
    }

?>