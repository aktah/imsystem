<?php
	class Instruments extends CI_Controller{
		public function index() {
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$data['instruments'] = $this->instrument_model->list();

			$this->load->view('templates/header');
			$this->load->view('instruments/index', $data);
			$this->load->view('templates/footer');
		}

		public function view($id) {
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}

			$data['instrument'] = $this->instrument_model->details($id);
			$data['storageId'] = $this->instrument_model->getStorageID($data['instrument']['ins_id']);
			$data['attendantId'] = $this->instrument_model->getAttendantID($data['instrument']['ins_id']);
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
			if (!$this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) {
				redirect("imsystem");
				return;
			}
			
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
		
		public function ins_fetch() {
			$data = array();
			array_push($data, array("id" => -1, "start" => "2020-05-24T09:00:00", "end" => "2020-05-26T09:00:00", "editable" => false));
			echo json_encode($data);
		}
	}