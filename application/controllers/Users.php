<?php
	class Users extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('authCookie_model');
			if(!$this->authCookie_model->isLoggedIn()) {
				redirect('imsystem/login');
			}

			if($this->session->userdata('changepwd') && $this->uri->segment(2) != 'changepass' && $this->uri->segment(2) != 'changepassword') {
				redirect('users/changepass');
			}
		}
		
		public function index() {

			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['STAFF'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$data['users'] = $this->user_model->list();
			
			$this->load->view('templates/header');
			$this->load->view('users/index', $data);
			$this->load->view('templates/footer');
		}

		public function changepassword() {
			
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
			$this->form_validation->set_rules('confpassword', 'ยืนยันรหัสผ่าน', 'required');

			if($this->form_validation->run() === FALSE){

				$data['user'] = $this->user_model->details($this->session->userdata('member_id'));

				$this->load->view('templates/header');
				$this->load->view('users/changepass', $data);
				$this->load->view('templates/footer');

			} else {
				if ($this->user_model->member_changepass()) {

					$this->session->unset_userdata('changepwd');

					$this->session->set_flashdata('message', "อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					
					redirect("users");
				}
				else {
					$this->session->set_flashdata('message', "รหัสผ่านไม่ตรงกัน!");
					$this->session->set_flashdata('type', "danger");
					redirect("users/changepass");
				}
			}
		}

		public function changepass() {
			$data['user'] = $this->user_model->details($this->session->userdata('member_id'));
			
			if ($data['user']['member_changepass'] == 0) {
				redirect('users');
			}

			$this->load->view('templates/header');
			$this->load->view('users/changepass', $data);
			$this->load->view('templates/footer');
		}

		public function view($id) {

			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['STAFF'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$data['user'] = $this->user_model->details($id);

			if ($data['user']) {
				$this->load->view('templates/header');
				$this->load->view('users/edit', $data);
				$this->load->view('templates/footer');
			}
			else {
				redirect("users");
			}
		}

		public function create() {
			
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['STAFF'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$this->load->view('templates/header');
			$this->load->view('users/create', array());
			$this->load->view('templates/footer');
		}

		public function add() {	
			// print_r($this->input->post(null));

			$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|is_unique[members.member_name]|regex_match[/^[a-zA-Z0-9_]{4,}/]');
			$this->form_validation->set_rules('email', 'ที่อยู่อีเมล', 'required|is_unique[members.member_email]');
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/create');
				$this->load->view('templates/footer');
			} else {
				if ($this->user_model->member_add()) {
					$this->session->set_flashdata('message', "เพิ่มข้อมูลสมาชิกเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("users");
				}
				else {
					$this->session->set_flashdata('message', "เกิดข้อผิดพลาดในการเพิ่มข้อมูลสมาชิก!");
					redirect("users");
				}
			}
		}

		public function update() {	
			// print_r($this->input->post(null));

			$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|regex_match[/^[a-zA-Z0-9_]{4,}/]');
			$this->form_validation->set_rules('email', 'ที่อยู่อีเมล', 'required');

			if($this->form_validation->run() === FALSE){

				$data['user'] = $this->user_model->details($this->input->post('id'));

				$this->load->view('templates/header');
				$this->load->view('users/edit', $data);
				$this->load->view('templates/footer');
				
			} else {
				if ($this->user_model->member_update()) {
					$this->session->set_flashdata('message', "อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("users");
				}
				else {
					$this->session->set_flashdata('message', "เกิดข้อผิดพลาดในการอัปเดตข้อมูลสมาชิก!");
					redirect("users");
				}
			}
		}

		public function uploadimage() {

			$path = "/profiles";

			$config['upload_path']          = './assets/uploads' . $path;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 6000;
			$config['overwrite']     		= TRUE;
			$config['file_name']			= 'user_'.$this->input->post('token');

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('uploadImage'))
			{
				$error = array('error' => $this->upload->display_errors('', ''), '');
				echo json_encode($error);
			}
			else
			{
				$this->user_model->tempImage($path, $this->upload->data()["raw_name"], $this->upload->data()["file_ext"], $this->input->post('token'));
				$data = array('upload_data' => $this->upload->data(), 'baseurl' => base_url(), 'path' => $path);
				echo json_encode($data);
			}
		}

	}