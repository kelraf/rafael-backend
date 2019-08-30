<?php 

    require_once "BaseUserModel.php";

    class UserInfor extends BaseUserModel {
        

        public function __construct() {
            parent::__construct();
        }

        public function register() {
            $vmail = $this->vMail(true);
            if($vmail["bool"] and $vmail["exists"]) {
                unset($vmail["user"]);
                unset($vmail["exists"]);
                return $vmail;
            } else if (!$vmail["bool"]) {
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

        public function updatePass() {
            $done = $this->vPasswords(true);

            if(!$done["bool"]) {
                return $done;
            } else {
                $data = [];
                $data["passw"] = $this->passw;
                $data["conf_passw"] = $this->conf_passw;
                $this->db->where(["id" => $this->id]);
                $this->db->update("user", $data);
                return ["bool" => true, "message" => "Successfully Updated Password"];
            }
        }

        public function updateMail() {
            $idexists = $this->idExists();
            if(!$idexists["bool"]) {
                return $idexists;
            } else {
                $vmail = $this->vMail(true, true);
                if($vmail["bool"] and $vmail["exists"]) {
                    // unset($vmail["user"]);
                    unset($vmail["exists"]);
                    return $vmail;
                } elseif (!$vmail["bool"]) {
                    return $vmail;
                } else {
                    $this->db->where(["id" => $this->id]);
                    $this->db->update("user", ["email" => $this->email]);
                    return ["bool" => true, "message" => "Successfully Updated Your Email"];
                }
            }
        }

        public function updateNames() {
            $check_id = $this->idExists();
            if(!$check_id["bool"]) {
                return $check_id;
            } else {
                $vnames = $this->vNames();
                if(!$vnames["bool"]) {
                    return $vnames;
                } else {
                    $data = [];
                    $data["first_name"] = $this->first_name;
                    $data["last_name"] = $this->last_name;
                    $this->db->where(["id" => $this->id]);
                    $this->db->update("user", $data);
                    return ["bool" => true, "message" => "Successfully Updated Names"];
                }
            }
            
        }

        public function updatePhone() {
            $check_id = $this->idExists();

            if(!$check_id["bool"]) {
                return $check_id;
            } else {
                $vphone = $this->vPhone();
                if(!$vphone["bool"]) {
                    return $vphone;
                } else {
                    $this->db->where(["id" => $this->id]);
                    $this->db->update("user", ["phone" => $this->phone]);
                    return ["bool" => true, "message" => "Successfully Updated Your Phone Number"];
                }
            }
        }
    }

?>