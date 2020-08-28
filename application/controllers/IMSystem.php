<?php
	class IMSystem extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('authCookie_model');
			if(!$this->authCookie_model->isLoggedIn() && $this->uri->segment(2) != 'login' && $this->uri->segment(2) != 'frmLogin') {
				redirect('imsystem/login');
			}
		}

		public function index(){
			$data['user'] = $this->user_model->details($this->session->userdata('member_id'));

			$this->load->model("booking_model");
			$data['rent'] = $this->booking_model->getData(NULL, $this->session->userdata('member_id'), -1)->result_array();

			$this->load->view('templates/header');
			$this->load->view('pages/index', $data);
			$this->load->view('templates/footer');
		}
		
		public function updateProfile() {	

			$this->form_validation->set_rules('fullname', 'ชื่อ-นามสกุล', 'required');
			$this->form_validation->set_rules('email', 'ที่อยู่อีเมล', 'required');

			if($this->form_validation->run() === FALSE){

				$data['user'] = $this->user_model->details($this->session->userdata('member_id'));

				$this->load->view('templates/header');
				$this->load->view('pages/index', $data);
				$this->load->view('templates/footer');
			} else {
				if ($this->user_model->member_update()) {
					$this->session->set_flashdata('message', "อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("imsystem");
				}
				else {
					$this->session->set_flashdata('message', "รหัสผ่านไม่ตรงกัน!");
					$this->session->set_flashdata('type', "danger");
					redirect("imsystem");
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

		public function login() {
			if ($this->authCookie_model->isLoggedIn()) {
                redirect('imsystem');
            }
			$this->load->view('templates/auth/header');
			$this->load->view('pages/login');
			$this->load->view('templates/auth/footer');
		}

		public function register(){
			if ($this->authCookie_model->isLoggedIn()) {
                redirect('imsystem');
            }
			$this->load->view('templates/auth/header');
			$this->load->view('pages/register');
			$this->load->view('templates/auth/footer');
		}

		public function frmLogin(){

			if ($this->authCookie_model->isLoggedIn()) {
                redirect('imsystem');
			}
			
			$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/auth/header');
				$this->load->view('pages/register');
				$this->load->view('templates/auth/footer');
			} else {
				$isAuthenticated = false;
    
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				
				$user = $this->auth_model->getMemberByUsername($username);
				if (password_verify($password, $user["member_password"])) {
					$isAuthenticated = true;
				}
				
				if ($isAuthenticated) {

					$this->session->set_userdata(array("member_id" => $user["member_id"]));

					if ($this->input->post('remember') !== NULL) {

						$current_time = time();
						$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);	
					
				   		set_cookie('member_login', $username,  $cookie_expiration_time);   

						$random_password = $this->util_model->getToken(16);
						set_cookie('random_password', $random_password, $cookie_expiration_time);

						$random_selector =$this->util_model->getToken(32);
						set_cookie('random_selector', $random_selector, $cookie_expiration_time);

						$random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
						$random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
						
						$expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

						// mark existing token as expired
						$userToken = $this->auth_model->getTokenByUsername($username, false);
						if (! empty($userToken["id"])) {
							$this->auth_model->markAsExpired($userToken["id"]);
						}
						// Insert new token
						$this->auth_model->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
					} else {
						$this->util_model->clearAuthCookie();
					}
					redirect();
				} else {
					$this->session->set_flashdata('message', "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!");
					$this->session->set_flashdata('type', "danger");
					redirect("imsystem/login");
				}
			}
		}

		public function frmRegister() {

			if ($this->authCookie_model->isLoggedIn()) {
                redirect('imsystem');
			}
			
			$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|is_unique[members.member_name]|regex_match[/^[a-zA-Z0-9_]{4,}/]');
			$this->form_validation->set_rules('email', 'ที่อยู่อีเมล', 'required|is_unique[members.member_email]');
			$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/auth/header');
				$this->load->view('pages/register');
				$this->load->view('templates/auth/footer');
			} else {
				if ($this->auth_model->member_register($this->input->post('email'), $this->input->post('username'), $this->input->post('password'))) {
					$this->session->set_flashdata('message', "สมัครสมาชิกเสร็จสมบูรณ์แล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("imsystem/login");
				}
				else {
					$this->session->set_flashdata('message', "ตรวจพบข้อผิดพลาดในการสมัครสมาชิก โปรดติดต่อผู้ดูแลระบบ!");
					redirect("imsystem/register");
				}
			}
		}

		public function logout() {
			$this->session->unset_userdata('member_id');
			$this->util_model->clearAuthCookie();
			redirect('imsystem/login');
		}

	}