<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Resource_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    

    public function getData($page = 1, $limit = 20, $criteria = '', &$total_rows = 0, $pathfinder_id = 0)
    {
      $offset = 0;
      if ($page > 1) {
        $offset = ($page*$limit)-$limit;
      }
      // real query
      $this->db->select('id, title, authors, subjects, publish_year, publisher, url, location');
      if ($criteria) {
        $this->db->where($criteria, null, false);  
      }
      if ($pathfinder_id) {
        $this->db->join('pathfinder_resources', 'resource.id=pathfinder_resources.rid', 'INNER');
        $this->db->where('pathfinder_resources.pid', $pathfinder_id);
      }
      $this->db->limit($limit, $offset);
      $this->db->order_by('publish_year', 'DESC');
      $result = $this->db->get('resource');
      
      // paging
      if ($criteria) {
        $this->db->where($criteria, null, false);  
      }
      if ($pathfinder_id) {
        $this->db->join('pathfinder_resources', 'resource.id=pathfinder_resources.rid', 'INNER');
        $this->db->where('pathfinder_resources.pid', $pathfinder_id);
      }
      $this->db->select('COUNT(*) as `total`', false);
      $query = $this->db->get('resource');
      $data = $query->row();
      $total_rows = $data->total;

      return $result->result();
    }
    
    public function getDetail($resource_id)
    {
      $this->db->where(array('id' => $resource_id));
      $query = $this->db->get('resource', 1);
      return $query->row();        
    }
    
    public function save($data, $is_update = false, $criteria = null)
    {
      if ($is_update) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);    
        } else if (is_array($criteria)) {
          $this->db->where($criteria);
        }
        $this->db->update('resource', $data);
      } else {
        $this->db->insert('resource', $data);
        return $this->db->insert_id();
      }
    }
    
    public function delete($resource_id)
    {
      $record = $this->getDetail($resource_id);
      $this->db->where(array('id' => $resource_id));
      $this->db->delete('resource');
      // remove file
      if ($record->filename) {
        @unlink('./files/repository/'.$record->filename);
      }
    }
}