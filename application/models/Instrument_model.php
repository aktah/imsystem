<?php
	class Instrument_model extends CI_Model{

        public function list($search = NULL)
        {
            /*if (!$showAll) {
                $this->db->where('ins_maintenance = 1');
            }*/
            if ($search !== NULL) {
                $this->db->like('ins_name', $search, 'both'); 
            }
            $query = $this->db->get('instruments');

            return $query->result_array();
        }

		public function notStoreList() {
            $query = $this->db->get_where('instruments', array("ins_store" => NULL));
            return $query->result_array();
		}
  
        public function getImages($id, $token) {
            $query = $this->db->get_where('intrument_upload', array('intrument_id'=>$id, 'image_token'=>$token));
            return $query->result_array();
        }

        public function details($id)
        {
            $this->db->select('*');
            $query = $this->db->get_where('instruments', array('ins_id'=>$id));
            return $query->row_array();
        }

        public function getAttendant($instrumentID) {
            $this->db->join('members', 'members.member_id = instrument_attendant.attendant');
            $query = $this->db->get_where('instrument_attendant', array('instrument_id' => $instrumentID));
            return $query->result_array();
        }

        public function instrument_update() {
            $instrumentID = $this->input->post('id');

            $addStaff = $this->input->post('addStaff') ? json_decode($this->input->post('addStaff'), true) : NULL;
            if ($addStaff) {
                foreach($addStaff as $staff) {

                    $data = array(
                        "instrument_id" => $instrumentID,
                        "attendant" => $staff['id']
                    );
                
                    $this->db->insert('instrument_attendant', $data);
                }
            }

            $removeStaff = $this->input->post('removeStaff') ? json_decode($this->input->post('removeStaff'), true) : NULL;
            if ($removeStaff) {
                foreach($removeStaff as $staff) {

                    $data = array(
                        "instrument_id" => $instrumentID,
                        "attendant" => $staff['id']
                    );
                
                    $this->db->delete('instrument_attendant', $data);
                }
            }

            $now = date("Y-m-d H:i:s");

            $data = array(
                'ins_device' => $this->input->post('device'),
                'ins_abbre' => $this->input->post('abbre'),
                'ins_model' => $this->input->post('model'),
                'ins_name' => $this->input->post('name'),
                'ins_name_en' => $this->input->post('name_en'),
                'ins_description' => $this->input->post('details'),
                'ins_store' => $this->input->post('instrument_storage') == 0 ? NULL : $this->input->post('instrument_storage'),
                'ins_maintenance' => $this->input->post('status') !== NULL ? true : false,
                'ins_inactive' => $this->input->post('unactive') !== NULL ? true : false,
                'image_token' => $this->input->post('token'),
                'ins_updatedAt' => $now
            );

            $imageToken = $this->instrument_model->getImageToken($this->input->post('token'));
            if ($imageToken != NULL) {
				$this->instrument_model->activeImage($this->input->post('token'), $instrumentID);
                $this->instrument_model->clearTempImage();
            }

            $this->db->where('ins_id', $instrumentID);
            return $this->db->update('instruments', $data);
        }
        
        public function instrument_add() {

            $data = array(
                'ins_device' => $this->input->post('device'),
                'ins_abbre' => $this->input->post('abbre'),
                'ins_model' => $this->input->post('model'),
                'ins_name' => $this->input->post('name'),
                'ins_name_en' => $this->input->post('name_en'),
                'ins_description' => $this->input->post('details'),
                'ins_maintenance' => $this->input->post('status') !== NULL ? true : false,
                'ins_inactive' => $this->input->post('unactive') !== NULL ? true : false,
                'ins_store' => $this->input->post('instrument_storage') == 0 ? NULL : $this->input->post('instrument_storage'),
                'image_token' => $this->input->post('token'),
            );
            
            $this->db->insert('instruments', $data);

            $insertId = $this->db->insert_id();

            if ($insertId) {
                // Active Image
                $this->instrument_model->activeImage($this->input->post('token'), $insertId);
                $this->instrument_model->clearTempImage();

                $addStaff = $this->input->post('addStaff') ? json_decode($this->input->post('addStaff'), true) : NULL;
                if ($addStaff) {
                    foreach($addStaff as $staff) {
    
                        $data = array(
                            "instrument_id" => $insertId,
                            "attendant" => $staff['id']
                        );
                    
                        $this->db->insert('instrument_attendant', $data);
                    }
                }
            }

            return $insertId;
        }

        public function clearTempImage() {

            $query = $this->db->get_where('intrument_upload', array('uploader'=>$this->session->userdata('member_id'), 'intrument_id' => 0));
            $result = $query->result_array();

            foreach($result as $imageData) {
                $fileName = $imageData['image_rawname'] . $imageData['image_ext'];
                if (file_exists('./assets/uploads' . $imageData['image_path'] . '/' . $fileName)) {
                    $this->instrument_model->removeTempImageFromName($fileName);
                    unlink('./assets/uploads' . $imageData['image_path'] . '/' . $fileName);
                }
            }
        }

        public function activeImage($token, $intrumentId)
        {
            /*
            $data = array(
                "intrument_id" => $intrumentId
            );
            $this->db->where('image_token != "'. $token . '" AND intrument_id = ' . $intrumentId);
            $this->db->delete('intrument_upload', $data);
            */

            $data = array(
                "intrument_id" => $intrumentId
            );
            $this->db->where('image_token = "'. $token . '" AND intrument_id = 0');
            return $this->db->update('intrument_upload', $data);
        }

        public function tempImage($path, $rawname, $ext, $token)
        {
            $data = array(
                "image_path" => $path,
                "image_rawname" => $rawname,
                "image_ext" => $ext,
                "image_token" => $token,
                "uploader" => $this->session->userdata('member_id')
            );
            return $this->db->on_duplicate('intrument_upload', $data);
        }

        public function getImageToken($token) {
            $query = $this->db->get_where('intrument_upload', array('image_token'=>$token));
            return $query->result_array();
        }

        public function hasImageActive($token) {
            $query = $this->db->get_where('intrument_upload', array('image_token'=>$token, 'intrument_id !=' => 0));
            return $query->num_rows();
        }

        public function getImageName($name) {
            $fileName = explode('.', $name);
            $query = $this->db->get_where('intrument_upload', array('image_rawname'=>$fileName[0], 'image_ext'=> '.' . $fileName[1]));
            return $query->row_array();
        }

        public function removeTempImageFromName($name) {
            $fileName = explode('.', $name);
            $data = array(
                "image_rawname" => $fileName[0]
            );
            $this->db->delete('intrument_upload', $data);
        }
	}