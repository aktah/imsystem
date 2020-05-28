<?php
	class Instrument_model extends CI_Model{

        public function list()
        {
            /*if (!$showAll) {
                $this->db->where('ins_status = 1');
            }*/

            $query = $this->db->get('instruments');

            return $query->result_array();
        }

        public function getStorageID($id) {
            $query = $this->db->get_where('store', array('instrument_id'=>$id));
            $storageId = $query->row_array()['storage_id'];
            return $storageId ? $storageId : 0;
        }

        public function getAttendantID($id) {
            $query = $this->db->get_where('store', array('instrument_id'=>$id));
            $attendantId = $query->row_array()['attendant'];
            return $attendantId ? $attendantId : 0;
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

        public function storageList() {
            $query = $this->db->get('storage');
            return $query->result_array();
        }

        public function storage_add() {

            $storageName = $this->input->post('storage_name');

            $data = array(
                'storage_name' => $storageName
            );
            
            $insertId =  $this->db->insert('storage', $data);

            return $insertId;
        }

        public function getAttendantData($instrumentID) {

            $query = $this->db->get_where('store', array('instrument_id' => $instrumentID));

            if ($query->num_rows()) {
                if ($query->row_array()["attendant"] != 0) {
                    return $this->user_model->getUserByID($query->row_array()["attendant"]);
                }
            }

            return NULL;
        }

        public function instrument_update() {

            $now = date("Y-m-d H:i:s");

            $data = array(
                'ins_name' => $this->input->post('name'),
                'ins_description' => $this->input->post('details'),
                'ins_status' => $this->input->post('status') !== NULL ? true : false,
                'ins_unactive' => $this->input->post('unactive') !== NULL ? true : false,
                'image_token' => $this->input->post('token'),
                'ins_updatedAt' => $now
            );

            $imageToken = $this->instrument_model->getImageToken($this->input->post('token'));
            if ($imageToken != NULL) {
				$this->instrument_model->activeImage($this->input->post('token'), $this->input->post('id'));
                $this->instrument_model->clearTempImage();
            }

            $this->db->where('ins_id', $this->input->post('id'));
            return $this->db->update('instruments', $data);
        }
        
        public function instrument_add() {

            $data = array(
                'ins_name' => $this->input->post('name'),
                'ins_description' => $this->input->post('details'),
                'ins_status' => $this->input->post('status') !== NULL ? true : false,
                'ins_unactive' => $this->input->post('unactive') !== NULL ? true : false,
                'image_token' => $this->input->post('token'),
            );
            
            $this->db->insert('instruments', $data);

            $insertId = $this->db->insert_id();

            if ($insertId) {
                // Active Image
                $this->instrument_model->activeImage($this->input->post('token'), $insertId);

                // Storage
                if ($this->input->post('instrument_storage') != 0) {
                    $this->instrument_model->StoreInstrument($insertId, $this->input->post('instrument_storage'), $this->input->post('instrument_attendant'));
                }

                $this->instrument_model->clearTempImage();
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

        public function StoreInstrument($id, $storeid, $att)
        {
            $data = array(
                "instrument_id" => $id,
                "storage_id" => $storeid,
                "attendant" => $att
            );
            return $this->db->on_duplicate('store', $data);
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