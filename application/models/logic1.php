<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logic extends CI_Model
{
	function global_insert($table_name, $data)
        {
            $this->db->insert($table_name, $data);
            return mysql_insert_id();
        }
        
        function global_where($table_name, $field_value)
        {
            $this->db->where($field_value);
            return $this->db->get($table_name);
        }
        function global_where_limit($table_name, $field_value, $start, $end)
        {
            $this->db->where($field_value);
            $this->db->limit($start, $end);
            return $this->db->get($table_name);
        }
        function global_update($table_name, $field, $value, $data)
        {
            $this->db->where($field, $value);
            $this->db->update($table_name, $data);
            return mysql_insert_id();
        }
        function where_join($field_value)
        {
            $this->db->select( 'account_holder.*, deposit_amount.*, lot_detail.*, opening_amount.*, opening_amount.depositor_id as dep_id, deposit_amount.remark as dep_remark');
            $this->db->from('users');
            $this->db->join('account_holder', 'account_holder.agent_id = users.id', 'left');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id','left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id =account_holder.id', 'left');
            $this->db->join('lot_detail', 'lot_detail.id = deposit_amount.lot_id', 'left');
            $this->db->where($field_value);
            return $this->db->get();
        }
        function where_join_limit($field_value, $start, $end)
        {
            $this->db->select( 'account_holder.*, deposit_amount.*, lot_detail.*, opening_amount.*, opening_amount.depositor_id as dep_id, deposit_amount.remark as dep_remark');
            $this->db->from('users');
            $this->db->join('account_holder', 'account_holder.agent_id = users.id', 'left');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id','left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id =account_holder.id', 'left');
            $this->db->join('lot_detail', 'lot_detail.id = deposit_amount.lot_id', 'left');
            $this->db->where($field_value);
            $this->db->limit($start, $end);
            return $this->db->get();
 
        }
        /*join opeing amount and deposit amount */
        function get_amount($field, $value, $sum_filed)
        {
            //$this->db->select('deposit_amount.*');
            $this->db->select_sum($sum_filed);
            $this->db->from('opening_amount');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = opening_amount.depositor_id');
            $this->db->where($field, $value);
            return $this->db->get();
        }
        /*get lot amount */
        function get_lot_amount($field, $lot_id)
        {
            $this->db->select_sum('amount_deposited');
            $this->db->from('deposit_amount');
            $this->db->join('lot_detail','lot_detail.lot_no=deposit_amount.lot_id');
            $this->db->where($field, $lot_id);
            return $this->db->get();
        }
        
        
        /* calculation of month */
        function cal_month($field, $value)
        {
            $this->db->select('deposit_amount.*, account_holder.*, opening_amount.*');
            $this->db->from('account_holder');
            $this->db->join('deposit_amount', 'deposit_amount.depositor_id = account_holder.id', 'left');
            $this->db->join('opening_amount', 'opening_amount.depositor_id = account_holder.id', 'left');
            $this->db->where($field, $value);
            $this->db->order_by('deposit_amount.id', 'desc');
            $this->db->limit(1);
            return $this->db->get();
        }
        
}

/* End of file welcome.php */
/* Location: ./application/models/logic.php */