<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Taxonomy_model extends CI_Model {

    public function __construct()
    {
      parent::__construct();
    }
    
    public function getData($taxonomy_type, $page = 1, $limit = 20, $criteria = '', &$total_rows = 0)
    {
      $offset = 0;
      if ($page > 1) {
        $offset = ($page*$limit)-$limit;
      }
      // real query
      $this->db->select('tid, name, vocabulary');
      $this->db->from('taxonomy_term');
      $this->db->where('vocabulary', $taxonomy_type);
      if ($criteria) {
        $this->db->where($criteria, null, false);  
      }
      $this->db->limit($limit, $offset);
      $this->db->order_by('weight');
      // echo $this->db->get_compiled_select();
      $result = $this->db->get();
      
      // paging
      $this->db->where('vocabulary', $taxonomy_type);
      if ($criteria) {
        $this->db->where($criteria, null, false);
      }
      $this->db->select('COUNT(*) as `total`', false);
      $query = $this->db->get('taxonomy_term');
      $data = $query->row();
      $total_rows = $data->total;

      return $result->result();
    }
    
    public function getForSelect($taxonomy_type, $limit = 20, $id_same_with_text = false) {
      $data = array();
      $options = $this->getData($taxonomy_type, 1, $limit);
      foreach ($options as $d) {
        if ($id_same_with_text) {
          $data[$d->name] = $d->name;  
        } else {
          $data[$d->tid] = $d->name;
        }
      }
      return $data;
    }
    
    /**
     * Save taxonomy term
     *
     */
    public function save($data, $is_update = false, $criteria = null)
    {
      if ($is_update) {
        if (is_string($criteria)) {
          $this->db->where($criteria, null, false);    
        } else if (is_array($criteria)) {
          $this->db->where($criteria);
        }
        $this->db->update('taxonomy_term', $data);
      } else {
        $this->db->insert('taxonomy_term', $data);
      }
    }

    /**
     * Delete term data
     *
     */    
    public function delete($term_id)
    {
      $this->db->where(array('tid' => $term_id));
      $this->db->delete('taxonomy_term');
    }
}