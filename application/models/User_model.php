<?php
	class User_model extends CI_Model{

        public function list()
        {
            $query = $this->db->get('members');
            return $query->result_array();
        }

        public function getUserIDByName($name) {
            $query = $this->db->get_where('members', array('member_name' => $name));
            return $query->row_array()['member_id'];
        }
 
        public function getUserByID($id) {
            $query = $this->db->get_where('members', array('member_id' => $id));
            return $query->row_array();
        }

        public function details($id)
        {
            $query = $this->db->get_where('members', array('member_id'=>$id));
            return $query->row_array();
        }

        public function activeImage($token, $memberId)
        {
            $data = array(
                "member_id" => $memberId
            );
            $this->db->where('image_token !=', $token);
            $this->db->delete('member_upload', $data);

            $data = array(
                "member_id" => $memberId
            );
            $this->db->where('image_token', $token);
            return $this->db->update('member_upload', $data);
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
            return $this->db->on_duplicate('member_upload', $data);
        }

        public function member_changepass() {

            if ($this->input->post('confpassword') != NULL && $this->input->post('password') != $this->input->post('confpassword')) {
                return false;
            }

            if ($this->input->post('settings') !== NULL) {
                // Check pass
				$password = $this->input->post('oldpassword');
				
				$user = $this->auth_model->getMemberByID($this->input->post('id'));
				if (!password_verify($password, $user["member_password"])) {
					return false;
				}
            }

            $hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $now = date("Y-m-d H:i:s");

            $data = array(
                'member_password' => $hashed_password,
                'member_changepass' => false,
                'updated_at' => $now
            );

            $this->db->where('member_id', $this->input->post('id'));
            return $this->db->update('members', $data);

        }

        public function member_update() {

            $roles = $this->input->post("roles");
        
            if ($this->input->post("roles_mod") !== NULL) {
                $roles |= USER_ROLES['MOD'];
            }
            if ($this->input->post("roles_staff") !== NULL) {
                $roles |= USER_ROLES['STAFF'];
            }
            if ($this->input->post("roles_admin") !== NULL) {
                $roles |= USER_ROLES['ADMIN'];
            }

            $now = date("Y-m-d H:i:s");

            $data = array(
                'member_email' => $this->input->post('email'),
                'member_phonenumb' => $this->input->post('phonenumb'),
                'member_fullname' => $this->input->post('fullname'),
                'member_affiliation' => $this->input->post('affiliation'),
                'updated_at' => $now
            );


            if ($this->input->post("username") !== NULL) {
                $data["member_name"] = $this->input->post('username');
            }

            if ($this->input->post("user_active") !== NULL) {
                $data["member_active"] = true;
            }

            if ($this->input->post("user_changepass") !== NULL) {
                $data["member_changepass"] = true;
            }

            // ผู้แก้ไขที่มี roles เป็น admin สามารถตั้งค่า roles สมาชิกอื่นได้
            if ($this->auth_model->hasFlags($this->auth_model->getMemberRoleByID($this->session->userdata('member_id')), USER_ROLES['ADMIN'])) {
				$data["member_role"] = $roles;
			}

            if ($this->input->post('password') != NULL) {
                if ($this->input->post('confpassword') != NULL && $this->input->post('password') != $this->input->post('confpassword')) {
                    return false;
                }
                $hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $data["member_password"] = $hashed_password;
            }

            $imageToken = $this->user_model->getImageToken($this->input->post('token'));
            if ($imageToken != NULL) {
                // ลบไฟล์เดิมที่ Active แล้ว
                $currentToken = substr($this->getUserByID($this->input->post('id'))['member_profile'], 15, 32);
                $imageData = $this->user_model->getImageToken($currentToken);
                $fileName = $imageData['image_rawname'] . $imageData['image_ext'];
                if (file_exists('./assets/uploads' . $imageData['image_path'] . '/' . $fileName)) {
                    $this->user_model->removeTempImageFromName($fileName);
                    unlink('./assets/uploads' . $imageData['image_path'] . '/' . $fileName);
                }

				$this->user_model->activeImage($this->input->post('token'), $this->input->post('id'));
                $profilePath = $imageToken["image_path"]."/".$imageToken["image_rawname"].$imageToken["image_ext"];
                $data["member_profile"] = $profilePath;

                $this->user_model->clearTempImage();
            }

            $this->db->where('member_id', $this->input->post('id'));
            return $this->db->update('members', $data);
        }

        public function member_add() {

            $roles = 0;
        
            if ($this->input->post("roles_mod") !== NULL) {
                $roles |= USER_ROLES['MOD'];
            }
            if ($this->input->post("roles_staff") !== NULL) {
                $roles |= USER_ROLES['STAFF'];
            }
            if ($this->input->post("roles_admin") !== NULL) {
                $roles |= USER_ROLES['ADMIN'];
            }

            $imageToken = $this->user_model->getImageToken($this->input->post('token'));
            $profilePath = $imageToken["image_path"]."/".$imageToken["image_rawname"].$imageToken["image_ext"];
            $hashed_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

            $data = array(
                'member_name' => $this->input->post('username'),
                'member_password' => $hashed_password,
                'member_email' => $this->input->post('email'),
                'member_active' => $this->input->post('user_active') !== NULL ? true : false,
                'member_changepass' => $this->input->post('user_changepass') !== NULL ? true : false,
                'member_role' => $roles,
                'member_phonenumb' => $this->input->post('phonenumb'),
                'member_fullname' => $this->input->post('fullname'),
                'member_affiliation' => $this->input->post('affiliation'),
                'member_profile' => $profilePath
            );
            
            $this->db->insert('members', $data);

            $insertId = $this->db->insert_id();

            if ($insertId)
                $this->user_model->activeImage($this->input->post('token'), $insertId);

            $this->user_model->clearTempImage();

            return $insertId;
        }

        public function getImageToken($token) {
            $query = $this->db->get_where('member_upload', array('image_token'=>$token));
            return $query->row_array();
        }

        public function clearTempImage() {

            $query = $this->db->get_where('member_upload', array('uploader'=>$this->session->userdata('member_id'), 'member_id' => 0));
            $result = $query->result_array();

            foreach($result as $imageData) {
                $fileName = $imageData['image_rawname'] . $imageData['image_ext'];
                if (file_exists('./assets/uploads' . $imageData['image_path'] . '/' . $fileName)) {
                    $this->user_model->removeTempImageFromName($fileName);
                    unlink('./assets/uploads' . $imageData['image_path'] . '/' . $fileName);
                }
            }
        }

        public function removeTempImageFromName($name) {
            $fileName = explode('.', $name);
            $data = array(
                "image_rawname" => $fileName[0]
            );
            $this->db->delete('member_upload', $data);
        }
	}