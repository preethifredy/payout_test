<?php
class User_model extends CI_Model {

    public function add_data($table_name,$data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    public function get_data($table,$sel_val,$where='') {
        $this->db->select($sel_val);
        if($where) $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function user_hierarchy($user_id, $level = 1, &$affiliates = []) {
        $this->db->select('user_id, parent_id');
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('user_hierarchy')->row_array();
        //get all users whose parent_id is the current user_id
        if ($result) {
            $affiliates[$level] = $result;
            $this->user_hierarchy($result['parent_id'], $level + 1, $affiliates);
        }
        return $affiliates;
    }

    public function calculate_payouts($sale_id, $user_id, $amount) {
        $this->db->trans_start();

        $affiliates = $this->user_hierarchy($user_id);

        foreach ($affiliates as $level => $affiliate) {
            if ($level > 5 || $affiliate['parent_id']==0 ) break;
            $where=array('level'=>$level,'status'=>1);
            $commission=$this->user_model->get_data('commission','percentage',$where);
            $payout_amount = $amount * ($commission[0]['percentage']/100);
            $payout_data = [
                'user_id' => $affiliate['parent_id'],
                'affiliate_id' => $user_id,
                'sales_id' => $sale_id,
                'amount' => $payout_amount,
                'level' => $level,
                'status'=>1
            ];

            if (!$this->add_data('payouts',$payout_data)) {
                $this->db->trans_rollback();
                return false;
            }
        }

       $this->db->trans_complete();
        return true;
    }

    public function get_payouts_by_sale($sale_id) {
        $this->db->select('payouts.*, users.name as AffiliateName');
        $this->db->from('payouts');
        $this->db->join('users', 'payouts.user_id = users.id');
        $this->db->where('sales_id', $sale_id);
        return $this->db->get()->result_array();
    }
}
?>