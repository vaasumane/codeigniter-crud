<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->header   = 'header';
    }
    public function index()
    {

        $data['header'] = $this->header;
        $data['body'] = 'devices';
        $data['title'] = 'Add Devices';

        $this->load->view('frontend-template', $data);
    }
    public function addDevice()
    {
        $postData = $this->input->post();

        if (!empty($postData["device_id"]) && !empty($postData["device_name"])) {

            $existingDevice = $this->db->get_where('tbl_devices', array('device_id' => $postData["device_id"]))->row();

            if ($existingDevice) {
                $response = array('status' => false, 'message' => 'Device with this ID already exists.');
                echo json_encode($response);
                return;
            }

            $existingDeviceName = $this->db->get_where('tbl_devices', array('device_name' => $postData["device_name"]))->row();

            if ($existingDeviceName) {
                $response = array('status' => false, 'message' => 'Device name already exists.');
                echo json_encode($response);
                return;
            }
            $data = array(
                'device_id' => $postData["device_id"],
                'device_name' => $postData["device_name"]
            );

            $this->db->insert('tbl_devices', $data);

            if ($this->db->insert_id()) {
                $response = array('status' => true, 'message' => 'Device added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => false, 'message' => 'Failed to add device.');
                echo json_encode($response);
            }
        } else {
            $response = array('status' => false, 'message' => 'Device data is missing.');
            echo json_encode($response);
        }
    }
    public function getDevices()
    {
        $draw = $this->input->post("draw");
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');
        $search = $this->input->post('search')['value'];
        if (!empty($order)) {

            $orderColumnIndex = $this->input->post('order')[0]['column'];
            $orderDirection = $this->input->post('order')[0]['dir'];
            $columns = ['id', 'device_id', 'device_name'];
            $orderColumnName = $columns[$orderColumnIndex];
        }

        $this->db->select('id, device_id, device_name');
        $this->db->from('tbl_devices');

        if (!empty($search)) {
            $this->db->like('device_id', $search);
            $this->db->or_like('device_name', $search);
            $this->db->or_like('id', $search);
        }

        $this->db->limit($length, $start);
        if (!empty($order)) {
            $this->db->order_by($orderColumnName, $orderDirection);
        }
        $query = $this->db->get();
        $devices = $query->result_array();

        $totalRecords = $this->db->count_all_results('tbl_devices');

        $this->db->select('id, device_id, device_name');
        $this->db->from('tbl_devices');
        if (!empty($search)) {
            $this->db->like('device_id', $search);
            $this->db->or_like('device_name', $search);
        }
        $this->db->order_by('tbl_devices');

        $filteredRecords = $this->db->count_all_results();
        $result = array();
        if (!empty($devices)) {
            foreach ($devices as $key => $value) {
                $value["id"] = $key + 1;
                $result[] = $value;
            }
        }
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $result
        ];

        echo json_encode($response);
    }

    

    
}
