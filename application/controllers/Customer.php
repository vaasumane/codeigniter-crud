<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->header = 'header';
    }

    public function customer()
    {
        $data['header'] = $this->header;
        $data['body'] = 'customer';
        $data['title'] = 'Add Customer';

        $this->load->view('frontend-template', $data);
    }
    public function addCustomer()
    {
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $description = $this->input->post('description');

        if (!empty($name) && !empty($mobile) && !empty($email) && !empty($description)) {

            $existingname = $this->db->get_where('tbl_customers', array('name' => $name))->row();

            if ($existingname) {
                $response = array('status' => false, 'message' => 'Customer name already exists.');
                echo json_encode($response);
                return;
            }
            $data = array(
                'name' => $name,
                'mobile_number' => $mobile,
                'email' => $email,
                'description' => $description
            );

            $this->db->insert('tbl_customers', $data);

            if ($this->db->affected_rows() > 0) {
                $response = array('status' => true, 'message' => 'Customer info added successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => false, 'message' => 'Failed to add customer info.');
                echo json_encode($response);
            }
        } else {
            $response = array('status' => false, 'message' => 'Customer data is missing.');
            echo json_encode($response);
        }
    }
    public function getCustomers()
    {
        $draw = $this->input->post("draw");
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order');
        $search = $this->input->post('search')['value'];
        if (!empty($order)) {

            $orderColumnIndex = $this->input->post('order')[0]['column'];
            $orderDirection = $this->input->post('order')[0]['dir'];
            $columns = ['id', 'name', 'mobile_number', 'email'];
            $orderColumnName = $columns[$orderColumnIndex];
        }

        $this->db->select('id,name,mobile_number,email,description');
        $this->db->from('tbl_customers');

        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('mobile_number', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('id', $search);
        }

        $this->db->limit($length, $start);
        if (!empty($order)) {
            $this->db->order_by($orderColumnName, $orderDirection);
        }
        $query = $this->db->get();
        $devices = $query->result_array();

        $totalRecords = $this->db->count_all_results('tbl_customers');

        $this->db->select('id,name,mobile_number,email,description');
        $this->db->from('tbl_customers');
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('mobile_number', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('id', $search);
        }
        $this->db->order_by('tbl_customers');

        $filteredRecords = $this->db->count_all_results();
        $result = array();
        if (!empty($devices)) {
            foreach ($devices as $key => $value) {
                $value["action"] = "<a href='#' data-id='" . $value["id"] . "' class='btn-edit'>Edit</a>";
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

    public function getCustomerDetails()
    {
        $customerId = $this->input->post('customerId');


        $customer = $this->db->get_where('tbl_customers', array('id' => $customerId))->row_array();

        if ($customer) {
            $response = array(
                'status' => true,
                'customer' => $customer
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Customer not found'
            );
        }

        echo json_encode($response);
    }
    public function updateCustomer()
    {
        $customerId = $this->input->post('customerIds');
        $name = $this->input->post('editName');
        $mobile = $this->input->post('editMobile');
        $email = $this->input->post('editEmail');
        $description = $this->input->post('editDescription');

        if ($name  != "" && $mobile != "" && $email != "") {
            $data = array(
                'name' => $name,
                'mobile_number' => $mobile,
                'email' => $email,
                'description' => $description
            );

            $this->db->where('id', $customerId);
            $this->db->update('tbl_customers', $data);

            if ($this->db->affected_rows() > 0) {
                $response = array('status' => true, 'message' => 'Customer info updated successfully.');
                echo json_encode($response);
            } else {
                $response = array('status' => false, 'message' => 'Failed to update customer info.');
                echo json_encode($response);
            }
        } else {
            $response = array('status' => false, 'message' => 'Customer data is missing.');
            echo json_encode($response);
        }
    }
}
