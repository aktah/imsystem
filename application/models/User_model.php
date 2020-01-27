<?php
	class User_model extends CI_Model{

        public function list()
        {
            $query = $this->db->get('members');
            return $query->result_array();
        }
        
        public function details($id)
        {
            $this->db->select('member_id, member_name, member_email, member_role, member_rank, member_fullname, member_affiliation, created_at');
            $query = $this->db->get_where('members', array('member_id'=>$id));
            return $query->row_array();
        }
	}