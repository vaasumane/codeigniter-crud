<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerMap extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Store_model");
        $this->header = 'header';
    }

    public function custdevicemap()
    {
        $customers = $this->db->get('tbl_customers')->result_array();
        $devices = $this->db->get('tbl_devices')->result_array();
        $data['header'] = $this->header;
        $data['body'] = 'custdevicemap';
        $data['title'] = 'Customer - Device Map';
        $data['customers'] = $customers;
        $data['devices'] = $devices;

        $this->load->view('frontend-template', $data);
    }
    public function mapDevices()
    {
        $postData = $this->input->post();

        if (!empty($postData["device_id"]) && !empty($postData["customer_name"])) {
            $data = array(
                'device_id' => implode(",", $postData["device_id"]),
                'customer_id' => $postData["customer_name"]
            );
            $this->db->insert('tbl_customer_device_map', $data);
            if ($this->db->insert_id() > 0) {
                $response = array('status' => true, 'message' => 'Map added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => false, 'message' => 'Failed to add map.');
                echo json_encode($response);
            }
        } else {
            $response = array('status' => false, 'message' => 'Data is missing.');
            echo json_encode($response);
        }
    }
    public function getMapDevices()
    {

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search');
        $order = $this->input->get('order');

        $condition = array();
        if (isset($search['value']) && $search['value'] != '') {
            $condition['like'] = $search['value'];
        }
        if (!empty($order)) {
            $order_by_column = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
            $order_by_column_val = $this->input->get('order')[0]['dir'];
            $condition['sort_by']['sort_by_column'] = $order_by_column;
            $condition['sort_by']['sort_by_val'] = $order_by_column_val;
        }
        $param = array('start' => $start, 'limit' => $limit);
        $map_data = $this->Store_model->tableData($param, $condition);

        if (isset($search['value']) && $search['value'] != '') {

            if (!empty($map_data)) {
                $recordsFiltered = count($map_data);
            } else {
                $recordsFiltered = 0;
            }
        } else {
            $recordsFiltered = $this->Store_model->getCount();
        }
        $result = array();
        if (!empty($map_data)) {
            foreach ($map_data as $key => $value) {
                $value["action"] = "<a href='#' data-id='" . $value["id"] . "' class='btn-edit'>Edit</a>";
                $value["id"] = $key + 1;
                $result[] = $value;
            }
        }
        $response['data'] = $result;
        $response['recordsFiltered'] = $recordsFiltered;
        $response['recordsTotal'] = $this->Store_model->getCount();
        $response['draw'] = $this->input->get('draw');

        echo json_encode($response);
    }
}
