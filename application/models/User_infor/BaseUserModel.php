<?php
defined('BASEPATH') or exit('No direct script access allowed');

    class BaseUserModel extends CI_Model {

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

        protected function idExists($data=false) {

            $this->id = filter_var($this->id, FILTER_SANITIZE_STRING);

            if(empty($this->id)) {
                return ["bool" => false, "message" => "Oparation Imposible!! Your Id is Required"];
            } else {
                $query = $this->db->get_where("user", ["id" => $this->id])->row_array();

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

        protected function vMail($checkexists = false) {

            // Sanitize email
            $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);

            if(empty($this->email)) {
                return ["bool" => false, "message" => "Email is required"];
            } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                return ["bool" => false, "message" => "Invalid Email"];
            } else {
                if($checkexists) {
                    $data = $this->db->get_where("user", ["email" => $this->email])->result();
                    if(!data) {
                        return ["bool" => false, "message" => "The Email Provided Does Not Exist"];
                    } else { 
                        return ["bool" => true, "user" => $data];
                    }
                } else {
                    return ["bool" => true];
                }
            }

        }

        protected function vPasswords($compareExisting=false) {

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

        public function vNames() {

            if (empty($this->first_name)) {
                return ["bool" => false, "message" => "First Name Is Required"];
            } elseif (empty($this->last_name)) {
                return ["bool" => false, "message" => "Last Name Is Required"];
            } else {

                // Sanitize The Names
                $this->first_name = filter_var($this->first_name, FILTER_SANITIZE_STRING);
                $this->last_name = filter_var($this->last_name, FILTER_SANITIZE_STRING);

                // Remove Any White  Spaces
                $this->first_name = trim($this->first_name);
                $this->last_name = trim($this->last_name);

                if (strLen($this->first_name) < 2 or strLen($this->last_name) < 2 ) {
                    return ["bool" => false, "message" => "Name Should Not Be less Than Two Characters"];
                } else {
                    return ["bool" => true];
                }

            }
            
        }

        public function vPhone() {
            $this->phone = filter_var($this->phone, FILTER_SANITIZE_STRING);
            $this->phone = trim($this->phone);
            if(empty($this->phone)) {
                return ["bool" => false, "message" => "Phone Number Required"];
            } else if (strlen($this->phone) < 10) {
                return ["bool" => false, "message" => "Invalid Phone Number"];
            } else {
                return ["bool" => true];
            }
        }

    }

?>