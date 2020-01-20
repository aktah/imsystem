<?php
	class User_model extends CI_Model{

        public function list()
        {
            $query = $this->db->get('members');
            return $query->result_array();
        }
        
	}