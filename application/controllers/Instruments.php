<?php
	class Instruments extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->load->model('authCookie_model');
			if(!$this->authCookie_model->isLoggedIn()) {
				redirect('imsystem/login');
			}

			if($this->session->userdata('changepwd')) {
				redirect('users/changepass');
			}
		}

		public function saveState() {
			if ($this->input->post('toggle') == 'true') {
				$this->session->set_userdata('sideToggle', true);
			} else {
				$this->session->unset_userdata('sideToggle');
			}
		}

		public function index() {
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['MOD'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$data['instruments'] = $this->instrument_model->list();

			$this->load->view('templates/header');
			$this->load->view('instruments/index', $data);
			$this->load->view('templates/footer');
		}

		public function list() {
			// POST data
			$postData = $this->input->post('search');

			// Get data
			$data = $this->instrument_model->list($postData);

			foreach($data as $ins ){
				$response[] = array("value"=>$ins['ins_id'],"label"=>$ins['ins_name']);
			}

			echo json_encode($response);
		}

		public function view($id) {
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['MOD'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}
			$this->load->model("storage_model");

			$data['instrument'] = $this->instrument_model->details($id);
			$data['attendant'] = $this->instrument_model->getAttendant($data['instrument']['ins_id']);
			$data['images'] = $this->instrument_model->getImages($data['instrument']['ins_id'], $data['instrument']['image_token']);

			if ($data['instrument']) {
				$this->load->view('templates/header');
				$this->load->view('instruments/instrument', $data);
				$this->load->view('templates/footer');
			}
			else {
				redirect("instruments");
			}
		}

		public function create() {
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['MOD'] | USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}
			$this->load->model("storage_model");
			$this->load->view('templates/header');
			$this->load->view('instruments/create', array());
			$this->load->view('templates/footer');
		}

		public function update() {	

			$this->form_validation->set_rules('name', 'ชื่อเครื่องมือวิจัย', 'required');
			$this->form_validation->set_rules('details', 'รายละเอียด', 'required');

			if($this->form_validation->run() === FALSE){
				$this->view($this->input->post('id'));
			} else {
				if ($this->instrument_model->instrument_update()) {
					$this->session->set_flashdata('message', "อัปเดตข้อมูลเครื่องมือเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("instruments");
				}
				else {
					$this->session->set_flashdata('message', "เกิดข้อผิดพลาดในการอัปเดตข้อมูลเครื่องมือ!");
					redirect("instruments");
				}
			}
		}

		public function unloadimage() {

			$imageData = $this->instrument_model->getImageName($this->input->post('image_name'));
			$fileName = $imageData['image_rawname'] . $imageData['image_ext'];

			if (file_exists('./assets/uploads' . $imageData['image_path'] . '/' . $fileName)) {
				$this->instrument_model->removeTempImageFromName($this->input->post('image_name'));
				unlink('./assets/uploads' . $imageData['image_path'] . '/' . $fileName);
				echo json_encode(array("success"=>"ลบไฟล์ " . $fileName . " สำเร็จ !"));
			} else {
				echo json_encode(array("error"=>"ไม่สามารถลบไฟล์ " . $fileName . " ได้เนื่องจากไม่มีอยู่จริง !"));
			}
		}

		public function uploadimage() {
			
			$path = "/instruments";

			$config['upload_path']          = './assets/uploads' . $path;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 6000;
			$config['overwrite']     		= TRUE;

			$this->load->library('upload', $config);

			$files = $_FILES;
			$result = array();

			for($i=0; $i<count($files['uploadImage']['name']); $i++)
			{
				$_FILES = array();
				foreach( $files['uploadImage'] as $k=>$v )
				{
					$_FILES['uploadImage'][$k] = $v[$i];           
				}

				$ext = explode('.', $_FILES['uploadImage']['name']);

				$_FILES['uploadImage']['name'] = $i.'_'.$this->input->post('token').'.'.$ext[1];
			
				if ( ! $this->upload->do_upload('uploadImage'))
				{
					$error = array('error' => $this->upload->display_errors('', ''), '');
					array_push($result, $error);
				}
				else
				{
					$this->instrument_model->tempImage($path, $this->upload->data()["raw_name"], $this->upload->data()["file_ext"], $this->input->post('token'));
					$data = array('upload_data' => $this->upload->data(), 'baseurl' => base_url(), 'path' => $path);
					array_push($result, $data);
				}
			}
			echo json_encode($result);
		}

		public function add() {	

			if ($this->input->post('cancel') !== NULL) {
				redirect("instruments");
			}
			$this->load->model("storage_model");

			$this->form_validation->set_rules('name', 'ชื่อเครื่องมือวิจัย', 'required');
			$this->form_validation->set_rules('details', 'รายละเอียด', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('instruments/create');
				$this->load->view('templates/footer');
			} else {
				if ($this->instrument_model->instrument_add()) {
					$this->session->set_flashdata('message', "เพิ่มข้อมูลเครื่องมือวิจัยเรียบร้อยแล้ว!");
					$this->session->set_flashdata('type', "success");
					redirect("instruments");
				}
				else {
					$this->session->set_flashdata('message', "เกิดข้อผิดพลาดในการเพิ่มข้อมูลเครื่องมือวิจัย!");
					redirect("instruments");
				}
			}
			
		}

		public function ins_fetch_approve() {
			$data = array();

			$this->load->model("booking_model");
			$query = $this->booking_model->getData(NULL, $this->input->post('member_id'), $this->input->post('status'));
			
			foreach($query->result_array() as $e) {
				array_push($data, array("id" => -1, "title" => $e["ins_name"], "start" => $e["startDate"], "end" => $e["endDate"], "editable" => false));
			}

			echo json_encode($data);
		}
		
		public function ins_fetch() {
			$data = array();

			$this->load->model("booking_model");
			$query = $this->booking_model->list($this->input->post('ins_id'));
			
			foreach($query->result_array() as $e) {
				array_push($data, array("id" => -1, "start" => $e["startDate"], "end" => $e["endDate"], "editable" => false));
			}

			echo json_encode($data);
		}

		public function ins_insert() {

			$data['success'] = false;

			$issuer = $this->session->userdata('member_id');
			$instumentID = $this->input->post('ins_id');
			$raw_data = $this->input->post('data');

			$event = json_decode($raw_data, true);
			
			$this->load->model("booking_model");

			// is exists
			foreach ($event as $e) {

				$result = $this->booking_model->isExists($instumentID, $e['start'], $e['end']);

				if ($result->num_rows()) {
					$value = array(
						'id' => $e['id'],
						'status' => 'เลือกระยะเวลาใหม่อีกครั้ง'
					);
					$data['data'][] = $value;
				}
			}

			if (isset($data['data'])) {
				echo json_encode($data);
				return;
			}

			$this->booking_model->booking($instumentID, $issuer, $event);
			
			$data['success'] = true;

			echo json_encode($data);
		}
	}