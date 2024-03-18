<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->primary_key = 'id'; 
  }

  function tableData($params = array(), $condition = array())
  {

    if (!empty($condition['where'])) {
      $params['where'] = $condition['where'];
    }
    if (!empty($condition['like'])) {
      $params['like'] = $condition['like'];
    }
    if (!empty($condition['sort_by'])) {
      $params['sort_by_column'] = $condition['sort_by']['sort_by_column'];
      $params['sort_by_val'] = $condition['sort_by']['sort_by_val'];
    }
    $adsList = $this->getRows($params);
    return $adsList;
  }

  function getRows($params = array())
  {

    $this->db->select('map.id,c.name,GROUP_CONCAT(d.device_id) as device_id');
    $this->db->from('tbl_customer_device_map as map');
    $this->db->join('tbl_customers as c', 'c.id = map.customer_id');
    $this->db->join('tbl_devices as d', 'FIND_IN_SET(d.id, map.device_id)', 'left');
    $this->db->group_by("map.id");

    if (array_key_exists("where", $params)) {
      foreach ($params['where'] as $key => $val) {
        $this->db->where($key, $val);
      }
    }
    if (array_key_exists("like", $params)) {
      $search_keyword = $params['like'];
      $this->db->like('c.name', $search_keyword);
      $this->db->or_like('map.id', $search_keyword);
      $this->db->or_like('map.device_id', $search_keyword);
    }
    if (array_key_exists("sort_by_column", $params) && array_key_exists("sort_by_val", $params)) {
      $this->db->order_by("map.".$params['sort_by_column'],  $params['sort_by_val']);
    }
    if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
      $result = $this->db->count_all_results();
    } else {
      if (array_key_exists("map.id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')) {
        if (!empty($params['id'])) {
          $this->db->where('map.id', $params['id']);
        }
        $query = $this->db->get();
        $result = $query->row_array();
      } else {

        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
          $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
          $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
      }
    }

    return $result;
  }

  function getCount()
  {

    $conditions['returnType'] = 'count';
    return $count = $this->tableData($conditions);
  }
}