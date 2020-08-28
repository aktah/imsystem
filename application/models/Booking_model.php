<?php
	class Booking_model extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		// status: -1 = All, 0 - Wait for approve, 1 - Approval, 2 - Denied
		public function getData($instrumentID, $memberID, $status = -1) {

			$this->db->join('instruments', 'instruments.ins_id = rent_range.instrument_id', 'left');
			$this->db->join('rent', 'rent.id = rent_range.id', 'left');

			if ($instrumentID !== NULL) {
				$this->db->where('rent_range.instrument_id', $instrumentID);
			}
			if ($memberID !== NULL) {
				$this->db->where('rent.member_id', $memberID);
			}
			if ($status != -1) {
				$this->db->where('rent_range.status', $status);
			}
			return $this->db->get('rent_range');
		}
		
		public function list($instrumentID) {
			$this->db->where('instrument_id', $instrumentID);
			return $this->db->get('rent_range');
		}

        public function isExists($instrumentID, $startDate, $endDate) {
			$this->db->where('startDate >=', $startDate);
			$this->db->where('endDate <=', $endDate);
			$this->db->where('instrument_id', $instrumentID);
			return $this->db->get('rent_range');
		}

		public function booking($instrumentID, $memberID, $event) {
			
			$this->db->insert('rent', array('member_id' => $memberID));
			$rent = $this->db->insert_id();

			foreach ($event as $e) {
				$data = array(
					'id' => $rent,
					'instrument_id' => $instrumentID,
					'startDate' => $e['startStr'],
					'endDate' => $e['endStr']
				);
				$this->db->insert('rent_range', $data);
			}
			
			return $rent;
		}
	}