<?php
	class Storage_model extends CI_Model{
        
		public function __construct(){
			$this->load->database();
        }
        
        public function list() {

            // SELECT storage.*, COUNT(instruments.ins_id) AS instrument_count FROM `storage` LEFT JOIN instruments ON instruments.ins_store = storage.storage_id GROUP BY storage.storage_id
            return $this->db->select('storage.*, COUNT(instruments.ins_id) AS instrument_count')
            ->join('instruments', 'instruments.ins_store = storage.storage_id', 'left')
            ->group_by('storage.storage_id')-> get('storage')->result_array();
        }

        public function storageList() {
            $query = $this->db->get('storage');
            return $query->result_array();
        }

        public function details($id) {
            // SELECT * FROM `storage` LEFT JOIN instruments ON instruments.ins_store = storage.storage_id WHERE `storage_id` = 6
            $raw_data = $this->db->join('instruments', 'instruments.ins_store = storage.storage_id', 'left')
            ->get_where('storage', array("storage.storage_id" => $id))->result_array();

            $storages = [];
            $instrument = [];

            $idx = 0;
            $lastId = 0;

            $temp = array('storage'=>NULL, 'instruments'=>NULL);

            for ($row = 0; $row != count($raw_data); ++$row) {

                $storage_id = $raw_data[$row]['storage_id'];

                if ($storage_id != $lastId) {
                    
                    $storages[$idx] = array(
                        "id" => $storage_id,
                        "name" => $raw_data[$row]['storage_name']
                    );
                    
                    $idx++;
                    $lastId = $storage_id;
                }
    
                $lastInstrument = 0;
                $instrumentID = $raw_data[$row]['ins_id'];
                if ($instrumentID) {
                    
                    if ($lastInstrument != $instrumentID) {
                        $lastInstrument = $instrumentID;
                        
                        $instrument[$idx-1][] = array(
                            "id" => $instrumentID,
                            "name" => $raw_data[$row]['ins_name']
                        );
                    }
                }
            }

            if ($instrument) {
                for ($row = 0; $row != count($storages); ++$row) {
                    if ($instrument[$row]) {
                        $storages[$row]['instruments'] = $instrument[$row];
                    }
                }
            }

            return $storages;
        }

        public function add($name) {
            $data = array(
                "storage_name" => $name
            );
            $this->db->insert('storage', $data);

            $insertid = $this->db->insert_id();

            if ($insertid) {
                $addStorage = $this->input->post('addStorage') ? json_decode($this->input->post('addStorage'), true) : NULL;
                if ($addStorage) {
                    foreach($addStorage as $store) {
    
                        $data = array(
                            "ins_store" => $insertid
                        );
                        $this->db->where('ins_id', $store['id']);
                        $this->db->update('instruments', $data);
                    }
                }
            }

			return $insertid;
        }

        public function remove() {
            $this->db->where('storage_id', $this->input->post('id'));
            return $this->db->delete('storage');
        }

        public function update() {
            $storageID = $this->input->post('id');

            $addStorage = $this->input->post('addStorage') ? json_decode($this->input->post('addStorage'), true) : NULL;
            if ($addStorage) {
                foreach($addStorage as $store) {

                    $data = array(
                        "ins_store" => $storageID
                    );
                    $this->db->where('ins_id', $store['id']);
                    $this->db->update('instruments', $data);
                }
            }

            $removeStorage = $this->input->post('removeStorage') ? json_decode($this->input->post('removeStorage'), true) : NULL;
            if ($removeStorage) {
                foreach($removeStorage as $store) {

                    $data = array(
                        "ins_store" => NULL
                    );
                    $this->db->where('ins_id', $store['id']);
                    $this->db->update('instruments', $data);
                }
            }

            $data = array(
                'storage_name' => $this->input->post('name')
            );

            $this->db->where('storage_id', $storageID);
            return $this->db->update('storage', $data);
        }
	}