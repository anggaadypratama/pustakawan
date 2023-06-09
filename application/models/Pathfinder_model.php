<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pathfinder_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getData($page = 1, $limit = 20, $criteria = '', &$total_rows = 0)
    {
      $offset = 0;
      if ($page > 1) {
        $offset = ($page*$limit)-1;
      }
      if ($criteria) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);     
        } else {
          $this->db->where($criteria);
        }
      }
      $result = $this->db->get('pathfinder', $limit, $offset);
      
      // get total rows of query
      $this->db->select('COUNT(*) as `total`', false);
      if ($criteria) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);     
        } else {
          $this->db->where($criteria);
        }
      }
      // sort by latest update
      $this->db->order_by('created', 'DESC');
      $total_result = $this->db->get('pathfinder');
      $total_data = $total_result->row();
      $total_rows = $total_data->total;
      
      return $result->result();
    }
    
    public function getDetail($pathfinder_id)
    {
      $this->db->where(array('id' => $pathfinder_id));
      $query = $this->db->get('pathfinder', 1);
      return $query->row();        
    }
    
    public function getConfig($config_name, $unserialized = true, $return_one = false)
    {
      $config = array();
      $this->db->where('config_name', $config_name);
      $result = $this->db->get('config')->result();
      foreach ($result as $config_data) {
        $config[$config_data->config_name] = $unserialized?unserialize($config_data->config_val):$config_data->config_val;
      }
      return $config;
    }
    
    public function setConfig($config_name, $config_value)
    {
      $data['config_name'] = $config_name;
      $data['config_val'] = serialize($config_value);
      $this->db->replace('config', $data);
    }
    
    public function save($data, $is_update = false, $criteria = null)
    {
      if ($is_update) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);    
        } else if (is_array($criteria)) {
          $this->db->where($criteria);
        }
        $this->db->update('pathfinder', $data);
      } else {
        $this->db->insert('pathfinder', $data);
        return $this->db->insert_id();
      }
    }

    public function delete($pathfinder_id)
    {
      $this->db->where('id', $pathfinder_id);
      $this->db->delete('pathfinder');
      // remove all resource relation
      $this->db->where('pid', $pathfinder_id);
      $this->db->delete('pathfinder_resources');
      // delete all config related to this pathfinder
      $this->db->like('config_name', 'pathfinder/'.$pathfinder_id, 'after');
      $this->db->delete('config');
    }
    
    public function addResource($pathfinder_id, $resource_id)
    {
      $data['pid'] = $pathfinder_id;
      $data['rid'] = $resource_id;
      $date = new DateTime();
      $data['created'] = $date->format('Y-m-d H:i:s');
      $this->db->replace('pathfinder_resources', $data);
    }
    
    public function removeResource($pathfinder_id, $resource_id) {
      $this->db->where('pid', $pathfinder_id);
      $this->db->where('rid', $resource_id);
      $this->db->delete('pathfinder_resources');        
    }
}