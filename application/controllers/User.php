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

        public function updatePass() {
            $data = json_decode(file_get_contents("php://input"), true);

            $this->userinfor->id = $data["id"];
            $this->userinfor->current_passw = $data["current_password"];
            $this->userinfor->passw = $data["password"];
            $this->userinfor->conf_passw = $data["confirm_password"];

            $done = $this->userinfor->updatePass();

            echo json_encode($done);

        }

        public function updateMail() {
            $data = json_decode(file_get_contents("php://input"), true);

            $this->userinfor->id = $data["id"];
            $this->userinfor->email = $data["email"];
            $done = $this->userinfor->updateMail();

            echo json_encode($done);
        }

        public function updateNames() {
            $data = json_decode(file_get_contents("php://input"), true);

            $this->userinfor->id = $data["id"];
            $this->userinfor->first_name = $data["first_name"];
            $this->userinfor->last_name = $data["last_name"];
            $done = $this->userinfor->updateNames();

            echo json_encode($done);

        }
    }


?>