<?php

class M_employee extends CI_Model {
    
    private $table          = 'employee';
    private $primary_key    = 'id_employee';
    
    function __construct() {
        parent::__construct();
    }
    function read($limit = 10, $offset = 0, $order_column = '', $order_type = '',$where='') {
        if (!empty($where)){
            $query = $this->db->where($where);
        }
        if (!empty($order_column) && !empty($order_type)) {
            $this->db->order_by($order_column, $order_type);
        } elseif (empty($order_column) && !empty($order_type)) {
            $this->db->order_by($this->primary_key, $order_type);
        } else {
            $this->db->order_by($this->primary_key, 'asc');
        }
        if ($limit != 0){
            $query = $this->db->limit($limit, $offset);
        }
        $query = $this->db
                ->get($this->table);
        return $query;
    }
    function getjoin($id_employee){
        $this->db->where('id_employee', $id_employee);
        return $this->db->get($this->table);
    }
    function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    function update($id,$data) {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }
    function delete($id) {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }
}

?>
