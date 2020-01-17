<?php
	class Auth_model extends CI_Model{

        public function __construct(){
			$this->load->database();
        }
        
        public function getMemberByUsername($username) {
            $query = $this->db->get_where('members', array('member_name' => $username));
            return $query->row_array();
        }
        
        public function getMemberByID($username) {
            $query = $this->db->get_where('members', array('member_id' => $username));
            return $query->row_array();
        }

        public function getTokenByUsername($username,$expired) {
            $query = $this->db->get_where('tbl_token_auth', array('username' => $username, 'is_expired' => $expired));
            return $query->row_array();
        }

        public function markAsExpired($tokenId) {
            $data = array(
				'is_expired' => true
			);
			$this->db->where('id', $tokenId);
			return $this->db->update('tbl_token_auth', $data);
        }

        public function insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date) {
            $data = array(
                'username' => $username,
                'password_hash' => $random_password_hash,
                'selector_hash' => $random_selector_hash,
                'expiry_date' => $expiry_date
			);
            return $this->db->insert('tbl_token_auth', $data);
        }

        public function member_register($email, $username, $password) {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = array(
                'member_name' => $username,
                'member_password' => $hashed_password,
                'member_email' => $email
            );
            
            return $this->db->insert('members', $data);
        }
	}