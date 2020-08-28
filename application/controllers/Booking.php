<?php
	class Booking extends CI_Controller{

		public function __construct() {
			Parent::__construct();
			$this->load->model("booking_model");
			$this->load->model("authCookie_model");
			if(!$this->authCookie_model->isLoggedIn()) {
				redirect('imsystem/login');
			}
		}

		public function index() {
			
			$data['instruments'] = $this->instrument_model->list($this->input->post('search'));

			$this->load->view('templates/header');
			$this->load->view('booking/list', $data);
			$this->load->view('templates/footer');
		}

		public function instrument($id) {

			$data['instruments'] = $this->instrument_model->details($id);
			$data['images'] = $this->instrument_model->getImageToken($data['instruments']['image_token']);

			$this->load->view('booking/header');
			$this->load->view('booking/instrument', $data);
			$this->load->view('booking/footer');
		}

		public function reserve() {
			$data['instruments'] = array();
			$this->load->view('templates/header');
			$this->load->view('booking/index', $data);
			$this->load->view('templates/footer');
		}
	}