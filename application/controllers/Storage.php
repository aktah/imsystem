<?php
	class Storage extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('authCookie_model');
			if(!$this->authCookie_model->isLoggedIn()) {
				redirect('imsystem/login');
			}
		}
		
		public function add() {	
			// return json style
			// var_dump($this->input->post(null));
			
			$data = array(
				"message"=> "เกิดข้อผิดพลาดบางอย่าง !",
				"type" => "danger",
				"data" => null
			);
			
			echo json_encode($data);
		}

	}