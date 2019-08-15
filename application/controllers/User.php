<?php
defined('BASEPATH') or exit('No direct script access allowed');

    class User extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

        public function register() {

            echo "Success";
        }
    }


?>