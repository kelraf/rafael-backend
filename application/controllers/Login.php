<?php 
    defined('BASEPATH') or exit('No direct script access allowed');

    class Login extends CI_Controller {

        public function __construct() {
            parent::__construct();
            header("Content-Type: application/json; charset=UTF-8");
            $this->load->model("user_infor/logger");
        }

        public function login() {
            $data = json_decode(file_get_contents("php://input"), true);

            $this->logger->email = $data["email"];
            $this->logger->passw = $data["password"];
            $done = $this->logger->login();
            echo json_encode($done);
        }
    }

?>