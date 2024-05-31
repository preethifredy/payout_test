<?php

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function add_user() {
        if ($this->input->post('username')) {
            $this->form_validation->set_rules('username', 'Username', 'required|max_length[50]');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $data = [
                    'name' => $this->input->post('username'),
                    'status' => 1,
                ];
                if ($this->user_model->add_data('users',$data)) {
                    echo "User added successfully.";
                } else {
                    echo "Failed to add user.";
                }
            }
        }
            $this->load->view('add_user');

    }

    public function add_user_hierarchy() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('user_id', 'User', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('parent_id', 'Parent', 'required|is_natural');
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $user_id=$this->input->post('user_id');
                $data = [
                    'user_id ' => $this->input->post('user_id'),
                    'parent_id ' => $this->input->post('parent_id'),
                    'status' => 1,
                ];
                if ($this->user_model->add_data('user_hierarchy', $data)) {
                    echo 'Affiliation added successfully';
                    $this->view_hierarchy($user_id);
                } else {
                    echo 'Failed to add affiliation';
                }
            }
        }
        $info['users'] = $this->user_model->get_data('users','id,name');
        $where="id in(select user_id from user_hierarchy where status=1)";
        $info['parent'] = $this->user_model->get_data('users','id,name',$where);
        $this->load->view('add_user_hierarchy',$info);
    }

    public function record_sale() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('user_id', 'User', 'required|is_natural_no_zero');
            $this->form_validation->set_rules('amount', 'Amount', 'required|is_natural');
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $data = [
                    'user_id' => $this->input->post('user_id'),
                    'amount' => $this->input->post('amount'),
                    'added_on'=> date('Y-m-d h:i:s'),
                    'status'=>1
                ];
                $sale_id =$this->user_model->add_data('sales', $data);

                if ($sale_id) {
                    $user_id = $data['user_id'];
                    $amount = $data['amount'];
                    if ($this->user_model->calculate_payouts($sale_id, $user_id, $amount)) {
                        echo 'Recorded the sale and payouts are calculated';
                        $this->view_hierarchy($user_id);
                        $this->view_payouts($sale_id);
                    } else {
                        echo 'Failed to calculate payouts';
                    }
                } else {
                    echo 'Failed to record sale';
                }
            }
        }
        $data['users'] =$this->user_model->get_data('users','id,name');
        $this->load->view('record_sale',$data);
    }

    public function view_hierarchy($user_id) {
        if($user_id && is_numeric($user_id)){
            $where=array('id'=>$user_id,'status'=>1);
            $data['user'] = $this->user_model->get_data('users','name',$where);
            $data['hierarchy'] = $this->user_model->user_hierarchy($user_id);
            $this->load->view('view_hierarchy', $data);
        }
        else{
            echo "Incorrect user id";
        }
    }

    public function view_payouts($sale_id) {
        if($sale_id && is_numeric($sale_id)){
            $data['sale_id'] = $sale_id;
            $data['payouts'] = $this->user_model->get_payouts_by_sale($sale_id);
            $this->load->view('view_payouts', $data);
        }
        else{
            echo "Incorrect sale id";
        }
    }
}

?>