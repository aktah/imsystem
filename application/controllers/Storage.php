<?php
	class Storage extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('authCookie_model');
			if(!$this->authCookie_model->isLoggedIn()) {
				redirect('imsystem/login');
			}

			if($this->session->userdata('changepwd')) {
				redirect('users/changepass');
			}

			$this->load->model('storage_model');

		}

		public function index() {
			$data = array();

			$data['storages'] = $this->storage_model->list();

			$this->load->view('templates/header');
			$this->load->view('pages/storage', $data);
			$this->load->view('templates/footer');
		}

		public function lookup($storageID) {
			$data = array();

			$data['storage'] = $this->storage_model->details($storageID)[0];

			if (!$data['storage']) {
				redirect('storage');
			}
			$this->load->view('templates/header');
			$this->load->view('pages/storage_details', $data);
			$this->load->view('templates/footer');
		}

		public function update() {
			if ($this->input->post('delStorage') !== NULL) {
				$this->storage_model->remove();
			} 
			else if ($this->input->post('createStorage') !== NULL) {
				$name = $this->input->post('name');
				$this->storage_model->add($name);
			} else {
				$this->storage_model->update();
			}
			redirect('storage');
		}

		public function create() {
			$this->load->view('templates/header');
			$this->load->view('pages/storage_details');
			$this->load->view('templates/footer');
        }
		
		public function add() {	
			// return json style
			// var_dump($this->input->post(null));

			$name = $this->input->post('storage_name');
			
			$id = $this->storage_model->add($name);

			if (!$id) {
				$data = array(
					"message"=> "เกิดข้อผิดพลาดบางอย่าง !",
					"type" => "danger",
					"data" => null
				);
			} else {
				$data = array(
					"message"=> "สำเร็จ !",
					"type" => "success",
					"data" => json_encode(array("id" => $id, "name" => $name))
				);
			}
			
			echo json_encode($data);
		}

	}