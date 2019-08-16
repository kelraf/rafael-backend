<?php
// defined('BASEPATH') or exit('No direct script access allowed');

    class Base extends CI_Model {

        public $id;
        public $current_passw;

        public $first_name;
        public $last_name;
        public $email;
        public $phone;

        public $passw;
        public $conf_passw;

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        public function idExists($data=false) {

            $this->id = filter_var($this->id, FILTER_SANITIZE_STRING);

            if(empty($this->id)) {
                return ["bool" => false, "message" => "Oparation Imposible!! Your Id is Required"];
            } else {
                $query = $this->db->get_where("user", ["id" => $this->id]);

                if(!$query) {
                    return ["bool" => false, "message" => "No User With Such Id Is Available"];
                } else {
                    if($data) {
                        return ["bool" => true, "user" => $query];
                    } else {
                        return ["bool" => true];
                    }
                }
            }
        }

        public function vMail() {

            // Sanitize email
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return ["bool" => false, "message" => "Invalid Email"];
            } else {
                return ["bool" => true];
            }

        }

        public function vPasswords($compareExisting=false) {

            if (empty($this->passw)) {
                return ["bool" => false, "message" => "Password Field Required"];
            } elseif (empty($this->conf_passw)) {
                return ["bool" => false, "message" => "Confirm Password Field Required"];
            } elseif (strlen($this->passw) < 6) {
                return ["bool" => false, "message" => "Your Password should not be less than six Characters"];
            } elseif ($this->passw != $this->conf_passw) {
                return ["bool" => false, "message" => "Your Passwords Must Match"];
            } else {
                if ($compareExisting) {

                    $data = $this->idExists(true);
                    if ($data["bool"]) {
                        $user = $data["user"];

                        if (!password_verify($this->current_passw, $user["passw"])) {
                            return ["bool" => false, "message" => "Current Password is Invalid"];
                        } else {
                            $this->passw = password_hash($this->passw, PASSWORD_DEFAULT);
                            $this->conf_passw = password_hash($this->conf_passw, PASSWORD_DEFAULT);
                            return ["bool" => true];
                        }
                    } else {
                        return $data;
                    }
                } else {
                    $this->passw = password_hash($this->passw, PASSWORD_DEFAULT);
                    $this->conf_passw = password_hash($this->conf_passw, PASSWORD_DEFAULT);
                    return ["bool" => true];
                }
            }
        }

    }

?>