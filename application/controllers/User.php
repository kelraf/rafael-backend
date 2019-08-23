<?php
defined('BASEPATH') or exit('No direct script access allowed');

    class User extends CI_Controller {
 
        public function __construct() {
            parent::__construct();
            header("Content-Type: application/json; charset=UTF-8");
            $this->load->model("user_infor/userinfor");
        }

        public function register() {
            // Collect Data
            $data = json_decode(file_get_contents("php://input"), true);

            $this->userinfor->email = $data["email"];
            $this->userinfor->passw = $data["password"];
            $this->userinfor->conf_passw = $data["confirm_password"];

            $done = $this->userinfor->register();

            echo json_encode($done);
        }

        public function getUser($id) {
            $this->userinfor->id = $id;

            $done = $this->userinfor->getUser();

            echo json_encode($done);
        }
    }


?>